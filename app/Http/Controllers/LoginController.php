<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public static function isUserLogin()
    {
        return isset($_SESSION['id_nhanvien']);
    }

    public static function showLoginForm()
    {
        return view('login.login');
    }

    public static function checkMatch(TaiKhoan $taikhoan, $hash)
    {
        $verified = password_verify($taikhoan->pass, $hash);
        return $verified;
    }

    public function login(Request $request)
    {
        $output = "";
        $taikhoan = TaiKhoan::where('username', $request->username)->first();
        $hash = password_hash($request->pass, PASSWORD_BCRYPT);
        if (!$taikhoan) {
            $output .= '<div class="toast text-bg-success border-0">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <strong>Lỗi đăng nhập!</strong>
                                    Tài khoản chưa đúng.
                                </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                            </div>
                        </div>';
        } else if (LoginController::checkMatch($taikhoan, $hash)) {
            $_SESSION['id_nhanvien'] = $taikhoan->id_nhanvien;
            $_SESSION['username'] = NhanVien::where('id_nhanvien', $taikhoan->id_nhanvien)->first()->name_nhanvien;
        } else {
            $output .= '<div class="toast text-bg-success border-0">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <strong>Lỗi đăng nhập!</strong>
                                    Mật khẩu chưa đúng.
                                </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                            </div>
                        </div>';
        }
		return $output;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        return view('login.login');
    }
}
