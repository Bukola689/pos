<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['name', 'description', 'category_id','price', 'quantity','discount','alert_stock'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetails::class);
    }

}
