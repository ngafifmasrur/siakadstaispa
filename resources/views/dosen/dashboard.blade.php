@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <ol class="breadcrumb"><!-- breadcrumb -->
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <?php
            $segments = '';
            $total_segments = count(Request::segments());
        ?>
        @foreach(Request::segments() as $key => $segment)
            <?php $segments .= '/'.$segment; ?>
            <li class="breadcrumb-item {{ $key+1 == $total_segments ? 'active' : ''}}" aria-current="page">{{ ucwords(str_replace('_', ' ',$segment)) }}</li>
        @endforeach
    </ol>
</div>

<div class="row">
    <div class="col-lg-3 col-md-12">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-body pb-0">
                        <div id="cal" class="mb-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card border-0">
            <div class="card-header custom-header pb-0">
                <div>
                    <h3 class="card-title">Jadwal Kuliah</h3>
                    <h6 class="card-subtitle">{{ Carbon\Carbon::now()->isoFormat('dddd, M Y')}}</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @foreach ($kelasKuliah as $item)
                        <div class="card">
                            <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        {{-- <small class="block">{{ $item->tanggal_mulai_efektif.' - '.$item->tanggal_akhir_efektif }}</small> --}}
                                        <strong  class="block">{{ $item->nama_mata_kuliah }}</strong>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <span class="block mb-1"><i class="fa fa-calendar mr-1"></i> {{ $item->nama_semester }}</span>
                                        <span class="block mb-1"><i class="fa fa-bank mr-1"></i>Kelas {{ $item->nama_kelas_kuliah }}</span>
                                        <span class="block mb-1"><i class="fa fa-book mr-1"></i> {{ $item->nama_program_studi }}</span>

                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            Perkuliahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-12">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3 class="card-title">Informasi Terbaru</h3>
                    </div>
                    <div class="card-body p-0 ">
                        <div class="list-group list-lg-group list-group-flush">
                            <a class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle mr-3" src="{{ asset('landing_page/images/imp_logo.png') }}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-md-flex align-items-center">
                                            <h4 class="mb-1">
                                                Lorem isum dolor sit amet
                                            </h4>
                                        </div>
    
                                        <p class="mb-0">Itaque earum rerum hic tenetur a sapiente reiciendis voluptatibus.</p>
                                        <small class="text-primary ml-md-auto"><i class="fe fe-calendar mr-1"></i> 26 Feb 2019</small>

                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle mr-3" src="{{ asset('landing_page/images/imp_logo.png') }}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-md-flex align-items-center">
                                            <h4 class="mb-1">
                                                Lorem isum dolor sit amet
                                            </h4>
                                        </div>
    
                                        <p class="mb-0">Itaque earum rerum hic tenetur a sapiente reiciendis voluptatibus.</p>
                                        <small class="text-primary ml-md-auto"><i class="fe fe-calendar mr-1"></i> 26 Feb 2019</small>

                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle mr-3" src="{{ asset('landing_page/images/imp_logo.png') }}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-md-flex align-items-center">
                                            <h4 class="mb-1">
                                                Lorem isum dolor sit amet
                                            </h4>br
                                        </div>
                                        <p class="mb-0">Itaque earum rerum hic tenetur a sapiente reiciendis voluptatibus.</p>
                                        <small class="text-primary ml-md-auto"><i class="fe fe-calendar mr-1"></i> 26 Feb 2019</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="mt-auto mb-auto">
                            <a href="#" class="text-primary p-2">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <link href="{{ asset('sparic/css/calendar.css') }}" rel="stylesheet" />
    <style>
        .view-more {
            /* border-radius: 10rem; */
            /* padding-left: 0.9em; */
            /* padding-right: 0.9em; */
            padding-top: 0.1em;
            padding-bottom: 0.1em;
        }

        p, ul, ol {
            list-style-type: none!important;
            margin: 0!important;
            padding: 0!important;
        }

        .calendar-hd {
            padding: 0!important;
            height: 30px;
            line-height: 30px;
        }
    </style>
@endpush

@push('js')
    <!-- Default Calendar js-->
    <script src="{{ asset('sparic/js/calendar.js') }}"></script>
    <script>
        $('#cal').calendar({
            monthArray: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            weekArray: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        });
    </script>
@endpush