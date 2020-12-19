<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Storage;

class Product extends Component
{
    use WithFileUploads;

    public $name,$image,$desc,$qty,$price;

    public function render()
    {

        $product = ProductModel::orderBy('created_at', 'DESC')->get();
        return view('livewire.product', [
            'product' => $product
        ]);
    }

    public function previewImage()
    {
        $this->validate([
            'image' => 'image|max:2048'
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'image' => 'image|max:2048|required',
            'desc' => 'required',
            'qty' => 'required|integer',
            'price' => 'required|integer',
        ]);

        $imgName = md5($this->image.microtime().'.'.$this->image->extension());
        Storage::putFileAs('public/images', $this->image, $imgName);
        ProductModel::create([
            'name' => $this->name,
            'image' => $imgName,
            'desc' => $this->desc,
            'qty' => $this->qty,
            'price' => $this->price
        ]);

        session()->flash('info', 'Product created successfully');
        $this->clear();
    }

    public function clear()
    {
        $this->name = null;
        $this->image = null;
        $this->desc = null;
        $this->qty = null;
        $this->price = null;
    }
}
