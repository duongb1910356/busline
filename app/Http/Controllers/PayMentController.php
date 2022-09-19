<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\LichTrinh;
use App\Models\Ve;



use Response;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

// require_once("../bootstrap/vnpay.php");


class PayMentController extends Controller
{
    public function showPayMent()
    {
        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        // $startTime = date("YmdHis");
        require_once("../bootstrap/configvnpay.php");

        if (isset($_SESSION['idves'])) {
            $_SESSION['idves'] = null;
        };
        $_SESSION['idves'] = $_POST['idves'];

        $vnp_Returnurl = "http://busline.localhost/congratulations";
        $vnp_Amount = $_POST['tongtien'] * 100;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_TxnRef = $expire; //Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng test";
        $vnp_OrderType = "billpayment";
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            return $vnp_Url;
            // header('Location: ' . $vnp_Url);
            // die();
        } else {
            echo json_encode($returnData);
        }
    }



    public function showcongratulations()
    {
        require_once("../bootstrap/configvnpay.php");
        $vnp_Returnurl = "http://busline.localhost/congratulations";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi
        $vnp_TransactionStatus = $inputData['vnp_TransactionStatus'];
        $vnp_TxnRef = $inputData['vnp_TxnRef'];

        $returnData = [
            "vnpTranId" => $vnpTranId,
            "vnp_BankCode" => $vnp_BankCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_TransactionStatus" => $vnp_TransactionStatus
        ];

        // echo json_encode($returnData);
        $status = "THANH TOÁN CỦA QUÝ KHÁCH ĐÃ XẢY RA LỖI";
        $comment = "Vé quý khách đặt trước đó sẽ bị hủy";
        $recomment = "Nếu thanh toán chưa thành công, quý khách vui lòng đặt lại vé hoặc chọn phương thức thanh toán khác!";
        // $ve = Ve::where("id_ve", $id)->first();
        // echo $id;

        if ($vnp_TransactionStatus == 0) {
            $status = "CHÚC MỪNG QUÝ KHÁCH ĐÃ THANH TOÁN THÀNH CÔNG";
            $comment = "CTY BusLine chân thành cảm ơn quý khách";
            // $ve->tinhtrang = 1;
            // $ve->save();
            $hoadon = HoaDon::create([
                "id_hoadon" => $vnp_TxnRef,
                "giatri" => $vnp_Amount,
                "ngaythanhtoan" => date('Y-m-d')
            ]);

            foreach ($_SESSION['idves'] as $key => $value) {
                $ve = Ve::where("id_ve", $value)->first();
                $ve->tinhtrang = 1;
                $ve->save();
                $chitiethoadon = ChiTietHoaDon::create([
                    "id_hoadon" => $vnp_TxnRef,
                    "id_ve" => $value
                ]);
            }
            // foreach($_SESSION["idves"] as $key => $value)
            // echo $value;
        }else{
            foreach ($_SESSION['idves'] as $key => $value) {
                $ve = Ve::where("id_ve", $value)->first();
                $ve->tinhtrang = 1;
                $ve->delete();
            }
        }
        return view('trangchu.congratulations', [
            "status" => $status,
            "comment" => $comment,
            // "date" => $ve->lichtrinhs->ngaydi,
            // "time" => $ve->lichtrinhs->giodi,
            // "seat" => $ve->vitri,
            // "route" => $ve->lichtrinhs->tuyens->name_tuyen,
            "recomment" => $recomment
        ]);
    }

    public function datVeXe(Request $request)
    {
        $check = false;
        $miss = [];
        $idves = array();
        foreach ($request->vitri as $key => $value) {
            $newve = new Ve;
            $newve->name_khach = $request->tenkhach;
            // $newve->sodienthoai = $request->sodienthoai;
            $newve->sodienthoai = preg_replace('/^[0]/', '+84', $request->sodienthoai);;
            $newve->id_lichtrinh = $request->lichtrinh;
            $newve->id_giave = $request->giave;
            $newve->tinhtrang = $request->tinhtrang;
            $newve->vitri = $value;
            $newve->trungchuyen = $request->trungchuyen;
            $newve->id_nhanvien = null;
            if (!Ve::where('id_lichtrinh', $newve->id_lichtrinh)->where('vitri', $newve->vitri)->exists()) {
                $newve->save();
                $check = true;
                // $this->sendSMS($newve);
                array_push($idves, $newve->id_ve);
                // return $newve->id_ve;
            } else {
                array_push($miss, $value);
            }
        }
        $data = array();
        $data['miss'] = $miss;
        $data['idves'] = $idves;
        return json_encode($data);
    }

    public function sendSMS($ve)
    {
        // require_once __DIR__ . '/vendor/autoload.php';
        $sid    = "AC6d1223daf1529e4f573a8e8430fafc7e";
        $token  = "0a8cc6b79efa5d5486d9993c280c309e";
        $client = new Client($sid, $token);

        $message = $client->messages->create(
            "+" . $ve->sodienthoai, // Text this number
            [
                'from' => '+18146125059', // From a valid Twilio number
                'body' => 'Busline Phương Trang thông báo! Mã vé : ' . $ve->id_ve . " đã được đặt thành công!"
            ]
        );

        // print $message->sid;
    }
}
