@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Rooms</title>
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
@endsection
@section('content')
    <div class="container-fluid">
        <h1 class="text-center">عرض الغرف</h1>
        <!-- Button trigger modal -->
        <div class="justify-content-between row">

            <div class="col-md-6 mt-3">
                <form action="{{ route('rooms') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث" id="term">
                        <a href="{{ route('rooms') }}" class="">
                            <span class="input-group-btn">
                                <button class="btn btn-danger rounded-0" type="button" title="Refresh page">
                                    <span class="fas fa-sync-alt"></span>
                                </button>
                            </span>
                        </a>
                    </div>
                </form>
            </div>

            <div class="col-md-6 d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRoom">
                    <i class="fas fa-plus"></i>
                    إضافة غرفة جديدة
                </button>
            </div>

        </div>
        <div class="row pt-3">
            @if (count($rooms))
                @foreach ($rooms as $room)
                    <x-room :room="$room" :guests="$guests" :roomprices="$roomprices" :institutions="$institutions" />
                @endforeach
            @else
                <p>لا توجد غرف حتى الآن</p>
            @endif
        </div>
    </div>
@endsection
