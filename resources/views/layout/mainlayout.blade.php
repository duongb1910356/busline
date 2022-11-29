<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DuongDrive - Đặt vé online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar ps-1">
                <div class="sidebar-brand"><img src="img/icon/Directions bus.svg" alt=""> DuongDrive</div>
                <div class="d-flex flex-column align-items-center">
                    <img src="@yield('useravatar')" class="sidebar-img" alt="">
                    <span>@yield('username', 'Username')<a href="/logout"><img src="img/icon/Logout.svg" alt=""></a></span>
                </div>
                <ul class="d-flex flex-column align-items-start ps-0 pt-3">
                    <li class="nav-item list-unstyled">
                        <a class="nav-link" aria-current="page" href="/"><img src="img/icon/Add business.svg" alt="">&nbsp;&nbsp;Bán vé</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 offset-2 p-0">
                <div class="taskbar d-flex flex-row flex-wrap">
                    <form>
                        <div class="d-flex flex-row ps-3">
                            <div class="d-inline-flex">
                                <label class="col-form-label px-2" for="noidi">TUYẾN</label>
                                <select style="width: 197px" class="form-select" name="noidi" id="noidi" aria-label="Default select example">
                                    @section('selectfrom')
                                    info noi di
                                    @show
                                </select>
                            </div>

                            <div class="d-inline-flex flex-row">
                                <label for="ngaydi" style="min-width: 120px;" class="px-3 my-auto">KHỞI HÀNH</label>
                                <input type="date" id="ngaydi" name="ngaydi" value="" class="form-control taskbar-date">
                            </div>
                        </div>
                    </form>
                    <div class="col-12"></div>
                    <form action="" method="get" class="ms-auto py-3" style="margin-right: 303px; width: 320px;">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" placeholder="" aria-label="Nhập số điện thoại khách hàng" name="sodienthoai" id="sodienthoai" aria-describedby="btn-search">
                            <button class="btn btn-light" type="button" id="btn-search">Search</button>
                        </div>
                    </form>
                </div>

                @section('main')
                Đây là main
                @show


            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>