<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\Tuyen;
use App\Models\LichTrinh;
use App\Models\LoaiXe;
use App\Models\Tinh;
use App\Models\Ve;

use Response;
use Illuminate\Support\Facades\DB;

class VeController extends Controller
{
	public function __construct()
	{
		// if (!LoginController::isUserLogin()) {
		// 	return redirect()->route('login')->send();;
		// }
		if (!LoginController::isUserLogin()) {
			return redirect()->route('home')->send();
		}
	}

	public function showTrangchu()
	{
		return view('trangchu.trangchu');
	}

	public function findLichTrinh(Request $request)
	{
		if ($request->id_tuyen == -1)
			$lichtrinhs = LichTrinh::where('ngaydi', $request->ngaydi)->get();
		else
			$lichtrinhs = LichTrinh::where('id_tuyen', $request->id_tuyen)->where('ngaydi', $request->ngaydi)->get();
		$output = "";
		if (!empty($lichtrinhs)) {
			foreach ($lichtrinhs as $lichtrinh) {
				$output .= '<div data-bienso="' . $lichtrinh->xes->bienso . '" class="main-item-roundbus  m-2 able-cursor" data-benxe="' . $lichtrinh->getbenxedi()->name_benxe . "-" . $lichtrinh->getbenxeden()->name_benxe . '" data-id-giave="' . $lichtrinh->giaves()->id_giave . '" data-giave="' . $lichtrinh->giaves()->giave . '" data-id-lichtrinh="' . $lichtrinh->id_lichtrinh . '" data-name-tuyen="' . $lichtrinh->tuyens->name_tuyen . '" data-lichtrinh="' . $lichtrinh->id_lichtrinh . '" data-bs-toggle="modal" data-bs-target="#exampleModal">
								<div class="main-item-title d-inline-flex justify-content-around align-items-center">
									<span class="text-white">' . $lichtrinh->giodi . '</span>
									<span class="text-white border border-3 p-1" style="border-radius: 5px;">' . $lichtrinh->xes->bienso . '</span>
								</div>
								<div class="px-2">
									<span style="font-size: 17px;">' . $lichtrinh->tuyens->name_tuyen . '</span><br>
									<span style="font-size: 17px;" class="fw-bold text-danger text-center">' . $lichtrinh->getbenxedi()->name_benxe . "-" . $lichtrinh->getbenxeden()->name_benxe . '</span>
									<br>
									<span style="font-size: 17px;" name="soghetrong" >Số ghế trống: &nbsp' . $this->getSoGheTrong($lichtrinh->id_lichtrinh). '</span><br>
								</div>
							</div>';
			}
		} else {
			$output = '<h1>Not Found</h1>';
		}
		return $output;
	}

	public function getSoGheTrong($idlichtrinh)
	{
		$lichtrinh = LichTrinh::where("id_lichtrinh",$idlichtrinh)->first();
		return $lichtrinh->xes->loaixes->soghe - Ve::where('id_lichtrinh', $lichtrinh->id_lichtrinh)->count();
	}

	public function showBanVe()
	{
		$tuyens = Tuyen::all();
		$lichtrinhs = LichTrinh::where('ngaydi', date('Y-m-d'))->get();
		return view('ve.banve', ["tuyens" => $tuyens, "trigger" => "true"]);
	}


	public function getInfoLichTrinh($id)
	{
		$json = [];
		$lichtrinh = LichTrinh::where('id_lichtrinh', $id)->first();
		$ves = Ve::select('vitri', 'tinhtrang')->where('id_lichtrinh', $id)->get();
		$loaixe = LoaiXe::select('sodo', 'tang')->where('id_loaixe', $lichtrinh->xes->loaixes->id_loaixe)->get();
		$loaixe->toArray();
		$ves->toArray();
		return response()->json(['loaixe' => $loaixe, 'ves' => $ves]);
	}


	public function timLich(Request $request)
	{
		$lichtrinhs = LichTrinh::where('id_tuyen', $request->tuyen)->where('ngaydi', $request->ngay)->get();
		$loaixe = [];
		$data = [];
		foreach ($lichtrinhs as $lichtrinh) {
			$temp = $lichtrinh->xes->loaixes;
			array_push($data, [
				"lichtrinh" => $lichtrinh,
				"loaixe" => $temp,
				"bendi" => $lichtrinh->getbenxedi(),
				"benden" => $lichtrinh->getbenxeden(),
				"ve" => $lichtrinh->ves(),
			]);
			// array_push($loaixe,$temp);
		};
		return response()->json($data);

		// return response()->json(['loaixe' => $loaixe, 'lichtrinh' => $lichtrinhs]);
		// return "abc";
	}

