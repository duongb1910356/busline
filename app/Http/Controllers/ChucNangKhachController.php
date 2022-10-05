<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\ChiTietHoaDon;
use App\Models\GiaVe;
use App\Models\HoaDon;
use App\Models\Tuyen;
use App\Models\LichTrinh;
use App\Models\LoaiXe;
use App\Models\Ve;
use App\Models\Tinh;

use Response;
use Illuminate\Support\Facades\DB;




class ChucNangKhachController extends Controller
{
    public function traCuuHoaDon()
    {
        $idve = $_GET['inputmave'];
        return Ve::where("id_ve", $idve)->exists();
    }

    public function showKhachDatVe()
	{
		return view('trangchu.datve', [
			"tinhs" => Tinh::all()
		]);
	}

    public function timLichTrinh(){
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

    public function getListCho(Request $request)
	{
		$vitris = Ve::select("vitri")->where("id_lichtrinh",$request->idlichtrinh)->get();
		$datavitri = [];
		foreach($vitris as $vitri){
			array_push($datavitri,$vitri);
		}
		return $datavitri;
	}

    public function showKetQuaTraCuuVe($idve)
    {
        $ve = Ve::where("id_ve", $idve)->first();
        $iscancel = true;
        if($ve->lichtrinhs->ngaydi < date('Y-m-d')){
            $iscancel = false;
        }
        return view('trangchu.tracuuve', [
            "tenkhach" => $ve->name_khach,
            "sodienthoai" => $ve->sodienthoai,
            "mave" => $ve->id_ve,
            "tuyen" => $ve->lichtrinhs->tuyens->name_tuyen,
            "vitri" => $ve->vitri,
            "benxedi" => $ve->lichtrinhs->getbenxedi()->name_benxe,
            "benxeden" => $ve->lichtrinhs->getbenxeden()->name_benxe,
            "ngaydi" => $ve->lichtrinhs->giodi . " " . $ve->lichtrinhs->ngaydi,
            "trungchuyen" => $ve->trungchuyen,
            "tinhtrang" => $ve->tinhtrang,
            // "iscancel" => $iscancel
            "iscancel" => true

        ]);
    }

    public function huyVe($idve)
    {
        $ve = Ve::where("id_ve", $idve)->first();
        if ($ve->tinhtrang != 0) {
            $inputData = $ve->refundVe($ve->id_ve);
            // echo json_encode($inputData);
            // echo $inputData['vnp_TxnRef'];
            if($inputData['vnp_ResponseCode'] == "00"){
                $ve->delete();
                return view('trangchu.congratulations', [
                    "status" => "VÉ ĐÃ ĐƯỢC HỦY THÀNH CÔNG",
                    "comment" => "Số tiền hủy sẽ được hoàn trả lại cho quý khách",
                    // "date" => $ve->lichtrinhs->ngaydi,
                    // "time" => $ve->lichtrinhs->giodi,
                    // "seat" => $ve->vitri,
                    // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
                    "recomment" => "Vé khách vui lòng kiểm tra lại số tiền hoàn trả!"
                ]);
            }else{
                return view('trangchu.congratulations', [
                    "status" => "VÉ CHƯA ĐƯỢC HỦY",
                    "comment" => "Lỗi ngân hàng thanh toán",
                    // "date" => $ve->lichtrinhs->ngaydi,
                    // "time" => $ve->lichtrinhs->giodi,
                    // "seat" => $ve->vitri,
                    // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
                    "recomment" => "Qúy khách vui lòng đến trực tiếp phòng vé để được hỗ trợ"
                ]);
            }
        }else{
            $ve->delete();
            return view('trangchu.congratulations', [
                "status" => "VÉ ĐÃ ĐƯỢC HỦY THÀNH CÔNG",
                "comment" => "Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi",
                // "date" => $ve->lichtrinhs->ngaydi,
                // "time" => $ve->lichtrinhs->giodi,
                // "seat" => $ve->vitri,
                // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
                "recomment" => "Qúy khách có thể gọi tới tổng đài để được hỗ trợ"
            ]);
        }

        
    }

    // public function huyVe($idve)
    // {
    //     $ve = Ve::where("id_ve", $idve)->first();
    //     if ($ve->tinhtrang != 0) {
    //         require_once("../bootstrap/configvnpay.php");
    //         $amount = $ve->getGiaVe() * 100;
            
    //         $chitiethoadon = ChiTietHoaDon::where("id_ve", $ve->id_ve)->first();
    //         $hoadon = HoaDon::where("id_hoadon", $chitiethoadon->id_hoadon)->first();
    //         $hoadon->giatri = $hoadon->giatri - $amount;
    //         $hoadon->save();
    //         // echo $hoadon->id_hoadon;
    //         $ipaddr = $_SERVER['REMOTE_ADDR'];
    //         $inputData = array(
    //             "vnp_Version" => "2.1.0",
    //             "vnp_TransactionType" => "03",
    //             "vnp_Command" => "refund",
    //             "vnp_CreateBy" => "DƯƠNG",
    //             "vnp_TmnCode" => $vnp_TmnCode,
    //             "vnp_TxnRef" => $hoadon->id_hoadon,
    //             "vnp_Amount" => $amount,
    //             "vnp_OrderInfo" => 'Noi dung thanh toan',
    //             "vnp_TransDate" => $expire,
    //             "vnp_CreateDate" => date('YmdHis'),
    //             "vnp_IpAddr" => $ipaddr
    //         );
    //         ksort($inputData);
    //         $query = "";
    //         $i = 0;
    //         $hashdata = "";
    //         foreach ($inputData as $key => $value) {
    //             if ($i == 1) {
    //                 $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    //             } else {
    //                 $hashdata .= urlencode($key) . "=" . urlencode($value);
    //                 $i = 1;
    //             }
    //             $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //         }

    //         $vnp_apiUrl = $vnp_apiUrl . "?" . $query;
    //         if (isset($vnp_HashSecret)) {
    //             $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    //             $vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
    //         }
    //         $ch = curl_init();
    //         // curl_setopt($ch, CURLOPT_URL, $vnp_apiUrl);
    //         // curl_setopt($ch, CURLOPT_HEADER, 1);

    //         curl_setopt($ch, CURLOPT_URL, $vnp_apiUrl);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_HEADER, 0);
    //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


    //         $data = curl_exec($ch);
    //         parse_str($data, $inputData);
    //         // var_dump($data);
    //         // $data = json_decode($data);
    //         // echo $result['vnp_ResponseCode'];

    //         // $inputData = array();
    //         // foreach ($_GET as $key => $value) {
    //         //     if (substr($key, 0, 4) == "vnp_") {
    //         //         $inputData[$key] = $value;
    //         //         echo $key . "------------";
    //         //     }
    //         // }
    //         // // // $weather = json_decode($data);
    //         // // // var_dump($inputData);
    //         // echo $inputData['vnp_ResponseCode'];
    //         curl_close($ch);

    //         // echo $inputData['vnp_TxnRef'];
    //         if($inputData['vnp_ResponseCode'] == "00"){
    //             $ve->delete();
    //             return view('trangchu.congratulations', [
    //                 "status" => "VÉ ĐÃ ĐƯỢC HỦY THÀNH CÔNG",
    //                 "comment" => "Số tiền hủy sẽ được hoàn trả lại cho quý khách",
    //                 // "date" => $ve->lichtrinhs->ngaydi,
    //                 // "time" => $ve->lichtrinhs->giodi,
    //                 // "seat" => $ve->vitri,
    //                 // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
    //                 "recomment" => "Vé khách vui lòng kiểm tra lại số tiền hoàn trả!"
    //             ]);
    //         }else{
    //             return view('trangchu.congratulations', [
    //                 "status" => "VÉ CHƯA ĐƯỢC HỦY",
    //                 "comment" => "Lỗi ngân hàng thanh toán",
    //                 // "date" => $ve->lichtrinhs->ngaydi,
    //                 // "time" => $ve->lichtrinhs->giodi,
    //                 // "seat" => $ve->vitri,
    //                 // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
    //                 "recomment" => "Qúy khách vui lòng đến trực tiếp phòng vé để được hỗ trợ"
    //             ]);
    //         }
    //     }else{
    //         $ve->delete();
    //         return view('trangchu.congratulations', [
    //             "status" => "VÉ ĐÃ ĐƯỢC HỦY THÀNH CÔNG",
    //             "comment" => "Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi",
    //             // "date" => $ve->lichtrinhs->ngaydi,
    //             // "time" => $ve->lichtrinhs->giodi,
    //             // "seat" => $ve->vitri,
    //             // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
    //             "recomment" => "Qúy khách có thể gọi tới tổng đài để được hỗ trợ"
    //         ]);
    //     }

        
    // }
}
