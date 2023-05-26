<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['product_id', 'quantity','price', 'discount','user_id'];

    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
