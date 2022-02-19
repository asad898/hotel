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
        <h5 class="text-center my-4">طلبات المخزن</h5>
        <div class="row">
            @if (count($bills))
                @foreach ($bills as $bill)
                    @if ($bill->type == "إذن شراء")
                        @if (!$bill->admin_conf)
                            <a href="{{ route('store.bill.unsaved.show', $bill->id) }}" class="col-md-3 text-dark">
                                <div class="card card-outline card-warning">
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
                        @endif
                    @endif
                @endforeach
            @else
                <b class="m-4"> لا توجد فواتير  </b>
            @endif
        </div>
    </div>
@endsection
