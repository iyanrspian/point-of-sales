<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product as ProductModel;

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

    public function handleSubmit()
    {
        dd($this->payment);
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
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1
                ]
            ]);
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
}
