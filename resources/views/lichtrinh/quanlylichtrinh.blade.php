@extends('layout.main')

@section('user', $_SESSION['username'])
@section('id-nhanvien', $_SESSION['id_nhanvien'])


@section('toolbar')
    <div class="col"></div>
    <div class="col-md-9 my-3 p-0">
        <div class="tool-ve d-flex flex-row align-items-center justify-content-between">
            <form action="/lichtrinh/quanly" method="GET">
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
        <div class="d-flex flex-column mb-2">
            <button name="btnthemmoilichtrinh" class="btn btn-outline-info align-self-end">Thêm mới lịch trình</button>

        </div>
        <div class="container">
            <div class="d-flex flex-column border p-0" style="border-radius: 15px">
                <div style="background-color: blue; color: white; border-radius: 15px 15px 0px 0px"
                    class="text-center border">
                    <span>DANH SÁCH LỊCH TRÌNH</span>
                </div>
                <table id="" class="table example text-center" style="width: 100%">
                    <tr>
                        <th>Xe</th>
                        <th>Tuyến</th>
                        <th>Ngày đi</th>
                        <th>Giờ đi</th>
                        <th>Tài xế</th>
                        <th>Bến đi</th>
                        <th>Bến đến</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            @foreach ($data->datalichtrinh as $item)
                                <tr id="{{ $item->lichtrinh->id_lichtrinh }}">
                                    <td>{{ $item->xe->bienso }}</td>
                                    <td>{{ $data->tuyen->name_tuyen }}</td>
                                    <td>{{ $item->lichtrinh->ngaydi }}</td>
                                    <td>{{ $item->lichtrinh->giodi }}</td>
                                    <td>{{ $item->taixe->name_taixe }}</td>
                                    <td>{{ $item->bendi->name_benxe }}</td>
                                    <td>{{ $item->benden->name_benxe }}</td>
                                    <td>
                                        @if ($item->lichtrinh->tinhtrang == 1)
                                            Chưa khởi hành
                                        @else
                                            Đã khởi hành
                                        @endif
                                    </td>
                                    <td>
                                        <button name="btnsualichtrinh" class="btn btn-info"
                                            style="padding: .2rem .4rem; font-size: 15px;">Sửa</button>
                                        <button name="btnxoalichtrinh" class="btn btn-warning"
                                            style="padding: .2rem .4rem; font-size: 15px;">Xóa</button>
                                    </td>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="modalxoalichtrinh" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Xóa lịch trình
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button id="submitxoalichtrinh" type="button" class="btn btn-warning">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" data-idlichtrinh="" id="modalthemlichtrinh" data-backdrop="static"
                    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalchuyenlichLabel">Thêm lịch trình</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row" id="formsuave">
                                    <div class="col-md-12">
                                        <label class="form-label">Tuyến</label>
                                        <select name="modaltuyen" id="modaltuyen" class="form-select">
                                            @foreach ($tuyens as $tuyen)
                                                <option value="{{ $tuyen->id_tuyen }}">{{ $tuyen->name_tuyen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Bến xe đi</label>
                                        <select name="modalbendi" id="modalbendi" class="form-select">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Bến xe đến</label>
                                        <select name="modalbenden" id="modalbenden" class="form-select">
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Ngày đi</label>
                                        <input type="date" name="modalngaydi" id="modalngaydi" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Giờ đi</label>
                                        <input type="text" name="giodi" id="giodi" class="form-control">
                                    </div>

                                    {{-- <div class="col-md-12">
                                        <br>
                                        <button name="btntimlichtrinh" class="btn btn-primary form-control">Tìm</button>
                                    </div> --}}

                                    <div class="col-md-6">
                                        <label class="form-label">Tài xế</label>
                                        <select name="taixe" id="taixe" class="form-select">
                                            {{-- <option value="-1">None</option> --}}
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Xe</label>
                                        <select name="taixe" id="taixe" class="form-select">
                                            {{-- <option value="-1">None</option> --}}
                                        </select>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button id="submitthemlichtrinh" type="button" class="btn btn-warning">Thêm lịch</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('myscript')
    <script src="{{ asset('js/fancyTable.min.js') }}"></script>
    <script src="{{ asset('js/quanlylichtrinh.js') }}"></script>

@endsection
