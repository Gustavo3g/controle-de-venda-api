<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;


    protected $fillable = ['id','manufacturing_date', 'quantity', 'created_at', 'updated_at'];


    public function products()
    {
        return $this->hasMany(Product::class,'lote_id','id');
    }
}
