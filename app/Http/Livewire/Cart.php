<?php

namespace App\Http\Livewire;

use DB;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Product as ProductModel;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Cart extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $tax = "0%";
    public $search;
    public $payment = 0;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $product = ProductModel::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'DESC')->paginate(8);

        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'taxes',
            'type' => 'tax',
            'target' => 'total',
            'value' => $this->tax,
            'order' => 1
        ]);

        \Cart::session(Auth()->id())->condition($condition);
        $items = \Cart::session(Auth()->id())->getContent()->sortBy(function ($cart){
            return $cart->attributes->get('added_at');
        });

        if (\Cart::isEmpty()) {
            $cartData = [];
        } else {
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'qty' => $item->quantity,
                    'price' => $item->price,
                    'prices' => $item->getPriceSum(),
                ];
            }

            $cartData = collect($cart);
        }

        $subtotal = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();

        $newCondition = \Cart::session(Auth()->id())->getCondition('taxes');
        $taxes = $newCondition->getCalculatedValue($subtotal);

        $summary = [
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => $total
        ];

        return view('livewire.cart', [
            'product' => $product,
            'cart' => $cartData,
            'summary' => $summary
        ]);
    }

    public function addItem($id)
    {
        $rowId = "Cart".$id;
        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItemId = $cart->whereIn('id', $rowId);

        if ($checkItemId->isNotEmpty()) {
            $idProduct = substr($rowId, 4);
            $product = ProductModel::find($idProduct);

            $xcart = \Cart::session(Auth()->id())->getContent();
            $checkItem = $xcart->whereIn('id', $rowId);
            if ($product->qty == $checkItem[$rowId]->quantity) {
                session()->flash('error', 'Out of stock!');
            } else {
                \Cart::session(Auth()->id())->update($rowId, [
                    'quantity' => [
                        'relative' => true,
                        'value' => 1
                    ]
                ]);
            }
        } else {
            $product = ProductModel::findOrFail($id);
            if ($product->qty == 0) {
                session()->flash('error', 'Out of stock!');
            } else {
                \Cart::session(Auth()->id())->add([
                    'id' => "Cart".$product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'attributes' => [
                        'added_at' => Carbon::now()
                    ],
                ]);
            }
            
        }
    }

    public function enableTax()
    {
        $this->tax = "+10%";
    }

    public function disableTax()
    {
        $this->tax = "0%";
    }

    public function increaseItem($rowId)
    {
        $idProduct = substr($rowId, 4);
        $product = ProductModel::find($idProduct);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItem = $cart->whereIn('id', $rowId);

        if ($product->qty == $checkItem[$rowId]->quantity) {
            session()->flash('error', 'Out of stock!');
        } else {
            if ($product->qty == 0) {
                session()->flash('error', 'Out of stock!');
            } else {
                \Cart::session(Auth()->id())->update($rowId, [
                    'quantity' => [
                        'relative' => true,
                        'value' => 1
                    ]
                ]);
            }
        }
    }

    public function decreaseItem($rowId)
    {
        $idProduct = substr($rowId, 4);
        $product = ProductModel::find($idProduct);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItem = $cart->whereIn('id', $rowId);
        
        if ($checkItem[$rowId]->quantity == 1) {
            $this->removeItem($rowId);
        } else {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => -1
                ]
            ]);
        }
    }

    public function removeItem($rowId)
    {
        \Cart::session(Auth()->id())->remove($rowId);
    }

    public function handleSubmit()
    {
        // dd($this->payment);

        $cartTotal = \Cart::session(Auth()->id())->getTotal();
        $bayar = $this->payment;
        $billAmount = (int) $bayar - (int) $cartTotal;
        
        if ($billAmount >= 0) {
            DB::beginTransaction();
            try {
                $allCart = \Cart::session(Auth()->id())->getContent();

                $filterCart = $allCart->map(function ($item) {
                    return [
                        'id' => substr($item->id, 4),
                        'quantity' => $item->quantity
                    ];
                });

                foreach ($filterCart as $cart) {
                    $product = ProductModel::find($cart['id']);

                    if ($product->qty === 0) {
                        return session()->flash('error', 'Out of stock!');
                    }

                    $product->decrement('qty', $cart['quantity']);
                }
                
                $id = IdGenerator::generate([
                    'table' => 'transactions',
                    'length' => 10,
                    'prefix' =>'INV-',
                    'field' => 'invoice_number'
                ]);

                Transaction::create([
                    'invoice_number' => $id,
                    'user_id' => Auth()->id(),
                    'pay' => $bayar,
                    'total' => $cartTotal
                ]);

                foreach ($filterCart as $cart) {
                    ProductTransaction::create([
                        'product_id' => $cart['id'],
                        'invoice_number' => $id,
                        'qty' => $cart['quantity']
                    ]);
                }

                \Cart::session(Auth()->id())->clear();
                $this->payment = 0;

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return session()->flash('error', $th);
            }
        }
    }
}
