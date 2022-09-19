<?php

namespace App\Http\Controllers;

use App\Models\BenXe;
use App\Models\LichTrinh;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use App\Models\Ve;
use App\Models\GiaVe;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use PDO;

class TestController extends Controller
{
    public function test()
    {
        $partern = '/^[0]/';
        $subject =  '0832645549';
        $replacement = '+84';
        echo preg_replace('/^[0]/', '+84', $subject);
    }
}
