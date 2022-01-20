@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel - Edit - {{ $user->username }}</title>
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
    <div class="container-fluid mt-3">
        <h5 class="text-center">تعديل البيانات</h5>
        {!! Form::open(['route' => ['users.update', $user->username], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="telId">الرقم التعريفي</label>
                    <input type="text" disabled value="{{ $user->id }}" class="form-control" id="telId" placeholder="">
                </div>
                <div class="form-group col-md-5">
                    <label for="address">الاسم</label>
                    <input name="username" type="text" value="{{ $user->username }}" class="form-control" id="emailId"
                        placeholder="">
                </div>
                <div class="form-group col-md-5">
                    <label for="telId">رقم الهاتف</label>
                    <input name="tel" type="text" value="{{ $user->tel }}" class="form-control" id="telId"
                        placeholder="">
                </div>
                <input name="role" type="hidden" value="{{ $user->role }}" class="form-control" id="roleId"
                    placeholder="">
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="education">التعليم</label>
                    <input name="education" type="text" value="{{ $user->profile->education }}" class="form-control"
                        id="education" placeholder="">
                </div>
                <div class="form-group col-md-4">
                    <label for="address">العنوان</label>
                    <input name="address" type="text" value="{{ $user->profile->address }}" class="form-control"
                        id="address" placeholder="">
                </div>
                <div class="form-group col-md-4">
                    <label for="skill">المهارات</label>
                    <input name="skill" type="text" value="{{ $user->profile->skill }}" class="form-control" id="skill"
                        placeholder="">
                </div>
            </div>
            <div class="row align-items-end">
                <div class="col-md-9">
                    <textarea name="note" class="form-control" id="aboutMe" rows="5">
                        {{ $user->profile->note }}
                    </textarea>
                </div>
                <div class="col-md-3">

                </div>
            </div>

            <div class="row mt-3">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        <!-- /.card-body -->

        {!! Form::close() !!}
    </div>
@endsection