	public function datVeXe(Request $request)
	{
		$check = false;
		$newve = null;
		foreach ($request->vitri as $key => $value) {
			$newve = new Ve;
			$newve->id_nhanvien = $request->nhanvien;
			$newve->name_khach = $request->tenkhach;
			$newve->sodienthoai = $request->sodienthoai;
			$newve->id_lichtrinh = $request->lichtrinh;
			$newve->id_giave = $request->giave;
			$newve->tinhtrang = $request->tinhtrang;
			$newve->vitri = $value;
			$newve->trungchuyen = $request->trungchuyen;
			DB::transaction(function () use ($newve, &$check) {
				try {
					if (!Ve::where('id_lichtrinh', $newve->id_lichtrinh)->where('vitri', $newve->vitri)->exists()) {
						$newve->save();
						$check = true;
					}
				} catch (\Illuminate\Database\QueryException $e) {
					echo $e;
				}
			});
		}

		return json_encode([
			"check" => $check,
			"sochotrong" => $this->getSoGheTrong($newve->id_lichtrinh)
		]);
	}

	public function inVeXe($id)
	{
		$data = [];
		$ve = Ve::where('id_ve', $id)->first();
		$ve->tinhtrang = 1;
		$ve->save();
		$data[] = [
			"tentuyen" => $ve->lichtrinhs->tuyens->name_tuyen,
			"soxe" => $ve->lichtrinhs->xes->bienso,
			"bendi" => $ve->lichtrinhs->getbenxedi()->name_benxe,
			"benden" => $ve->lichtrinhs->getbenxeden()->name_benxe,
			"giokhoihanh" => $ve->lichtrinhs->giodi,
			"ngaykhoihanh" => $ve->lichtrinhs->ngaydi,
			"soghe" => $ve->vitri,
			"giave" => $ve->lichtrinhs->giaves()->giave,
			"tenkhach" => $ve->name_khach,
			"sodienthoai" => $ve->sodienthoai
		];
		return json_encode($data);
	}

	public function showListVe()
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
			array_push($data,[
				"tuyen" => $tuyen,
				"lichtrinh" => LichTrinh::where('id_tuyen',$tuyen->id_tuyen)->where('ngaydi',$date)->get()->toArray()
			]);
		}
		
		$json = json_encode($data, JSON_PRETTY_PRINT);
		$json = json_decode($json);
		return view('ve.quanlyve',[
			"tuyens" => Tuyen::all(),
			"tuyenlich" => $json
		]);
	}

	public function deleteVe($idve)
	{
		Ve::where('id_ve', $idve)->delete();
	}

	public function findListVe(Request $request)
	{
		$lichtrinh = LichTrinh::where('id_lichtrinh',$request->idlichtrinh)->first();
		return response()->json([
			[
				"lichtrinh" => $lichtrinh,
				"ve" => $lichtrinh->ves(),
				"benxedi" => $lichtrinh->getbenxedi(),
				"benxeden" => $lichtrinh->getbenxeden(),
				"giave" => $lichtrinh->giaves()->giave
			]
		]);
	}

	public function capNhatVe(Request $request)
	{
		$idve = $request->idve;
		$vitri = $request->vitri;

		$ve = Ve::where('id_ve', $idve)->first();
		$check = false;
		DB::transaction(function () use (&$ve, $vitri, &$check) {
			try {
				if (!Ve::where('id_lichtrinh', $ve->id_lichtrinh)->where('vitri', $vitri)->exists()) {
					$ve->vitri = $vitri;
					$ve->save();
					$check = true;
				}
			} catch (\Illuminate\Database\QueryException $e) {
				echo $e;
			}
		});
		return $check;
	}

	public function suaVe(Request $request)
	{
		$ve = Ve::where('id_ve',$request->idve)->first();
		$ve->name_khach = $request->tenkhach;
		$ve->sodienthoai = $request->sodienthoai;
		$ve->trungchuyen = $request->trungchuyen;

		if($request->idlichtrinh != -1 && $request->vitri != null){
			$ve->id_lichtrinh = $request->idlichtrinh;
			$ve->vitri = $request->vitri;
		}
		return $ve->save();
		
	}

}
