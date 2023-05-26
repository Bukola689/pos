<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['name', 'phone'];

    public function product()
    {
        return $this->hasMany(Product::class, 'id');
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
