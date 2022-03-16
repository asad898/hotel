@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>تعديل فاتورة نزيل</title>
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
        <h5 class="text-center">تعديل تفاصيل فاتورة</h5>
        <div class="card card-info mt-5">
            <div class="card-header">
                <h5 class="">{{ $detail->statment }} / {{ $detail->created_at }}</h5>
            </div>
            {!! Form::open(['route' => ['details.update', $detail->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">الرقم</label>
                        <input type="text" class="form-control" disabled value="{{ $detail->id }}" name="id">
                    </div>
                    <div class="col-md-3">
                        <label for="">التاريخ</label>
                        <input type="text" class="form-control" value="{{ $detail->created_at }}" name="created_at">
                    </div>
                    <div class="col-md-4">
                        <label for="">البيان</label>
                        <input type="text" class="form-control" value="{{ $detail->statment }}" name="statment">
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="">الغرفة</label>
                        <input name="room_id" value="{{ $detail->room_id }}" class="form-control" list="rooms">
                        <datalist id="rooms">
                            @if (count($rooms))
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->number }}</option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label for="name" class="">رقم النزيل</label>
                        <input name="guest_id" value="{{ $detail->guest_id }}" class="form-control" list="guests">
                        <datalist id="guests">
                            @if (count($guests))
                                @foreach ($guests as $guest)
                                    <option value="{{ $guest->id }}">{{ $guest->name }} -
                                        {{ $guest->phone }}</option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>
                    <div class="col-md-2">
                        <label for="">المبلغ</label>
                        <input type="text" class="form-control" value="{{ $detail->price }}" name="price">
                    </div>
                    <div class="col-md-3">
                        <label for="">الضريبة</label>
                        <input type="text" @if ($detail->type == 'pay') disabled @endif class="form-control" value="{{ $detail->tax }}" name="tax">
                    </div>
                    <div class="col-md-2">
                        <label for="">السياحة</label>
                        <input type="text" class="form-control" @if ($detail->type == 'pay') disabled @endif value="{{ $detail->tourism }}" name="tourism">
                    </div>
                    <div class="col-md-2">
                        <label for="">رقم الفاتورة</label>
                        <input type="text" class="form-control" value="{{ $detail->bill_id }}" name="bill_id">
                    </div>
                </div>

                <div class="row mt-4">
                    <input class="btn btn-info" type="submit" value="حفظ التغيرات">
                </div>
            </div>
            <!-- /.card-body -->
            {!! Form::close() !!}
        </div>
    </div>
@endsection
