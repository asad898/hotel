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
    @include('stores.billdetas.create')

    <div class="container-fluid">
            <h5 class="text-center mt-5">{{ $storeBill->type }}</h5>
        <div class="d-flex mt-3 align-items-end">
            <p class="mx-3"><b>التاريخ : </b> {{ $storeBill->created_at->format('d/m/Y') }}</p>
            <p class="mx-3"><b>رقم السند : </b> {{ $storeBill->id }}</p>
            <p class="mx-3"><b>البيان / المورد : </b> {{ $storeBill->statement }}</p>
            <p class="mx-3"><b>الجهة</b> :{{ $storeBill->dept }}</p>
        </div>
        <div class="d-flex">
            <button type="button" onclick="window.print()" class="btn btn-info unprint mx-3 my-2">
                <i class="fa fa-print" aria-hidden="true"></i> طباعة
            </button>
            @if ($storeBill->type != 'إذن شراء')
                <button type="button" class="btn btn-info unprint mx-3 my-2" data-toggle="modal" data-target="#move">
                    <i class="fa fa-bookmark" aria-hidden="true"></i> تأكيد السند
                </button>
            @endif
            @if (auth()->user()->mm or auth()->user()->am)
                @if ($storeBill->type == 'إذن شراء')
                    @if (auth()->user()->am)
                        @if ($storeBill->admin_conf)
                            @if (!$storeBill->deleted_at)
                                <!--<button type="button" class="btn btn-info unprint mx-3 my-2" data-toggle="modal"-->
                                <!--    data-target="#sell1{{ $storeBill->id }}">-->
                                <!--    <i class="fa fa-bookmark" aria-hidden="true"></i> ترحيل السند نقدا-->
                                <!--</button>-->
                                <!--<button type="button" class="btn btn-info unprint mx-3 my-2" data-toggle="modal"-->
                                <!--    data-target="#sell2{{ $storeBill->id }}">-->
                                <!--    <i class="fa fa-bookmark" aria-hidden="true"></i> ترحيل السند على الحساب-->
                                <!--</button>-->
                                <button type="button" class="btn btn-info unprint mx-3 my-2" data-toggle="modal" data-target="#move">
                                    <i class="fa fa-bookmark" aria-hidden="true"></i> تأكيد السند
                                </button>
                            @endif
                        @endif
                    @endif
                @endif
            @endif
            @if (!$storeBill->admin_conf)
                @if (!$storeBill->deleted_at)
                    @if (auth()->user()->mm && auth()->user()->am && auth()->user()->rem && auth()->user()->shm)
                        @if ($storeBill->type == 'إذن شراء')
                            <button type="button" class="btn btn-info unprint mx-3 my-2" data-toggle="modal"
                                data-target="#adminconf">
                                <i class="fa fa-bookmark" aria-hidden="true"></i> الموافقة على السند
                            </button>
                        @endif
                    @endif
                @endif
            @endif
        </div>
        <div class="row justify-content-center mb-5 mx-2">
            <div class="card col-md-12">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>السلعة</th>
                                    <th>الكمية</th>
                                    <th>سعر الوحدة</th>
                                    <th>السعر</th>
                                    <th>مدخل البيانات</th>
                                    @if (auth()->user()->mm)
                                        <th class="unprint text-center">#</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($detas))
                                    @foreach ($detas as $deta)
                                        @include('stores.billdetas.deleteDeta')
                                        <tr>
                                            <td>{{ $deta->store->name }}</td>
                                            <td>{{ $deta->quantity }}</td>
                                            <td>{{ $deta->one_p }}</td>
                                            <td>{{ $deta->price }}</td>
                                            <td>{{ $deta->user->username }}</td>
                                            @if (auth()->user()->mm or auth()->user()->shm)
                                                <td class="unprint">
                                                    <button type="button" class="btn btn-tool" data-toggle="modal"
                                                        data-target="#storeDeta{{ $deta->id }}">
                                                        <i class="fas fa-trash text-danger fa-lg"></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                        <p style="display: none;">{{ $sum += $deta->price }}</p>
                                    @endforeach
                                @endif
                            </tbody>
                            <tr class="table-danger">
                                <td><b>المجموع</b></td>
                                <td></td>
                                <td></td>
                                <td><b>{{ $sum }}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    @include('stores.bills.move')
                    @include('stores.bills.adminconf')
                    @include('stores.bills.move1')
                    @include('stores.bills.move2')
                    <small><b>مدخل السند : </b>{{ $storeBill->user->username }}</small>
                    @if (auth()->user()->shm)
                        <tr class="table-danger text-center">
                            <button type="button" class="btn btn-primary w-100 rounded-0 unprint" data-toggle="modal"
                                data-target="#addDeta">
                                <i class="fas fa-plus"></i>
                                إضافة عنصر
                            </button>
                        </tr>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
