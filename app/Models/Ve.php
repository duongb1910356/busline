<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    protected $table = 've';
    protected $primaryKey = 'id_ve';
    public $timestamps = false;
    protected $fillable = ['id_nhanvien', 'name_khach', 'sodienthoai', 'id_lichtrinh', 'id_giave', 'vitri', 'tinhtrang'];

    public function lichtrinhs()
    {
        return $this->belongsTo(LichTrinh::class, 'id_lichtrinh', 'id_lichtrinh');
    }

    public function getGiaVe()
    {
        return GiaVe::where("id_giave", $this->id_giave)->first()->giave;
    }

    public function refundVe($idve)
    {
        $ve = Ve::where("id_ve", $idve)->first();
        require_once("../bootstrap/configvnpay.php");
        $amount = $ve->getGiaVe() * 100;

        $chitiethoadon = ChiTietHoaDon::where("id_ve", $ve->id_ve)->first();
        $hoadon = HoaDon::where("id_hoadon", $chitiethoadon->id_hoadon)->first();
        $hoadon->giatri = $hoadon->giatri - $amount;
        $hoadon->save();
        // echo $hoadon->id_hoadon;
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TransactionType" => "03",
            "vnp_Command" => "refund",
            "vnp_CreateBy" => "DƯƠNG",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_TxnRef" => $hoadon->id_hoadon,
            "vnp_Amount" => $amount,
            "vnp_OrderInfo" => 'Noi dung thanh toan',
            "vnp_TransDate" => $expire,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_IpAddr" => $ipaddr
        );
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

        $vnp_apiUrl = $vnp_apiUrl . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $vnp_apiUrl);
        // curl_setopt($ch, CURLOPT_HEADER, 1);

        curl_setopt($ch, CURLOPT_URL, $vnp_apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        $data = curl_exec($ch);
        parse_str($data, $inputData);
        curl_close($ch);
        
        return $inputData;
    }
}
