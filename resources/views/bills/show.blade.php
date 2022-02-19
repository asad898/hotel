@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>فاتورة نزيل</title>
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
        <h5 class="text-center mt-3">
            فندق الفيصل
        </h5>
        <div class="d-flex mt-5 align-items-end">
            <p class="mx-3"><b>اسم النزيل : </b> {{ $bill->guest->name }}</p>
            @if ($bill->partner)
                <p class="mx-3"><b>المرافق : </b> {{ $bill->partner->name }}</p>
            @endif
            <p class="mx-3"><b>الحالة : </b>
                @if (!$bill->deleted_at) ساكن @else مغادر @endif
            </p>
        </div>
        <div class="d-flex align-items-end">
            <p class="mx-3"><b>تاريخ الوصول: </b> {{ $bill->created_at->format('d/m/Y') }}</p>
            <p class="mx-3"><b>رقم الفاتوره : </b> {{ $bill->id }}</p>
            <p class="mx-3"><b>الجهة : </b>{{ $bill->institution->name }} </p>
        </div>
        <button type="button" onclick="window.print()" class="btn btn-info unprint mx-3 my-2">
            <i class="fa fa-print" aria-hidden="true"></i> طباعة
        </button>
        <div class="row justify-content-center mb-5 mx-2">
            <div class="card col-md-12">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">

                            <thead>
                                <tr role="row">
                                    <th>التاريخ</th>
                                    <th>رقم العملية</th>
                                    <th>البيان</th>
                                    <th>رقم الغرفة</th>
                                    <th>المبلغ</th>
                                    <th>الضريبة</th>
                                    <th>دمغة / سياحة</th>
                                    <th>المجموع</th>
                                    <th>مدخل البيانات</th>
                                    @if(auth()->user()->role == 'Admin' or auth()->user()->role == 'AManager')
                                        <th class="text-center unprint">#</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($details))
                                    @foreach ($details as $detail)
                                        @include('details.delete')
                                        <tr class="odd">
                                            <td>{{ $detail->created_at->format('d/m/Y') }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">{{ $detail->id }}</td>
                                            <td>{{ $detail->statment }}</td>
                                            <td>{{ $detail->room->number }}</td>
                                            <td>{{ $detail->price }}</td>
                                            <td>{{ $detail->tax }}</td>
                                            <td>{{ $detail->tourism }}</td>
                                            <td>{{ $detail->tourism + $detail->tax + $detail->price}}</td>
                                            <td>{{ $detail->user->username }}</td>
                                            @if(auth()->user()->role == 'Admin' or auth()->user()->role == 'AManager')
                                            <td class="unprint">
                                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                                    data-target="#deleteBillDeta{{ $detail->id }}">
                                                    <i class="fas fa-trash text-danger fa-lg"></i>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <p>لا توجد فواتير حتى الآن</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex mt-5 align-items-end">
                        <p class="mx-3"><b>المطالبة : </b> {{ $bill->price }} ج</p>
                    </div>
                    <small><b>مدخل الفاتوره : </b>{{ $bill->user->username }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
