<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tinh extends Model
{
    use HasFactory;
    protected $table = 'tinh';
    protected $primaryKey = 'id_tinh';
    public $timestamps = false;
}
