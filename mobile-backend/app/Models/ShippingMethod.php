<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;
    protected $primaryKey = 'shipping_method_id';
    
    public static function status()
    {
        return [
            '0' => 'Chưa được vận chuyển',
            '1' => 'Đã vận chuyển',
            '2' => 'Không cần vận chuyển',
            '3' => 'Vận chuyển thất bại',
        ];
    }
}
