<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DuongDrive - Đặt vé online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @yield('mycss')

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark px-3" style="background-color: rgba(25, 17, 106, 0.68);"
        aria-label="Fourth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src=" {{asset('img/icon/Directions bus.svg')}} " alt="">DuongDrive</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04"
                aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <a class="nav-link px-3 text-white" href="/" id="dropdown04" aria-expanded="false">Tin tức</a>
                    <a class="nav-link px-3 text-white" href="/datve" id="dropdown04" aria-expanded="false">Mua vé</a>
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="id-nhanvien"
                            data-id-nhanvien="@yield('id-nhanvien')" data-bs-toggle="dropdown" aria-expanded="false">
                            Nhân viên
                        </a>
                        <ul class="dropdown-menu text-white" aria-labelledby="dropdown04">
                            <li><a class="dropdown-item" href="/login">Đăng nhập</a></li>
                        </ul>
                    </li>
                </ul>
                <form action="/tracuuhoadon" method="GET" id="formsearchmave">
                    {{-- <label for="searchmave" class="form-label"></label> --}}
                    <input class="form-control" style="color: black;" name="inputmave" id="inputmave" type="text" placeholder="Tra cứu mã hóa đơn"  aria-describedby="emailHelp">
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row mt-3">
            @section('maincontent')

            @show
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>

        @yield('myscript')
    </div>

    <div class="mt-5">
        <footer class="text-white text-center text-lg-start" style="background-color: rgba(25, 17, 106, 0.68);">
            <!-- Grid container -->
            <div class="container p-4">
                <!--Grid row-->
                <div class="row mt-4">
                    <!--Grid column-->
                    <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase mb-4">Về công ty</h5>

                        <p>
                            Công ty DuongDrive được thành lập năm 2001. Trải qua 20 năm phát triển luôn cải tiến
                            mang đến chất lượng dịch vụ tối ưu nhất dành cho khách hàng.
                        </p>

                        <p>
                            Với DuongDrive "Khách hàng là miếng cơm manh áo, chửi khách là đá bát cơm".
                        </p>

                        <div class="mt-4">
                            <!-- Facebook -->
                            <a type="button" class="btn btn-floating btn-primary btn-lg shadow">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <!-- Dribbble -->
                            <a type="button" class="btn btn-floating btn-primary btn-lg shadow">
                                <i class="bi bi-google"></i>
                            </a>
                            <!-- Twitter -->
                            <a type="button" class="btn btn-floating btn-primary btn-lg shadow">
                                <i class="bi bi-twitter"></i>
                            </a>
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase mb-4 pb-1">Liên hệ với chúng tôi</h5>
                        <ul class="" style="margin-left: 1.65em; list-style-type: none;">
                            <li class="mb-3">
                                <span class=""><i class="bi bi-house-fill"></i></span><span class="ms-2">
                                    3/2 Xuân Khánh, Cần Thơ
                                </span>
                            </li>
                            <li class="mb-3">
                                <span class="fa-li"><i class="bi bi-envelope-fill"></i></span><span
                                    class="ms-2">duongb1910356@gmail.com</span>
                            </li>
                            <li class="mb-3">
                                <span class="fa-li"><i class="bi bi-telephone-fill"></i></span><span class="ms-2">
                                    083 264 5549
                                </span>
                            </li>
                            <li class="mb-3">
                                <span class="fa-li"><i class="bi bi-github"></i></span><span class="ms-2">
                                    abcxyz.web
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase mb-4">Phục vụ</h5>

                        <table class="table text-center text-white">
                            <tbody class="font-weight-normal">
                                <tr>
                                    <td>Thứ hai - Thứ bảy:</td>
                                    <td>24 / 24</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2022 Copyright:
                <a class="text-white" href="">TranQuocDuongB1910356</a>
            </div>
            <!-- Copyright -->
        </footer>
    </div>
</body>

</html>
