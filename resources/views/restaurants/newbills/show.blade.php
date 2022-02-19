@extends('layouts.app')
@section('head')
    <title>Hotel - Restaurants - Bills</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('restaurants.newbills.create')
    <div class="container-fluid">
        <h3 class="text-center mb-4">فاتورة مطعم</h3>
        <button type="button" class="btn btn-success mb-4 unprint">
            حفظ الفاتورة
        </button>
        <button type="button" onclick="window.print()" class="btn btn-info unprint mb-4">
            <i class="fa fa-print" aria-hidden="true"></i> طباعة
        </button>
        <div class="card col-sm-12 pt-4">
            <div class="d-flex">
                <div class="mx-2">
                    <p>رقم الفاتورة : {{ $rebill->id }}</p>
                </div>
                <div class="mx-2">
                    <p>رقم الغرفة : {{ $rebill->room->number }}</p>
                </div>
                <div class="mx-2">
                    <p>التاريخ : {{ $rebill->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>السلعة</th>
                            <th>الكمية</th>
                            <th>سعر الوحدة</th>
                            <th>السعر</th>
                            <th>ضريبة</th>
                            <th>مدخل البيانات</th>
                            @if (auth()->user()->mm)
                                <th class="unprint text-center">#</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($detas))
                            @foreach ($detas as $detail)
                                <tr>
                                    <td>{{ $detail->meal->name }}</td>
                                    <td>{{ $detail->amount }}</td>
                                    <td>{{ $detail->meal->price }}</td>
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->tax }}</td>
                                    <td>{{ $detail->user->username }}</td>
                                    <td class="unprint">
                                        <button type="button" class="btn btn-tool" data-toggle="modal"
                                            data-target="#deleteBillDeta{{ $detail->id }}">
                                            <i class="fas fa-trash text-danger fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                <p hidden>{{ $sp += $detail->price }}</p>
                                <p hidden>{{ $stax += $detail->tax }}</p>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (auth()->user()->shm)
                    <tr class="table-danger text-center">
                        <button type="button" class="btn btn-primary w-100 rounded-0 unprint" data-toggle="modal"
                            data-target="#rebill{{ $rebill->id }}">
                            <i class="fas fa-plus"></i>
                            إضافة عنصر
                        </button>
                    </tr>
                @endif
                <div class="col-5 mt-5 mb-5">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <td>الضريبة</td>
                                <td>{{ $stax }}</td>
                                <td>الدمغة</td>
                                <td>{{ $rebill->stamp }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>الفاتورة</td>
                                <td>{{ $sp }}</td>
                                <th>المجموع</th>
                                <th>{{ $sp + $stax + $rebill->stamp }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <small><b>مدخل السند : {{ $rebill->user->username }}</b></small>
    </div>
@endsection
