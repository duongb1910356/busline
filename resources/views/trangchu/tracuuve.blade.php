@extends('layout.main-khach')

@section('maincontent')
    <div class="container">
        <div class="d-flex flex-row">
            <h5>THÔNG TIN VÉ</h5>
            <div style="clip-path: polygon(0 15%, 100% 14%, 100% 0);" class="d-flex flex-column align-self-end">
                <div style=" width: 300px; height: 20px; background: red;" class="align-self-end"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="text-end">
                            <span>Tên khách hàng:</span><br>
                            <span>Số điện thoại:</span><br>
                            <span>Mã Vé:</span><br>
                            <span>Vị trí:</span><br>
                            <span>Tuyến:</span><br>
                            <span>Bến xe đi:</span><br>
                            <span>Bến xe đến:</span><br>
                            <span>Ngày đi:</span><br>
                            <span>Nơi đón:</span><br>
                            <span>Tình trạng:</span>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="">
                            <span id="tenkhach">{{ $tenkhach }}</span><br>
                            <span id="sodienthoai">{{ $sodienthoai }}</span><br>
                            <span id="mave">{{ $mave }}</span><br>
                            <span id="vitri">{{ $vitri }}</span><br>
                            <span id="tuyen">{{ $tuyen }}</span><br>
                            <span id="benxedi">{{ $benxedi }}</span><br>
                            <span id="benxeden">{{ $benxeden }}</span><br>
                            <span id="ngaydi">{{ $ngaydi }}</span><br>
                            <span id="trungchuyen">{{ $trungchuyen }}</span><br>
                            <span id="tinhtrang">
                                @if ($tinhtrang == 0)
                                    Chưa thanh toán
                                @else
                                    Đã thanh toán
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <form action="/huyve/{{ $mave }}" method="POST">
                    @csrf
                    @if ($iscancel == false)
                        <button type="submit" disabled data-idve="{{ $mave }}" id="buttonhuyve"
                            class="btn btn-warning">Hủy vé</button>
                    @else
                        <button type="submit" data-idve="{{ $mave }}" id="buttonhuyve" class="btn btn-warning">Hủy
                            vé</button>
                    @endif
                </form>
            </div>
        </div>

    </div>
@endsection

@section('myscript')
    <script src="{{ asset('js/quanlylichtrinh.js') }}"></script>
@endsection
