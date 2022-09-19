<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xe extends Model
{
    protected $table = 'xe';
    protected $primaryKey = 'id_xe';
    public $timestamps = false;

    public function lichtrinhs() {
        return $this->hasMany(LichTrinh::class,'id_xe','id_lichtrinh');
    }

    public function loaixes() {
        return $this->belongsTo(LoaiXe::class,'id_loaixe','id_loaixe');
    }

}
