<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    use HasFactory;
    protected $table = 'taikhoan';
    protected $primaryKey = 'id_taihkoan';
    public $timestamps = false;

    public function nhanviens() {
        return $this->hasOne(NhanVien::class,'id_nhanvien','id_taikhoan');
    }
}
