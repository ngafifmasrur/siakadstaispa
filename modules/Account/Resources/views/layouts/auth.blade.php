@extends('layouts.default')

@section('title')@yield('subtitle'){{ config('web.head.title') }}@endsection

@section('bodyclass', 'vh-100 d-flex align-items-center')

@section('main')
    <div class="container">
        <div class="row justify-content-center py-3 ">
            <div class="@hasSection('help') col-lg-8 @else col-lg-5 col-md-8 col-sm-10 @endif">
                <div class="card-group">
                    @yield('help')
                    <div class="card">
                        <div class="list-group list-group-flush">
                            
                            @if (session()->has('success'))
                                <div class="list-group-item list-group-item-info border-0 px-4">
                                    {!! session('success') !!}
                                </div>
                            @endif

                            @if (session()->has('danger'))
                                <div class="list-group-item list-group-item-danger border-0 px-4">
                                    {!! session('danger') !!}
                                </div>
                            @endif

                            <div class="list-group-item p-4 border-0">
                                <h2 class="card-title mb-1">
                                    @yield('card-title')
                                </h2>
                                <div class="text-muted">{{ config('account.doctitle') }}</div>
                                <hr>
                                <div class="animated fadeIn">
                                    @yield('content')
                                </div>
                            </div>

                        </div>
                        @yield('oauth')
                    </div>
                </div>
                <footer class="text-center my-2">
                    <span class="text-muted">Powered by <a href="{{ route('admission.index') }}">{{ env('APP_NAME') }}</a> &copy; 2019</span>
                </footer>
            </div>
        </div>
    </div>
@endsection