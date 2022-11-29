@extends('layout.main-khach')

@section('maincontent')
    <div id="carouselExampleIndicators" class="carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            @foreach ($carousel as $car)
                <a href="/tintuc/{{ $car->id_tintuc }}">
                    <div class="carousel-item active">
                        <img style="height: 350px" src="<?= 'data:image/jpg;charset=utf8;base64,' . base64_encode($car->hinhanh) ?>"
                            class="d-block w-100" alt="{{ $car->tieude }}">
                    </div>
                </a>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="col-md-12 mt-5">
        <h4>Tin nổi bật <hr></h4>
    </div>

    <div class="col-md-7" id="tinchinh">
        <a href="/tintuc/{{ $tinchinh->id_tintuc }}" style="text-decoration: none" class="">
            <div class="card" style="width: 100%;">
                <img src="<?= 'data:image/jpg;charset=utf8;base64,' . base64_encode($tinchinh->hinhanh) ?>"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="color: black">{{ $tinchinh->tieude }}</h5>
                    <p class="card-text horizontal-content-card" style="height: 80px; font-size: 15px; color: #637280;">
                        {{ $tinchinh->noidung }}</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-5">
        @foreach ($tins as $tin)
            <div class="col-md-12">
                <a href="/tintuc/{{ $tin->id_tintuc }}" style="text-decoration: none">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img style="height: 112px;"
                                    src="<?= 'data:image/jpg;charset=utf8;base64,' . base64_encode($tin->hinhanh) ?>"
                                    class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body" style="height: 112px;">
                                    <div class="horizontal-content-card" style="color: black">
                                        {{ $tin->tieude }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
@endsection

@section('myscript')
    <script src="{{ asset('js/quanlylichtrinh.js') }}"></script>
@endsection
