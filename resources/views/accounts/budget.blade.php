@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Main - Accounts</title>
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
        <h3 class="text-center">معادلة الميزانية</h3>
        <div class="mb-2">
            <p>معادلة الميزانية : {{ $sum1 }} = {{ $sum2 }}</p>
        </div>
        <div class="d-flex col-12 justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h3 class="card-title">Bordered Table</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">المبلغ</th>
                                <th scope="col">الحساب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($mainAccounts))
                                @foreach ($mainAccounts as $subs)
                                    @foreach ($subs->sub as $sub)
                                        @if ($sub->main_accounts_id == 1 or $sub->main_accounts_id == 2)
                                            <tr>
                                                <th>{{ $sub->price }}</th>
                                                <td>{{ $sub->name }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card col-6">
                <div class="card-header">
                    <h3 class="card-title">Bordered Table</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">المبلغ</th>
                                <th scope="col">الحساب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($mainAccounts))
                                @foreach ($mainAccounts as $subs)
                                    @foreach ($subs->sub as $sub)
                                        @if ($sub->main_accounts_id == 3 or $sub->main_accounts_id == 4 or $sub->main_accounts_id == 5)
                                            <tr>
                                                <th>{{ $sub->price }}</th>
                                                <td>{{ $sub->name }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
