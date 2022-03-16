@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Room Pricing</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    @include('roomsprices.create')
    <div class="container-fluid">
        <h1 class="text-center">اسعار الغرف</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRoomPrice">
            <i class="fas fa-plus"></i>
            إضافة تصنيف
        </button>
        <div class="row pt-3">
            @if (count($roomsprices))
                @foreach ($roomsprices as $roomprice)
                    @include('roomsprices.edit')
                    @include('roomsprices.delete')
                    <div class="col-md-6 col-12">
                        <div class="info-box bg-gradient-warning">
                            {{-- <span class="info-box-icon"><i class="far fa-dollar"></i></span> --}}

                            <div class="info-box-content">
                                <h4 class="ml-2">{{ $roomprice->desc }}</h4>
                                <div class="row">
                                    <div class="px-2 text-center">
                                        <span class="info-box-text">إيجار</span>
                                        <span class="info-box-number">{{ $roomprice->rent }}</span>
                                    </div>
                                    <div class="px-2 text-center">
                                        <span class="info-box-text">ضريبة</span>
                                        <span class="info-box-number">{{ $roomprice->tax }}</span>
                                    </div>
                                    <div class="px-2 text-center">
                                        <span class="info-box-text">سياحة</span>
                                        <span class="info-box-number">{{ $roomprice->tourism }}</span>
                                    </div>
                                    <div class="px-2 text-center">
                                        <span class="info-box-text">ثابت 1.2285</span>
                                        <span class="info-box-number">{{ $roomprice->sNumber }}</span>
                                    </div>

                                </div>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    غير شامل الضريبة <b>${{ $roomprice->price }}</b>
                                </span>
                                <div class="card-tools pt-2">
                                    {{-- <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#deleteRoomPrice{{ $roomprice->id }}">
                                        <i class="fas fa-lg fa-trash text-danger"></i>
                                    </button> --}}
                                    <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#editRoomPrice{{ $roomprice->id }}">
                                        <i class="fas fa-lg fa-edit text-info"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            @else
                <p>لا توجد تصنيفات اسعار حتى الآن</p>
            @endif
        </div>
    </div>
@endsection
