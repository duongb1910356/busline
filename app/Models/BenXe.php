<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenXe extends Model
{
    protected $table = 'benxe';
    protected $primaryKey = 'id_benxe';
    public $timestamps = false;

    public function tuyens() {
        $this->setKeyName('id_benxe');
        return $this->belongsToMany(Tuyen::class,'tuyen_benxe','id_benxe','id_tuyen');
    }

}
