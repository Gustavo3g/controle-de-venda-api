<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;


    protected $fillable = ['manufacturing_date', 'quantity', 'created_at', 'updated_at'];
}
