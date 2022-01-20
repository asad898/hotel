@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Guests</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    @include('guests.create')

    <div class="container-fluid">
        <h1 class="text-center">عرض النزلاء</h1>
        <!-- Button trigger modal -->
        <div class="justify-content-between row">
            
            <div class="col-md-6 mt-3">
                <form action="{{ route('guests') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث عن نزيل" id="term">
                        <a href="{{ route('guests') }}" class="">
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createGuest">
                    <i class="fas fa-plus"></i>
                    إضافة نزيل جديد
                </button>
            </div>

        </div>
        @if (count($guests))
            <div class="row pt-3">
                @foreach ($guests as $guest)
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
            <div class="row mt-4 justify-content-center">
                {{ $guests->links() }}
            </div>
        @else
            <p>لا يوجد نزلاء حتى الآن</p>
        @endif

    </div>
@endsection
