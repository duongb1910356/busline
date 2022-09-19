@extends('layout.main-khach')

@section('maincontent')
    <div class="row mt-3 mb-3">
        <div class="col-md-8 ">
            <div class="bi-calendar-event">
                Ngày đăng <span>{{ $tin->ngaytao }}</span>
            </div>
            <hr>
            <div class="mt-2">
                <h5 class="title-artical">
                    {{ $tin->tieude }}
                </h5>

                <div>
                    <img src="<?= 'data:image/jpg;charset=utf8;base64,' . base64_encode($tin->hinhanh) ?>"
                        style="width: 100%;" alt="">
                </div>

                <div class="justify-text" style="font-size: 20px; color: #637280;">
                    {!! $tin->noidung !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @foreach ($dexuats as $dexuat)
                <a href="/tintuc/{{$dexuat->id_tintuc}}" style="text-decoration: none">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img style="height: 112px;"
                                        src="<?= 'data:image/jpg;charset=utf8;base64,' . base64_encode($dexuat->hinhanh) ?>"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body" style="height: 112px; color: black">
                                        <div class="horizontal-content-card">
                                            {{$dexuat->tieude}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('myscript')
    <script src="{{ asset('js/fancyTable.min.js') }}"></script>
    <script src="{{ asset('js/quanlylichtrinh.js') }}"></script>
@endsection
