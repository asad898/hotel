@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>المخزن</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    @include('stores.create')
    @include('stores.bills.createBill')
    <div class="container-fluid">
        <h1 class="text-center my-3">المخزن</h1>
        <div class="justify-content-between row unprint">
            <div class="col-md-6 mt-3">
                <form action="{{ route('stores') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث" id="term">
                        <a href="{{ route('stores') }}" class="">
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMeal">
                    <i class="fas fa-plus"></i>
                    إضافة عنصر جديد
                </button>
            </div>

        </div>
        <div class="row my-3 mx-0 unprint">
            <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#sellBill">
                فاتورة بيع
            </button>
        </div>
        <div class="row">
            @if (count($stores))
                @foreach ($stores as $store)
                    @include('stores.edit')
                    @include('stores.payItem')
                    {{-- @include('stores.delete') --}}
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-store"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $store->name }} - الكمية @if ($store->quantity) {{ $store->quantity }} @else 0 @endif / {{ $store->measure }}</span>
                                <div class="d-flex">
                                    <span class="info-box-number">سعر الوحدة {{ $store->price }} ج</span>
                                    {{-- <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#deletestore{{ $store->id }}">
                                    <i class="fas fa-trash text-danger fa-lg"></i>
                                </button> --}}
                                </div>
                                <div class="d-flex mt-3">

                                    <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                                        data-target="#storeUpdate{{ $store->id }}">
                                        <i class="fas fa-edit text-warning fa-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                                        data-target="#payItem{{ $store->id }}">
                                        <i class="fas fa-plus text-warning fa-lg"></i>
                                        إضافة
                                    </button>
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
