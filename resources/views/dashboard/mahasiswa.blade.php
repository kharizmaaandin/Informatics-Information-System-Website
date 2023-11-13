@extends('layout')
@section('content')
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-6 col-xl-3 border-light">

                <div class="card-body">
                    <h5 class="text-white mb-0">{{$user->mahasiswa->pkl->status_pkl}} <span class="float-right"><i class="fa fa-building"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status PKL </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">{{$user->mahasiswa->skripsi->status_skripsi}} <span class="float-right"><i class="fa fa-book"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status Skripsi</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">{{$user->mahasiswa->status}} <span class="float-right"><i class="fa fa-eye"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status Aktif </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h7 class="text-white mb-0">{{$user->mahasiswa->doswal->nama}} <span class="float-right"><i class="fa fa-chalkboard-teacher"></i></span></h7>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Dosen Wali </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @if($user->mahasiswa->khs != NULL)
                    <h7 class="text-white mb-0">{{$user->mahasiswa->khs->IP_Kumulatif}} <span class="float-right"><i class="fas fa-star"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0.00 <span class="float-right"><i class="fas fa-star"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">IPK </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @if($user->mahasiswa->khs != NULL)
                    <h7 class="text-white mb-0">{{$user->mahasiswa->khs->IP_smt}} <span class="float-right"><i class="fas fa-star-half"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0.00 <span class="float-right"><i class="fas fa-star-half"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">IP Semester</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @if($user->mahasiswa->khs != NULL)
                    <h7 class="text-white mb-0">{{$user->mahasiswa->khs->SKS_kumulatif}} <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0 <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Jumlah SKS Kumulatif </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @if($user->mahasiswa->irs != NULL)
                    <h7 class="text-white mb-0">{{$user->mahasiswa->irs->jumlah_sks}} <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0 <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Jumlah SKS </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection