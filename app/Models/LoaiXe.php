<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiXe extends Model
{
    protected $table = 'loaixe';
    protected $primaryKey = 'id_loaixe';
    public $timestamps = false;

    public function xes() {
        return $this->hasMany(Xe::class,'id_xe','id_loaixe');
    }
}
