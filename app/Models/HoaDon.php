<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoadon';
    protected $primaryKey = 'id_hoadon';
    public $timestamps = false;
    protected $fillable = ['id_hoadon','ngaythanhtoan','giatri'];

}
