<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function product()
    {
        return $this->hasMany(ProductTransaction::class, 'invoice_number', 'invoice_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
