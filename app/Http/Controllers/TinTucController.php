<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\Tuyen;
use App\Models\LichTrinh;
use App\Models\LoaiXe;
use App\Models\TinTuc;
use App\Models\Ve;
use App\Models\Tinh;


use Response;
use Illuminate\Support\Facades\DB;

class TinTucController extends Controller
{
	// public function __construct()
	// {
	// 	// if (!LoginController::isUserLogin()) {
	// 	// 	return redirect()->route('login')->send();;
	// 	// }
	// 	if (!LoginController::isUserLogin()) {
	// 		return redirect()->route('home')->send();;
	// 	}
	// }

	public function showTrangchu()
	{
		$tinchinh = TinTuc::where("loai", "article")->first();
		$carousel = TinTuc::where("loai", "carousel")->get();
		$tins = TinTuc::where("loai", "article")->get();
		return view('trangchu.trangchu', [
			"tinchinh" => $tinchinh,
			"carousel" => $carousel,
			"tins" => $tins
		]);
	}

	public function showTinTucChiTiet($idtintuc)
	{
		$tin = TinTuc::where("id_tintuc", $idtintuc)->first();
		$dexuats = TinTuc::where("id_tintuc", "<>", $idtintuc)->get();
		return view('trangchu.tintuc', [
			"tin" => $tin,
			"dexuats" => $dexuats
		]);
	}

	public function showKhachDatVe()
	{
		return view('trangchu.datve', [
			"tinhs" => Tinh::all()
		]);
	}

	public function timLichTrinh()
	{
		$tuyen = Tuyen::where("id_tinhdi", $_GET["tinhdi"])->where("id_tinhden", $_GET["tinhden"])->first();
		if ($tuyen != null) {
			$lichtrinhs = LichTrinh::where("id_tuyen", $tuyen->id_tuyen)->where("ngaydi", $_GET["ngaydi"])->get();
			if ($lichtrinhs != null) {
				$datalichtrinh = [];
				$ghetrong = 0;
				foreach ($lichtrinhs as $lichtrinh) {
					$ghetrong = $lichtrinh->xes->loaixes->soghe - Ve::where('id_lichtrinh', $lichtrinh->id_lichtrinh)->count();
					array_push($datalichtrinh, [
						"lichtrinh" => $lichtrinh,
						"xe" => $lichtrinh->xes,
						"loaixe" => $lichtrinh->xes->loaixes,
						"tuyen" => $tuyen,
						"benxedi" => $lichtrinh->getbenxedi(),
						"benxeden" => $lichtrinh->getbenxeden(),
						"ghetrong" => $ghetrong,
						"vitri" => Ve::select("vitri")->where("id_lichtrinh", $lichtrinh->id_lichtrinh)->get(),
						"giave" => $lichtrinh->giaves()
					]);
				};
			}
		}
		return $datalichtrinh;
	}

	public function datVeXe(Request $request)
	{
		$check = false;
		$miss = [];
		foreach ($request->vitri as $key => $value) {
			$newve = new Ve;
			$newve->name_khach = $request->tenkhach;
			$newve->sodienthoai = $request->sodienthoai;
			$newve->id_lichtrinh = $request->lichtrinh;
			$newve->id_giave = $request->giave;
			$newve->tinhtrang = $request->tinhtrang;
			$newve->vitri = $value;
			$newve->trungchuyen = $request->trungchuyen;
			$newve->id_nhanvien = null;
			if (!Ve::where('id_lichtrinh', $newve->id_lichtrinh)->where('vitri', $newve->vitri)->exists()) {
				$newve->save();
				$check = true;
				return $newve->id_ve;
			}else{
				array_push($miss,$value);
			}
		}
		return $miss;
	}

	public function getListCho(Request $request)
	{
		$vitris = Ve::select("vitri")->where("id_lichtrinh",$request->idlichtrinh)->get();
		$datavitri = [];
		foreach($vitris as $vitri){
			array_push($datavitri,$vitri);
		}
		return $datavitri;
	}
}
