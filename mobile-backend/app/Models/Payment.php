<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';
    protected $primaryKey = 'payment_method_id';
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_method_id');
    }
}
