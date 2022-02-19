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
    <div class="container-fluid">
        <h5 class="text-center my-4">السندات غير المرحلة</h5>
        <div class="justify-content-between row unprint mb-3">
            <div class="col-md-6 mt-3">
                <form action="{{ route('store.bill.unsaved') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث" id="term">
                        <a href="{{ route('store.bill.unsaved') }}" class="">
                            <span class="input-group-btn">
                                <button class="btn btn-danger rounded-0" type="button" title="Refresh page">
                                    <span class="fas fa-sync-alt"></span>
                                </button>
                            </span>
                        </a>
                    </div>
                </form>
            </div>

        </div>
        <div class="row">
            @if (count($bills))
                @foreach ($bills as $bill)
                    <a href="{{ route('store.bill.unsaved.show', $bill->id) }}" class="col-md-3 text-dark">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <p>رقم السند : <b>{{ $bill->id }}</b></p>
                                <p class="">النوع :{{ $bill->type }}</p>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p class=""><b>البيان / المورد :</b></p>
                                <p>{{ $bill->statement }}</p>
                                <p>التاريخ : <b>{{ $bill->created_at->format('d/m/Y') }}</b> </p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </a>
                @endforeach
                <div class="mt-5">
                    {{ $bills->links() }}
                </div>
            @else
                <b class="m-4"> لا توجد فواتير غير مرحلة </b>
            @endif
        </div>
    </div>
@endsection
