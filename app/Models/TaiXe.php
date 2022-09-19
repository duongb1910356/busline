<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiXe extends Model
{
    use HasFactory;
    protected $table = 'taixe';
    protected $primaryKey = 'id_taixe';
    public $timestamps = false;
    
}
