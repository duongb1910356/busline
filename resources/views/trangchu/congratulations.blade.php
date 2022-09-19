<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusLine - Đặt vé online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/congratulations.css') }}">
</head>

<body>
    <div class="contain">
        <div class="congrats">
            <h1>{{$status}}</h1>
            <div class="done">
                <svg version="1.1" id="tick" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 37 37"
                    style="enable-background:new 0 0 37 37;" xml:space="preserve">
                    <path class="circ path"
                        style="fill:#0cdcc7;stroke:#07a796;stroke-width:3;stroke-linejoin:round;stroke-miterlimit:10;"
                        d="M30.5,6.5L30.5,6.5c6.6,6.6,6.6,17.4,0,24l0,0c-6.6,6.6-17.4,6.6-24,0l0,0c-6.6-6.6-6.6-17.4,0-24l0,0C13.1-0.2,23.9-0.2,30.5,6.5z" />
                    <polyline class="tick path"
                        style="fill:none;stroke:#fff;stroke-width:3;stroke-linejoin:round;stroke-miterlimit:10;"
                        points="
        11.6,20 15.9,24.2 26.4,13.8 " />
                </svg>
            </div>
            <div class="text">
                <a href="/" style="text-decoration: none;">Trở về trang chủ</a>
            </div>
            <div class="text">
                <p>{{$comment}}</p>
            </div>
            <p class="regards">{{$recomment}}</p>
        </div>
    </div>


    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <script rel="stylesheet" href="{{ asset('js/congratulations.js') }}"></script>
</body>

</html>
