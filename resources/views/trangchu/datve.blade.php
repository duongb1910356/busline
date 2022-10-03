@extends('layout.main-khach')

@section('maincontent')
    <div class="mt-4 d-flex flex-row justify-content-center border p-3"
        style="border-radius: 5px; box-shadow: 4px 4px 20px 1px hsl(0deg 0% 55% / 40%)">
        <form action="/datve/timlich" id="formtimlichtrinh" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="tinhdi" class="col-form-label">Điểm đi</label>
                </div>
                <div class="col-auto">
                    {{-- <input class="form-control" list="datalistdiemdi" id="tinhdi" placeholder="Type to search...">
                    <datalist id="datalistdiemdi">
                        @foreach ($tinhs as $tinh)
                            <option value="{{ $tinh->id_tinh }}">{{ $tinh->name_tinh }}</option>
                        @endforeach

                    </datalist> --}}
                    <select class="form-select" name="tinhdi" id="tinhdi" aria-label="Default select example">
                        @foreach ($tinhs as $tinh)
                            <option value="{{ $tinh->id_tinh }}">{{ $tinh->name_tinh }}</option>
                        @endforeach
                    </select>

                </div>

                <div class="col-auto">
                    <label for="tinhden" class="col-form-label">Điểm đến</label>
                </div>
                <div class="col-auto">
                    {{-- <input class="form-control" list="datalistdiemden" id="tinhden" placeholder="Type to search...">
                    <datalist id="datalistdiemden">
                        @foreach ($tinhs as $tinh)
                            <option value="{{ $tinh->id_tinh }}">{{ $tinh->name_tinh }}</option>
                        @endforeach
                    </datalist> --}}

                    <select class="form-select" name="tinhden" id="tinhden" aria-label="Default select example">
                        @foreach ($tinhs as $tinh)
                            <option value="{{ $tinh->id_tinh }}">{{ $tinh->name_tinh }}</option>
                        @endforeach
                    </select>

                </div>

                <div class="col-auto">
                    <label for="ngaydi">Ngày đi</label>
                </div>
                <div class="col-auto">
                    <input type="date" id="ngaydi" name="ngaydi" value="" class="form-control taskbar-date">
                </div>

                <div class="col-auto">
                    <button type="submit" id="submitformtimlichtrinh" class="btn btn-info">Tìm kiếm</button>
                </div>

            </div>
        </form>
    </div>

    <div class="row mx-0 my-3 px-4 wrap-content" id="maincontent"></div>

    <div class="modal fade" data-idgiave="" id="modalkhachdatve" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl p-0">
            <div class="modal-content">
                <div class="modal-body p-0" style="font-size: 15px; line-height: 10px">
                    <form class="form-container" id="forminputdatve">
                        <div class="form-title" style="font-size: 17px">THÔNG TIN ĐẶT VÉ</div>
                        <div class="mt-2 ms-2 px-3">
                            <div class="row justify-content-between" style="font-size: 15px">
                                <div class="col-sm-6" style="font-size: 15px">THÔNG TIN VÉ</div>
                                <div class="col-sm-6" style="font-size: 15px">THÔNG TIN KHÁCH HÀNG</div>
                            </div>
                            <div class="row justify-content-between align-items-center py-1">
                                <div class="col-sm-6" style="line-height: 25px; padding-left: 25px">
                                    <span id="name-tuyen" style="font-size: 15px; padding-left: 15px">KIN GIANG
                                        - CẦN
                                        THơ</span><br>
                                    <span id="name-benxe" style="font-size: 15px; padding-left: 15px">BX.KG -
                                        BX.CT</span>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row g-3 align-items-center justify-content-end">
                                        <div class="col-auto">
                                            <label for="sodienthoai" class="col-form-label" style="font-size: 15px">Số
                                                điện thoại</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" id="sodienthoai" name="sodienthoai"
                                                style="font-size: 15px" class="form-control" aria-describedby="sodienthoai">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-between align-items-center py-1">
                                <div class="col-sm-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-sm-6 text-end">
                                            <label for="trungchuyen" class="col-form-label" style="font-size: 15px">Trung
                                                chuyển</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="trungchuyen" name="trungchuyen"
                                                style="font-size: 15px" class="form-control" aria-describedby="trungchuyen">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row g-3 align-items-center justify-content-end">
                                        <div class="col-auto">
                                            <label for="tenkhach" class="col-form-label" style="font-size: 15px">Tên
                                                khách</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" id="tenkhach" value="" name="tenkhach"
                                                style="font-size: 15px" class="form-control" aria-describedby="tenkhach">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-between align-items-center py-1">
                                <div class="col-sm-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-sm-6 text-end">
                                            <span style="font-size: 15px">Ghế</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span id="position" data-position="" style="font-size: 15px"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row g-3 align-items-center justify-content-end">
                                        <div class="col-auto">
                                            <label for="tenkhach" class="col-form-label" style="font-size: 15px">
                                                Thanh toán
                                            </label>
                                        </div>
                                        <div class="col-auto d-flex flex-row align-items-center">
                                            <div class="form-check form-check-inline d-flex flex-row align-items-center">
                                                <input class="form-check-input" checked type="radio"
                                                    name="redirect" id="inlineRadio1" value="option1">
                                                <label class="form-check-label px-2" for="inlineRadio1"
                                                    style="font-size: 15px">Trực tiếp</label>
                                            </div>
                                            <div class="form-check form-check-inline d-flex flex-row align-items-center">
                                                {{-- <form action=""></form> --}}
                                                <input class="form-check-input" type="radio" name="redirect"
                                                    id="inlineRadio2" value="option2">
                                                <label class="form-check-label px-2" for="inlineRadio2"
                                                    style="font-size: 15px;">
                                                    <img width="55px" style="padding-right: 1px" src="{{ asset('img/icon/logo-primary.55e9c8c.svg') }}" alt="">
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-between align-items-center py-1">
                                <div class="col-sm-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-sm-6 text-end">
                                            <span style="font-size: 15px">Tổng tiền</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span id="tongtien" style="font-size: 15px">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row flex-nowrap justify-content-between align-items-center py-1">

                                <div class="col-sm-4">
                                    <span class="badge bg-danger w-75 my-2 text-end">Ghế đã chọn</span>
                                    <span class="badge bg-info w-75 my-2 text-end">Ghế đang chọn</span>
                                    <span class="badge border w-75 my-2 text-end text-dark">Ghế chưa
                                        chọn</span>
                                </div>
                                <div class="col-sm-8" id="map-seat">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="padding-bottom: 3px; padding-top: 3px">
                    <button type="button" class="btn btn-danger" style="font-size: 15px"
                        data-bs-dismiss="modal">Hủy</button>
                    <button name="submitdatve" class="btn btn-primary" style="font-size: 15px">Xác
                        nhận</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('myscript')
    {{-- <script src="{{ asset('js/fancyTable.min.js') }}"></script> --}}
    <script src="{{ asset('js/chucnangkhach.js') }}"></script>
@endsection
