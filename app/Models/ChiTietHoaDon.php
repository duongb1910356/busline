<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    protected $table = 'chitiethoadon';
    protected $primaryKey = ['id_hoadon','id_ve'];
    public $timestamps = false;
    protected $fillable = ['id_hoadon','id_ve'];
    public $incrementing = false;

}
