<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTransaction extends Model
{
    protected $table = 'products_transaction';
    protected $guarded = [];
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
