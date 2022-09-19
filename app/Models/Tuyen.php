<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuyen extends Model
{
    use HasFactory;

    protected $table = 'tuyen';
    protected $primaryKey = 'id_tuyen';
    public $timestamps = false;

    public function benxes() {
        $this->setKeyName('id_tuyen');
        return $this->belongsToMany(BenXe::class,'tuyen_benxe','id_tuyen','id_benxe');
    }

    public function lichtrinhs(){
        // $this->setKeyName('id_tuyen');
        // return $this->hasMany(LichTrinh::class,'id_tuyen','id_lichtrinh');
        return LichTrinh::where('id_tuyen',$this->id_tuyen)->get();
    }

    public function getTinhDi()
    {
        return Tinh::where("id_tinh",$this->id_tinhdi)->first();
    }

    public function getTinhDen()
    {
        return Tinh::where("id_tinh",$this->id_tinhden)->first();
    }

}
