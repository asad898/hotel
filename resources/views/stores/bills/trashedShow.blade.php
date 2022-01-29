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
        <h5 class="text-center mt-5">فاتورة طلب سلع</h5>
        <div class="d-flex mt-3 align-items-end">
            <p class="mx-3"><b>التاريخ : </b> {{ $storeBill->created_at->format('d/m/Y') }}</p>
            <p class="mx-3"><b>رقم الفاتوره : </b> {{ $storeBill->id }}</p>
            <p class="mx-3"><b>البيان : </b> {{ $storeBill->statement }}</p>
            <button type="button" onclick="window.print()" class="btn btn-info unprint mx-3 my-2">
                <i class="fa fa-print" aria-hidden="true"></i> طباعة
            </button>
        </div>
        <div class="row justify-content-center mb-5 mx-2">
            <div class="card col-md-12">
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>السلعة</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة</th>
                                <th>السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($detas))
                                @foreach ($detas as $deta)
                                    <tr>
                                        <td>{{ $deta->store->name }}</td>
                                        <td>{{ $deta->quantity }}</td>
                                        <td>{{ $deta->store->price }}</td>
                                        <td>{{ $deta->store->price * $deta->quantity }}</td>
                                    </tr>
                                    <p style="display: none;">{{ $sum += $deta->store->price * $deta->quantity }}</p>
                                @endforeach
                            @endif
                        </tbody>
                        <tr class="table-danger">
                            <td><b>المجموع</b></td>
                            <td></td>
                            <td></td>
                            <td><b>{{ $sum }}</b></td>
                        </tr>
                    </table>
                    <small><b>مدخل البيانات : </b>{{ $storeBill->user->username }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection