<?php

namespace App\Http\Livewire;

use App\Models\Product as ProductModel;
use Livewire\Component;

class Product extends Component
{
    public function render()
    {
        $product = ProductModel::orderBy('created_at', 'DESC')->get();
        return view('livewire.product', [
            'product' => $product
        ]);
    }
}
