<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id'; // Thay đổi khóa chính thành 'id' nếu trong bảng có khóa chính là 'id'

    // Nếu bạn có trường 'created_at' và 'updated_at', bạn có thể giữ chúng tự động
    public $timestamps = true; // Nếu không cần quản lý timestamps, bạn có thể bỏ dòng này

    protected $fillable = ['name', 'description', 'price', 'slug', 'category_id', 'brand_id', 'rating', 'discount', 'status', 'status_like', 'created_by', 'updated_by']; // Thêm danh sách các trường có thể được gán hàng loạt

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by'); // Sử dụng 'created_by' thay vì 'user_id'
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id'); // Sử dụng 'id' thay vì 'product_id' nếu khóa chính là 'id'
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Quan hệ với danh mục
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id'); // Quan hệ với thương hiệu
    }


    public function relatedproduct()
    {
        return $this->belongsTo(RelatedProduct::class, 'product_id');
    }
}
