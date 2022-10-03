@extends('layout.main')

@section('id-nhanvien', $_SESSION['id_nhanvien'])


@section('toolbar')
    <div class="col"></div>
    <div class="col-md-9 my-3 p-0">
        <div class="tool-ve d-flex flex-row align-items-center justify-content-between">
            <form action="/ve/quanlyve" method="GET">
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

                <div class="d-inline-flex px-3">
                    <button id="searchlistve" type="submit" class="btn btn-outline-info">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col"></div>
@endsection

@section('maincontent')
    <div class="row mx-0 my-1 px-4">
        <div class="container">

            <div class="d-flex flex-column border p-0" style="border-radius: 15px">
                <div style="background-color: blue; color: white; border-radius: 15px 15px 0px 0px"
                    class="text-center border">
                    <span>LỊCH TRÌNH THEO TUYẾN</span>
                    {{-- <span style="padding-left: 10px;">{{ $lichtrinh->giodi }}</span>
                        <span>{{ $lichtrinh->ngaydi }}</span> --}}
                </div>
                <table id="" class="table example text-center" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Tuyến</th>
                            <th>Ngày đi</th>
                            <th>Giờ đi</th>
                            <th>Thời gian (phút)</th>
                            <th>Tình trạng khởi hành</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 0; ?>
                        @foreach ($tuyenlich as $tuyen)
                            @foreach ($tuyen->lichtrinh as $lichtrinh)
                                <tr id="{{ $lichtrinh->id_lichtrinh }}">
                                    <?php $index = $index + 1; ?>
                                    <td>{{ $index }}</td>
                                    <td>{{ $tuyen->tuyen->name_tuyen }}</td>
                                    <td>{{ $lichtrinh->ngaydi }}</td>
                                    <td>{{ $lichtrinh->giodi }}</td>
                                    <td>{{ $tuyen->tuyen->thoigian }}</td>
                                    <td>
                                        @if ($lichtrinh->tinhtrang == 1)
                                            Chưa khởi hành
                                        @else
                                            Đã khởi hành
                                        @endif
                                    </td>
                                    <style>
                                        .tooltip-inner {
                                            background-color: white;
                                            box-shadow: 0px 0px 4px black;
                                            opacity: 1 !important;
                                            color: black;
                                            font-size: 15px;
                                        }
                                    </style>
                                    <td>
                                        <button name="btnxemlistve" class="btn btn-outline-info"
                                            data-bs-placement="top" title="Xem chi tiết danh sách vé"
                                            style="padding: .2rem .4rem; font-size: 15px;">
                                            <i class="bi bi-card-checklist"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div id="lichtrinhchitet" class="d-flex flex-column border p-0" style="border-radius: 15px">
                <div style="background-color: blue; color: white; border-radius: 15px 15px 0px 0px"
                    class="text-center border">
                    <span>LỊCH TRÌNH CHI TIẾT</span>
                    {{-- <span style="padding-left: 10px;">{{ $lichtrinh->giodi }}</span>
                            <span>{{ $lichtrinh->ngaydi }}</span> --}}
                </div>
                <table name="listve" id="" class="table example text-center" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 9%;">Tên khách</th>
                            <th style="width: 9%;">Số điện thoại</th>
                            <th style="width: 9%;">Trung chuyển</th>
                            <th style="width: 9%;">Bến xe đi</th>
                            <th style="width: 9%;">Bến xe đến</th>
                            <th style="width: 7%;">Ngày đi</th>
                            <th style="width: 7%;">Giá vé</th>
                            <th style="width: 7%;">Vị trí ngồi</th>
                            <th style="width: 10%;">Tình trạng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="bodylistve">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tbody>
                </table>

            </div>
        </div>

        <div id="divinve" style="border: 1px solid; width: 360px; height: auto; visibility: hidden; padding: 0px">
            <div style="position: relative; height: 10%; background-color: red; font-weight: bold; width: 100%;"
                class="text-center text-white">
                VÉ LÊN XE
            </div>
            <div style="position: relative; height: 90%; padding: 8px;">
                <div class="text-center">
                    <span id="tentuyen">Cần Thơ - Cà Mau</span><br>
                    <span>Số xe: </span><span id="biensoxe">58B - X1</span><br>
                </div>
                <hr>
                <div style="" class="d-flex flex-row">
                    <div class="d-flex flex-column">
                        <span>Bến đi </span>
                        <span>Bến đến </span>
                        <span>Giờ khởi hành </span>
                        <span>Ngày khởi hành </span>
                        <span>Số ghế </span>
                        <span>Giá vé </span>
                        <span>Tên khách </span>
                        <span>Số điện thoại </span>
                    </div>
                    <div class="d-flex flex-column ps-3 fw-bold">
                        <span id="bendi">BX.Kiên Giang</span>
                        <span id="benden">BX.Cần Thơ</span>
                        <span id="giokhoihanh">17 : 50</span>
                        <span id="ngaykhoihanh">25-9-2022</span>
                        <span id="vitri">13</span>
                        <span id="giatien">130 000</span>
                        <span id="tenkhach">Trần Căn A</span>
                        <span id="sodienthoai">0123456789</span>
                    </div>
                </div>
                <div class="text-center border">
                    <i>Thượng lộ bình an!</i>
                </div>
            </div>
        </div>



        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Xóa vé
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button id="submitmodalxoa" type="button" class="btn btn-warning">Xóa</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDoiCho" tabindex="-1" aria-labelledby="modalDoiCho" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDoiChoLabel">Thông báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalseat">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button id="submitdoicho" type="button" class="btn btn-warning">Chuyển ghế</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" data-idlichtrinh="" id="modalchuyenlich" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalchuyenlichLabel">Cập nhật vé</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row" id="formsuave">
                            <div class="col-md-6">
                                <label class="form-label">Họ tên khách</label>
                                <input type="text" id="tenkhach" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" id="sodienthoai" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Trung chuyển</label>
                                <input type="text" id="trungchuyen" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tuyến</label>
                                <select name="suatuyen" id="suatuyen" class="form-select">
                                    @foreach ($tuyens as $tuyen)
                                        <option value="{{ $tuyen->id_tuyen }}">{{ $tuyen->name_tuyen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày</label>
                                <input type="date" name="suangay" id="suangay" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <br>
                                <button name="btntimlichtrinh" class="btn btn-primary form-control">Tìm</button>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Lịch xe chạy</label>
                                <select name="lichxechay" id="lichxechay" class="form-select">
                                </select>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px" id="seat">

                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button id="submitcapnhat" type="button" class="btn btn-warning">Cập nhật</button>
                    </div>

                </div>
            </div>
        </div> --}}

    </div>
    <style>
        .custom-popover {
            --bs-popover-max-width: 200px;
            --bs-popover-border-color: var(--bs-primary);
            --bs-popover-header-bg: var(--bs-primary);
            --bs-popover-header-color: var(--bs-white);
            --bs-popover-body-padding-x: 1rem;
            --bs-popover-body-padding-y: .5rem;
        }
    </style>
    
@endsection

@section('myscript')
    <script src="{{ asset('js/fancyTable.min.js') }}"></script>
    <script src="{{ asset('js/quanlyve.js') }}"></script>
    
@endsection
