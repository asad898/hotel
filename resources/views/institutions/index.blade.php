@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Institution</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    @include('institutions.create')

    <div class="container-fluid">
        <h1 class="text-center">المؤسسات الشركات</h1>
        <!-- Button trigger modal -->
        <div class="justify-content-between row">

            <div class="col-md-6 mt-3">
                <form action="{{ route('institutions') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="term" placeholder="البحث عن جهة عمل" id="term">
                        <a href="{{ route('institutions') }}" class="">
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createInstitution">
                    <i class="fas fa-plus"></i>
                    إضافة مؤسسة
                </button>
            </div>

        </div>
        @if (count($institutions))
            <div class="row pt-3">
                @foreach ($institutions as $institution)
                    @include('institutions.edit')
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $institution->name }}</span>
                                <div class="d-flex">
                                    <span class="info-box-number">{{ $institution->id }}</span>
                                    <button type="button" class="btn btn-tool" data-toggle="modal"
                                        data-target="#editInstitution{{ $institution->id }}">
                                        <i class="fas fa-edit text-warning fa-lg"></i>
                                    </button>
                                </div>
                                {{ $institution->user->username }}
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            </div>
            <div class="row mt-4 justify-content-center">
                {{ $institutions->links() }}
            </div>
        @else
            <p>لا توجد جهة عمل حتى الآن</p>
        @endif

    </div>
@endsection
