<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'cpf', 'birth_date'];


    public function orders()
    {
        return $this->hasMany(Order::class,'client_id','id');
    }

}
