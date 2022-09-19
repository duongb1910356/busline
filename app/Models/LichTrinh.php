<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichTrinh extends Model
{
    use HasFactory;
    protected $table = 'lichtrinh';
    protected $primaryKey = 'id_lichtrinh';
    public $timestamps = false;

    public function tuyens() {
        return $this->belongsTo(Tuyen::class,'id_tuyen','id_tuyen');
    }

    public function xes() {
        return $this->belongsTo(Xe::class,'id_xe','id_xe');
    }

    public function ves() {
        // return $this->hasMany(Ve::class,'id_lichtrinh','id_ve');
        return Ve::where('id_lichtrinh',$this->id_lichtrinh)->get();
    }

    public function getbenxedi(){
        $benxedi = BenXe::where('id_benxe',$this->id_bendi)->first();
        return $benxedi;
    }

    public function getbenxeden(){
        $benxeden = BenXe::where('id_benxe',$this->id_benden)->first();
        return $benxeden;
    }

    public function giaves(){
        return GiaVe::where('id_tuyen',$this->tuyens->id_tuyen)->where('id_loaixe',$this->xes->loaixes->id_loaixe)->first();
    }

    public function taixes(){
        return $this->belongsTo(TaiXe::class,'id_taixe','id_taixe');
    }
}
