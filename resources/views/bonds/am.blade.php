@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>سند مفتوح طلبات</title>
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
        <h2 class="text-center">الحسابات</h2>
        <h4 class="mt-3">طلبات السندات المفتوحة</h4>
        <div class="row mb-5">
            @if (count($bonds))
                @foreach ($bonds as $bond)
                    @if ($bond->admin_conf)
                        <div class="col-md-4 mt-5">
                            @if ($bond->admin_conf)
                                <div class="card card-success text-right" dir="rtl">
                                @else
                                    <div class="card card-info text-right" dir="rtl">
                            @endif
                            <div class="card-header">
                                @if ($bond->admin_conf)
                                    <h3 class="card-title mx-3">تمت الموافقة من الإدارة</h3>
                                @else
                                    <h3 class="card-title mx-3">لم تتم الموافقة</h3>
                                @endif
                                @if(!$bond->admin_conf)
                                <a href="{{ route('bond.edit', $bond->id) }}"><i class="fas fa-edit px-2"></i></a>
                                @endif
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#delbond{{ $bond->id }}">
                                    <i class="fas fa-trash text-danger fa-lg"></i>
                                </button>
                                @include('bonds.delete')
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="mt-2 mr-3">
                                {{ $bond->dept }} / رقم السند {{ $bond->id }}
                            </div>
                            <div class="card-body text-justify" style="overflow-y: scroll; height:200px;">
                                {{ $bond->body }}
                            </div>
                            <div class="d-flex justify-content-between mx-4 mb-3">
                                <small>{{ $bond->user->username }}</small>
                                <small>{{ $bond->created_at }}</small>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
        </div>
        @endif
        @endforeach
    </div>
    <div class="row mt-4 justify-content-center">
        {{ $bonds->links() }}
    </div>
    @endif
    </div>
@endsection
