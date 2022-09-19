<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\Tuyen;
use App\Models\LichTrinh;
use App\Models\LoaiXe;
use App\Models\Ve;

use Response;
use Illuminate\Support\Facades\DB;




class LichTrinhController extends Controller
{
	public function __construct()
	{
		if (!LoginController::isUserLogin()) {
			return redirect()->route('login')->send();;
		}
	}

    public function showLichTrinh()
	{
		$data = [];
		$idtuyen = isset($_GET['tuyen']) ? $_GET['tuyen'] : -1;
		$date = isset($_GET['ngaydi']) ? $_GET['ngaydi'] : date('Y-m-d');
		if ($idtuyen == -1) {
			$tuyens = Tuyen::all();
		} else {
			$tuyens = Tuyen::where('id_tuyen', $idtuyen)->get();
		}

		$datave = [];
		$datalichtrinh = [];
		$datatuyen = [];

		foreach ($tuyens as $tuyen) {
            foreach($tuyen->lichtrinhs() as $lt){
				if($lt->ngaydi == $date){
					array_push($datalichtrinh,[
						"lichtrinh" => $lt,
						"xe" => $lt->xes,
						"bendi" => $lt->getbenxedi(),
						"benden" => $lt->getbenxeden(),
						"taixe" => $lt->taixes
					]);
				}
            }
			// if(empty($datalichtrinh)){
			// 	break;
			// }

            array_push($data,[
                "tuyen" => $tuyen,
                "datalichtrinh" => $datalichtrinh
            ]);

            $datalichtrinh = [];

			// array_push($data,[
			// 	"tuyen" => $tuyen,[

            //     ],
			// 	"lichtrinh" => LichTrinh::where('id_tuyen',$tuyen->id_tuyen)->where('ngaydi',$date)->get()->toArray()
			// ]);
		}
		
		$json = json_encode($data, JSON_PRETTY_PRINT);
		$json = json_decode($json);
        // echo "<script>console.log(${json})</script>";
		return view('lichtrinh.quanlylichtrinh',[
			"tuyens" => Tuyen::all(),
			"datas" => $json
		]);
	}

    public function xoaLichTrinh(Request $request)
    {
        $lichtrinh = LichTrinh::where('id_lichtrinh',$request->idlichtrinh)->first();
        return $lichtrinh->delete();
        // return $request->idlichtrinh;
    }

	public function getBenXeTheoTuyen(Request $request)
	{
		$tuyen = Tuyen::where("id_tuyen",$request->idtuyen)->first();
		$data = [];
		foreach($tuyen->benxes as $benxe){
			array_push($data,$benxe);
		}
		$data = json_encode($data, JSON_PRETTY_PRINT);
		// $data = json_decode($data);
		return $data;
		// echo "<script>console.log(${data})</script>";
	}
	
}
