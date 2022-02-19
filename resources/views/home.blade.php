@extends('layouts.app')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Home</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}"> --}}
    <!-- Theme style -->
    <!-- Daterange picker -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}"> --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400&display=swap');

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <h3 class="text-center">فندق الفيصل</h3>
        </div>
        <div class="row pt-5">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hands-wash"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">الغرف تحت التنظيف</span>
                        <span class="info-box-number">
                            {{ $rooms4 }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">الغرف الجاهزة</span>
                        <span class="info-box-number">{{ $rooms1 }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">الغرف الساكنة</span>
                        <span class="info-box-number">{{ $rooms2 }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tools"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">الغرف خارج الخدمة</span>
                        <span class="info-box-number">{{ $rooms3 }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="pt-5 h4">
            الغرف الساكنة:
        </div>
        <div class="row">
            @if (count($rooms))
                @foreach ($rooms as $room)
                    <x-room :room="$room" :guests="$guests" :roomprices="$roomprices" :institutions="$institutions"
                        :meals="$meals" :clothes="$clothes" :rooms="$rooms" :roomall="$roomall" :accounts="$accounts"/>
                @endforeach
            @endif
        </div>
        <div class="row mt-5 justify-content-center">
            {{ $rooms->links() }}
        </div>
        @if (count($guests2))
            <div class="pt-3 h4">
                آخر النزلاء:
            </div>
            <div class="row">
                @foreach ($guests2 as $guest)
                    @include('guests.edit')
                    @include('guests.delete')
                    <div class="col-md-4">
                        <!-- Widget: user widget style 2 -->
                        <div class="card card-widget widget-user-2 shadow">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            @if ($guest->room)
                                <div class="widget-user-header bg-success">
                            @elseif($guest->roomPartner)
                                <div class="widget-user-header bg-success">
                            @else
                                <div class="widget-user-header bg-info">
                            @endif
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ asset('img/user.png') }}"
                                        alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-desc">{{ $guest->id }}</h3>
                                <h3 class="widget-user-desc">{{ $guest->name }}</h3>
                                <h4 class="widget-user-username">{{ $guest->institution }}</h4>
                                <h5 class="widget-user-username">
                                    {{ $guest->phone }}
                                </h5>
                                <div>
                                    <b>إثبات الشخصية : {{ $guest->identity }}</b>
                                </div>
                                <div>
                                    <b>رقم إثبات الشخصية : {{ $guest->identityId }}</b>
                                </div>
                                <p>
                                    @if ($guest->room) ساكن {{ $guest->room->number }} @elseif($guest->roomPartner) مرافق {{ $guest->roomPartner->number }} @else غير ساكن @endif
                                </p>
                                <div class="d-flex mt-4 mb-2">
                                    {{-- <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#deleteGuest{{ $guest->id }}">
                                        <i class="fas fa-trash text-danger fa-lg"></i>
                                    </button> --}}
                                    <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#editGuest{{ $guest->id }}">
                                        <i class="fas fa-edit text-warning fa-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                @endforeach
            </div>
        @else
            <p>لا يوجد نزلاء حتى الآن</p>
        @endif
    </div>
@endsection
