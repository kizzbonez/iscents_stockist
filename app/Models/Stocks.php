<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id', 'qty','from_id','to_id','trans_type','remarks','created_by','updated_by'
    ];
    protected $table = 'stocks_transaction';


    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function from(){
        return $this->belongsTo(User::class, 'from_id');
    }
    public function to(){
        return $this->belongsTo(User::class, 'to_id');
    }

}
