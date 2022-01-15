@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - clothes</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    @include('clothes.create')
    <div class="container-fluid">
        <h1 class="text-center">الملابس</h1>
        <div class="justify-content-between row">

            <div class="col-md-6 mt-3">
                <form action="{{ route('clothes') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث" id="term">
                        <a href="{{ route('clothes') }}" class="">
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createClothe">
                    <i class="fas fa-plus"></i>
                    إضافة ملابس
                </button>
            </div>

        </div>
        <div class="row pt-3">
            @if (count($clothes))
                @foreach ($clothes as $clothe)
                @include('clothes.edit')
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-socks"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $clothe->name }}</span>
                                <div class="d-flex">
                                    <span class="info-box-number">{{ $clothe->price }} ج</span>
                                     <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#editClothe{{ $clothe->id }}">
                                        <i class="fas fa-edit text-warning fa-lg"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#deleteClothe{{ $clothe->id }}">
                                        <i class="fas fa-trash text-danger fa-lg"></i>
                                    </button> --}}
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            @else
                <p>لا توجد انوع ملابوسات حتى الآن</p>
            @endif
        </div>
    </div>
@endsection
