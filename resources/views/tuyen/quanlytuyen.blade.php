@extends('layout.main')

@section('mycss')
    <link rel="stylesheet" href="{{ asset('css/filter_multi_select.css') }}">
@endsection

@section('id-nhanvien', $_SESSION['id_nhanvien'])

@section('toolbar')
    <div class="col"></div>
    {{-- <div class="col-md-9 my-3 p-0">
        <div class="tool-ve d-flex flex-row align-items-center justify-content-center">
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
                <div class="d-inline-flex px-3">
                    <button id="searchlistve" type="submit" class="btn btn-outline-info">Search</button>
                </div>
            </form>
        </div>
    </div> --}}
    <div class="col"></div>
@endsection

@section('maincontent')
    <div class="row mx-0 my-1 px-4">
        <div class="d-flex flex-column mb-2">
            <button name="btnthemmoituyen" class="btn btn-outline-info align-self-end"><i class="bi bi-plus-circle"></i>&nbsp; Thêm mới tuyến</button>

        </div>
        <div class="container">
            <div class="d-flex flex-column border p-0" style="border-radius: 15px">
                <div style="background-color: blue; color: white; border-radius: 15px 15px 0px 0px"
                    class="text-center border">
                    <span>DANH SÁCH TUYẾN</span>
                </div>
                <table id="" class="table example text-center" style="width: 100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã tuyến</th>
                            <th>Tên tuyến</th>
                            <th>Tỉnh đi</th>
                            <th>Tỉnh đến</th>
                            <th>Khoảng cách (km)</th>
                            <th>Thời gian di chuyển (phút)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listtuyen as $tuyen)
                            <tr data-nametuyen="{{ $tuyen->name_tuyen }}">
                                <td>{{ $loop->index }}</td>
                                <td>{{ $tuyen->id_tuyen }}</td>
                                <td>{{ $tuyen->name_tuyen }}</td>
                                <td>{{ $tuyen->getTinhDi()->name_tinh }}</td>
                                <td>{{ $tuyen->getTinhDen()->name_tinh }}</td>
                                <td>{{ $tuyen->khoangcach }}</td>
                                <td>{{ $tuyen->thoigian }}</td>
                                <td data-idtuyen="{{ $tuyen->id_tuyen }}" data-thoigian="{{ $tuyen->thoigian }}"
                                    data-khoangcach="{{ $tuyen->khoangcach }}" data-nametuyen="{{ $tuyen->name_tuyen }}"
                                    data-idtuyen="{{ $tuyen->id_tuyen }}"
                                    data-idtinhdi="{{ $tuyen->getTinhDi()->id_tinh }}"
                                    data-idtinhden="{{ $tuyen->getTinhDen()->id_tinh }}">
                                    <button name="btnsuatuyen" class="btn btn-info" data-bs-placement="top" title = "Sửa tuyến"
                                        style="padding: .2rem .4rem; font-size: 15px;"><i class="bi bi-gear"></i></button>
                                    <button data-idtuyen="{{ $tuyen->id_tuyen }}" name="btnxoatuyen" data-bs-placement="top" title = "Xóa tuyến" 
                                        class="btn btn-warning" style="padding: .2rem .4rem; font-size: 15px;"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="modalxoatuyen" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Xóa tuyến &nbsp;<span id="modalnametuyen"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button id="submitxoalichtrinh" type="button" class="btn btn-warning">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" data-idlichtrinh="" id="modalcapnhattuyen" data-backdrop="static"
                    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalchuyenlichLabel">Sửa tuyến</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row" id="formsuatuyen">
                                    <div class="col-md-12">
                                        <label class="form-label">Tên tuyến</label>
                                        <input type="text" id="inputtentuyen" name="inputtentuyen" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tỉnh đi</label>
                                        <select name="modalbendi" id="selecttinhdi" class="form-select">
                                            @foreach ($tinhs as $tinh)
                                                <option value="{{ $tinh->id_tinh }}">{{ $tinh->name_tinh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tỉnh đến</label>
                                        <select name="modalbenden" id="selecttinhden" class="form-select">
                                            @foreach ($tinhs as $tinh)
                                                <option value="{{ $tinh->id_tinh }}">{{ $tinh->name_tinh }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Khoảng cách</label>
                                        <input type="text" name="inputkhoangcach" id="inputkhoangcach"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Thời gian</label>
                                        <input type="text" name="inputthoigian" id="inputthoigian"
                                            class="form-control">
                                    </div>

                                    {{-- <div class="col-md-12">
                                        <br>
                                        <button name="btntimlichtrinh" class="btn btn-primary form-control">Tìm</button>
                                    </div> --}}

                                    <div class="col-md-12">
                                        <label class="form-label">Bến xe</label>
                                        <select multiple="multiple" name="chonbenxe[]" id="chonbenxe">
                                            @foreach ($benxes as $benxe)
                                                <option value="{{ $benxe->id_benxe }}">{{ $benxe->name_benxe }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button id="submitcapnhattuyen" type="button" class="btn btn-warning">Cập nhật</button>
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
    <script src="{{ asset('js/quanlytuyen.js') }}"></script>
    <script src="{{ asset('js/filter-multi-select-bundle.min.js') }}"></script>

@endsection
