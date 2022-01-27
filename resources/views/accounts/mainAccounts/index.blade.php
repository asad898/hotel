@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Main - Accounts</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@section('content')
    <h3 class="text-center mb-5">الحسابات الرئيسية</h3>
    <div class="row pt-3 justify-content-center m-0">
        @if (count($mainAccounts))
            @foreach ($mainAccounts as $mainAccount)
                <a href="{{ route('main.accounts.show', $mainAccount) }}" class="col-md-6 col-sm-6 col-12 text-decoration-none text-dark">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-piggy-bank"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ $mainAccount->acc_name }}</span>
                            <div class="d-flex">
                                {{-- <span class="info-box-number">{{ $mainAccount->price }} ج</span> --}}
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            @endforeach
        @endif
    </div>
@endsection
