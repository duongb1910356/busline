<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_TmnCode = "V8OS4MSS"; //Mã website tại VNPAY 
$vnp_HashSecret = "IGXQTOKJVUBNXLWHSEAEBYUZHEIPCRMG"; //Chuỗi bí mật
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";



