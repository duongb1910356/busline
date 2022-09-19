<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    protected $table = 've';
    protected $primaryKey = 'id_ve';
    public $timestamps = false;
    protected $fillable = ['id_nhanvien', 'name_khach', 'sodienthoai', 'id_lichtrinh', 'id_giave', 'vitri', 'tinhtrang'];

    public function lichtrinhs() {
        return $this->belongsTo(LichTrinh::class,'id_lichtrinh','id_lichtrinh');
    }

    public function getGiaVe()
    {
        return GiaVe::where("id_giave",$this->id_giave)->first()->giave;
    }
}




