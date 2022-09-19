@extends('layout.main')

@section('user', $_SESSION['username'])
@section('id-nhanvien', $_SESSION['id_nhanvien'])


@section('toolbar')
    <div class="col"></div>
    <div class="col-md-9 my-3 p-0">
        <div class="tool-ve d-flex flex-row align-items-center justify-content-between">
            <form>
                <div class="d-inline-flex">
                    <label class="col-form-label px-2" for="tuyen">TUYẾN</label>
                    <select class="form-select" name="tuyen" id="tuyen" aria-label="Default select example">
                        <option value="-1">Tất cả</option>
                        @foreach ($tuyens as $tuyen)
                            <option value="{{ $tuyen->id_tuyen }}">{{ $tuyen->name_tuyen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-inline-flex">
                    <label for="ngaydi" style="min-width: 120px;" class="px-3 my-auto">Ngày đi</label>
                    <input type="date" id="ngaydi" name="ngaydi" value="" class="form-control taskbar-date">
                </div>
            </form>
        </div>
    </div>
    <div class="col"></div>
@endsection

@section('maincontent')
    <div class="toast-container start-0 p-4" style="position: absolute; top: 0; right: 0;">

    </div>
    <div class="row mx-0 my-1 px-4 wrap-content" id="maincontent" data-trigger="{{ $trigger }}"></div>

    <div class="modal fade" data-idgiave="" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl p-0">
            <div class="modal-content">
                <div class="modal-body p-0" style="font-size: 15px; line-height: 10px">
                    <form id="formdatve">
                        <div class="form-container">
                            <div class="form-title" style="font-size: 17px">THÔNG TIN ĐẶT VÉ</div>
                            <div class="mt-2 ms-2 px-3">
                                <div class="row justify-content-between" style="font-size: 15px">
                                    <div class="col-sm-6" style="font-size: 15px">THÔNG TIN VÉ</div>
                                    <div class="col-sm-6" style="font-size: 15px">THÔNG TIN KHÁCH HÀNG</div>
                                </div>
                                <div class="row justify-content-between align-items-center py-1">
                                    <div class="col-sm-6" style="line-height: 25px; padding-left: 25px">
                                        <span id="name-tuyen" style="font-size: 15px; padding-left: 15px">KIÊN GIANG - CẦN
                                            THơ</span><br>
                                        <span id="name-benxe" style="font-size: 15px; padding-left: 15px"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row g-3 align-items-center justify-content-end">
                                            <div class="col-auto">
                                                <label for="sodienthoai" class="col-form-label" style="font-size: 15px">Số
                                                    điện thoại</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="text" id="sodienthoai" name="sodienthoai"
                                                    style="font-size: 15px" class="form-control"
                                                    aria-describedby="sodienthoai">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between align-items-center py-1">
                                    <div class="col-sm-6">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-sm-6 text-end">
                                                <label for="trungchuyen" class="col-form-label"
                                                    style="font-size: 15px">Trung
                                                    chuyển</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" id="trungchuyen" name="trungchuyen"
                                                    style="font-size: 15px" class="form-control"
                                                    aria-describedby="trungchuyen">
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
                                                    style="font-size: 15px" class="form-control"
                                                    aria-describedby="tenkhach">
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
                                                {{-- <input class="border-0" type="text" name="seat[]" value="" /> --}}
                                                <span id="position" data-position="" style="font-size: 15px"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between align-items-center py-1">
                                    <div class="col-sm-6">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-sm-6 text-end">
                                                {{-- <label for="inputPassword6" class="col-form-label"  style="font-size: 15px">Tổng tiền</label> --}}
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
                        </div>
                    </form>

                </div>
                <div class="modal-footer" style="padding-bottom: 3px; padding-top: 3px">
                    <button type="button" class="btn btn-danger" style="font-size: 15px"
                        data-bs-dismiss="modal">Hủy</button>
                    <button name="submitdatve" class="btn btn-primary" style="font-size: 15px">Xác nhận</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('myscript')
    <script src="{{ asset('js/ve.js') }}"></script>
    <script src="{{ asset('js/pdf.js') }}"></script>
    {{-- <script>
        function createPDF() {
            window.print();
        }

        function PrintDiv(div_id) {
            $('body').css("visibility", "hidden");
            $("#" + div_id).css("visibility", "visible");
            window.print();
            $("#" + div_id).css("visibility", "hidden");
            $('body').css("visibility", "visible");
        }
    </script> --}}
@endsection
