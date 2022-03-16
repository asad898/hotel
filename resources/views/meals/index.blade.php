@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Meals</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    @include('meals.create')
    @include('meals.editTax')
    @include('restaurants.newbills.newbill')
    <div class="container-fluid">
        <h1 class="text-center">المطعم</h1>
        <div class="justify-content-between row">

            <div class="col-md-6 mt-3">
                <form action="{{ route('meals') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث" id="term">
                        <a href="{{ route('meals') }}" class="">
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
                <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#createMeal">
                    <i class="fas fa-plus"></i>
                    إضافة وجبة جديدة
                </button>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newbill">
                    فاتورة مطعم
                </button>
            </div>

        </div>
        @if (auth()->user()->mm)
            <div class="row mt-3">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-balance-scale-left"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>الضريبة : </b>{{ $tax->tax }} %</span>
                            <span class="info-box-text"><b>الدمغة : </b>{{ $tax->tourism }} ج</span>
                            <div class="d-flex mt-2">
                                <span class="info-box-number"></span>
                                @if (auth()->user()->am)
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#editTax{{ $tax->id }}">
                                    <i class="fas fa-edit text-info fa-lg"></i>
                                </button>
                                @endif
                                {{-- <button type="button" class="btn btn-tool" data-toggle="modal"
                                data-target="#deleteMeal{{ $meal->id }}">
                                <i class="fas fa-trash text-danger fa-lg"></i>
                            </button> --}}
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        @endif
        <div class="row pt-3">
            @if (count($meals))
                @foreach ($meals as $meal)
                    @include('meals.edit')
                    @include('meals.delete')
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-pizza-slice"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $meal->name }}</span>
                                <div class="d-flex">
                                    <span class="info-box-number">{{ $meal->price }} ج</span>
                                    @if (auth()->user()->mm)
                                    <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#editMeal{{ $meal->id }}">
                                        <i class="fas fa-edit text-warning fa-lg"></i>
                                    </button>
                                    @endif
                                    {{-- <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#deleteMeal{{ $meal->id }}">
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
                <p>لا توجد وجبات حتى الآن</p>
            @endif
        </div>
    </div>
@endsection
