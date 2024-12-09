<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với bảng chi tiết đơn hàng
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    // Quan hệ với bảng phương thức giao hàng
    public function shippingMethod()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_method_id');
    }

    // Trả về các trạng thái đơn hàng
    public static function status()
    {
        return [
            '1' => 'Chưa giải quyết',
            '2' => 'Xử lý',
            '3' => 'Hoàn thành',
            '4' => 'Đã hủy',
        ];
    }

    // Trả về các trạng thái thanh toán
    public static function payment_status()
    {
        return [
            '1' => 'Chưa giải quyết',
            '2' => 'Đã thanh toán',
            '3' => 'Hoàn lại',
            '4' => 'Trả',
        ];
    }

    // Trả về các trạng thái giao hàng
    public static function shipping_status()
    {
        return [
            '1' => 'Đã giao hàng',
            '2' => 'Đã vận chuyển',
            '3' => 'Không cần vận chuyển',
            '4' => 'Chưa được vận chuyển',
        ];
    }

    // Phương thức tính tổng tiền theo trạng thái và khoảng thời gian
    public static function getTotalByStatusAndTime($status, $timeFrame = null)
    {
        $query = self::where('status', $status);

        // Lọc theo thời gian nếu có
        if ($timeFrame) {
            switch ($timeFrame) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'all_time':
                    // Không cần lọc thời gian cho mọi thời gian
                    break;
                default:
                    break;
            }
        }

        // Tính tổng tiền theo trạng thái và thời gian
        return $query->sum('total_order');
    }

    // Phương thức lấy tổng số tiền cho tất cả các trạng thái
    public static function getTotalForAllStatuses()
    {
        return [
            '1' => self::getTotalByStatusAndTime(1, 'all_time'),
            '2' => self::getTotalByStatusAndTime(2, 'all_time'),
            '3' => self::getTotalByStatusAndTime(3, 'all_time'),
            '4' => self::getTotalByStatusAndTime(4, 'all_time'),
        ];
    }
}
