<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['product_id', 'amount'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
