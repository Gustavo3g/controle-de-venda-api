<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, HasUuid;


    protected $fillable = ['uuid', 'user_id','client_id', 'items_id', 'total_amount'];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function client()
    {
         return $this->belongsTo(Client::class,'id','client_id');
    }

}
