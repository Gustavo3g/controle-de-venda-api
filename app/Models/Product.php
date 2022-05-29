<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'lote_id', 'description', 'color', 'value'];


    public function lote()
    {
        return $this->belongsTo(Lote::class,'id','lote_id');
    }
}
