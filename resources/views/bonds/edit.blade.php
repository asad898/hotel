@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>إنشاء سند مفتوح</title>
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
        <h1 class="text-center">تعديل السند</h1>
        {!! Form::open(['route' => ['bond.update', $bond->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="form-group row mx-0">
                <div class="form-group col-md-6">
                    <label for="name" class="">نص السند</label>
                    <textarea name="body" class="form-control" id="" cols="30" rows="5">{{ $bond->body }}</textarea>
                </div>
            </div>
            <div class="form-group row mx-0">
                <div class="form-group col-md-6">
                    <label for="name" class="">القسم</label>
                    <input type="text" name="dept" id="" value="{{ $bond->dept }}" class="form-control">
                </div>
            </div>
            @if(auth()->user()->mm)
            <div class="form-group row mx-0">
                <div class="form-group col-md-6">
                    <input type="checkbox" {{ $bond->admin_conf == 1 ? ' checked' : '' }} value="check" name="admin_conf" id="">
                    <label for="name" class="">تأكيد الإدارة</label>
                </div>
            </div>
            @endif
            <div class="row m-0">
                {{ Form::Submit('تعديل السند', ['class' => 'btn btn-info']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
