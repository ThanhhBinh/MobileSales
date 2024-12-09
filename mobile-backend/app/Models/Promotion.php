<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $table='promotion';

    public static function getDiscountTypes()
    {
        return [
            '1' => 'Được gán cho tổng đơn hàng',
            '2' => 'Được giao cho sản phẩm',
            '5' => 'Được gán cho các danh mục',
            '6' => 'Được giao cho nhà sản xuất',
            '10' => 'Được giao cho việc vận chuyển',
            '20' => 'Được chỉ định cho tổng đơn hàng',
        ];
    }

    public static function discount_limit()
    {
        return [
            '0' => 'Không giới hạn',
            '1' => 'Chỉ N lần',
            '2' => 'N lần cho mỗi khách hàng',
        ];
    }
}
