<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function fullName()
    {
        // Nếu không có parent_id hoặc parent_id là 0, trả về tên hiện tại
        if ($this->parent_id == 0) {
            return $this->name;
        }

        // Nếu có parent_id, lấy tên đầy đủ của danh mục cha và thêm vào tên hiện tại
        return $this->parent->fullName() . ' >> ' . $this->name;
    }

    // Đảm bảo rằng bạn có một mối quan hệ để lấy danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    
}
