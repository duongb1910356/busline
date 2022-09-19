<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\BenXe;
use App\Models\Tuyen;
use App\Models\LichTrinh;
use App\Models\LoaiXe;
use App\Models\Ve;
use App\Models\Tinh;

use Response;
use Illuminate\Support\Facades\DB;




class TuyenController extends Controller
{
    public function __construct()
    {
        if (!LoginController::isUserLogin()) {
            return redirect()->route('login')->send();;
        }
    }

    public function showDanhSachTuyen()
    {
        $idtuyen = isset($_GET['tuyen']) ? $_GET['tuyen'] : -1;
        $date = isset($_GET['ngaydi']) ? $_GET['ngaydi'] : date('Y-m-d');

        if($idtuyen == -1){
            $listuyen = Tuyen::all();
        }else{
            $listuyen = Tuyen::where("id_tuyen",$idtuyen)->first();
        }

        return view('tuyen.quanlytuyen', [
            "tuyens" => Tuyen::all(),
            "listtuyen" => $listuyen,
            "benxes" => BenXe::all(),
            "tinhs" => Tinh::all()
        ]);
    }

    public function xoaTuyen($idtuyen)
    {
        return Tuyen::where("id_tuyen",$idtuyen)->delete();
    }

    public function suaTuyen()
    {
        
    }

    public function getBenXeOfTuyen($idtuyen)
    {
        return json_encode(Tuyen::where("id_tuyen",$idtuyen)->first()->benxes);
    }
}
