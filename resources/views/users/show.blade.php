@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - {{ $user->username }}</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}"> --}}
    <!-- Theme style -->
    <!-- Daterange picker -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}"> --}}
@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/user.png') }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->username }}</h3>

                        <p class="text-muted text-center">Software Engineer</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                الصلاحية داخل النظام :<b>{{ $user->role }}</b>
                            </li>
                            <li class="list-group-item">
                                الهاتف : <b>{{ $user->tel }}</b>
                            </li>
                            <li class="list-group-item">
                                تاريخ إنشاء الحساب : <b>{{ $user->created_at }}  |  {{ $user->created_at->diffForHumans() }}</b>
                            </li>
                        </ul>
                        @if(auth()->user()->id == $user->id)
                            <div class="d-flex">
                                <div class="col-md-6">
                                    @include('users.changPassword')
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#updatePass{{ $user->id }}">
                                        <i class="fa fa-key"></i>
                                        تغير كلمة المرور
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('users.edit', $user->username) }}" class="btn btn-primary btn-block"><b>تعديل البيانات</b></a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header text-right">
                        <h5 class="">عن الموظق</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> التعليم</strong>

                        <p class="text-muted">
                            {{ $user->profile->education }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i>العنوان</strong>

                        <p class="text-muted">{{ $user->profile->address }}</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> المهارات</strong>

                        <p class="text-muted">
                            {{ $user->profile->skill }}
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> ملاحظات</strong>

                        <p class="text-muted mb-4">{{ $user->profile->note }}.</p>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
