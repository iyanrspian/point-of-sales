<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Product as ProductModel;

class Cart extends Component
{
    public $tax = "0%";

    public function render()
    {
        $product = ProductModel::orderBy('created_at', 'DESC')->get();

        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'pajak',
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
                    'row_id' => $item->id,
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

        $newCondition = \Cart::session(Auth()->id())->getCondition('pajak');
        $pajak = $newCondition->getCalculatedValue($subtotal);

        $summary = [
            'subtotal' => $subtotal,
            'pajak' => $pajak,
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
        $cekItemId = $cart->whereIn('id', $rowId);

        if ($cekItemId->isNotEmpty()) {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1
                ]
            ]);
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
}
