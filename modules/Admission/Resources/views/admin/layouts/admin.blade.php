@extends('layouts.default')

@section('title')@yield('subtitle') Administrasi - {{ config('admission.head.title') }}@endsection

@section('bodyclass', 'app header-fixed sidebar-fixed sidebar-lg-show')

@section('main')
    @include('admission::admin.layouts.includes.navbar')
    <div class="app-body">
        @include('admission::admin.layouts.includes.sidebar')
        <main class="main pb-2">
            <ol class="breadcrumb mb-0 border-bottom border-light">
                @yield('breadcrumb')
            </ol>
            <p class="mb-3 mb-sm-4"></p>
            <div class="container-fluid px-3 px-sm-4">
                @yield('section')
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {!! session('success') !!}
                    </div>
                @endif
                
                @if(session()->has('danger'))
                    <div class="alert alert-danger alert-dismissible show fade">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {!! session('danger') !!}
                    </div>
                @endif

                @if($errors->any() && config('admission.display_error_validations', false))
                    <div class="alert alert-danger alert-dismissible show fade">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Terjadi kegagalan, silahkan periksa kembali isian Anda:
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $key => $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="animated fadeIn">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    @include('admission::admin.layouts.includes.footer')
    @include('account::includes.logout', ['next' => route('admission.index')])
@endsection