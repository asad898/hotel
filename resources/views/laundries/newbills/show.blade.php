@extends('layouts.app')
@section('head')
    <title>فاتورة مغسلة</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('laundries.newbills.create')
    @include('laundries.newbills.save')
    @include('laundries.newbills.saveCash')
    @include('laundries.newbills.deleteB')
    <div class="container-fluid">
        <h3 class="text-center mb-4">فاتورة مغسلة بالرقم {{ $labill->id }}
            @if (!$labill->done)
                <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                    data-target="#deleteB{{ $labill->id }}">
                    <i class="fas fa-trash text-danger fa-lg"></i>
                </button>
            @endif
        </h3>
        @if (!$labill->total == 0)
            @if (!$labill->done and $labill->room_id != 300)
                <button type="button" class="btn btn-primary unprint mb-4" data-toggle="modal"
                    data-target="#labillsave{{ $labill->id }}">
                    <i class="fas fa-plus"></i>
                    حفظ الفاتورة
                </button>
            @endif
            @if (!$labill->done and $labill->room_id == 300)
                <button type="button" class="btn btn-success unprint mb-4" data-toggle="modal"
                    data-target="#cashsave{{ $labill->id }}">
                    <i class="fas fa-plus"></i>
                    حفظ الفاتورة نقداً
                </button>
            @endif
        @endif
        <button type="button" onclick="window.print()" class="btn btn-info unprint mb-4">
            <i class="fa fa-print" aria-hidden="true"></i> طباعة
        </button>
        <div class="card col-sm-12 pt-4">
            <div class="d-flex">
                <div class="mx-2">
                    <p>رقم الفاتورة : {{ $labill->id }}</p>
                </div>
                <div class="mx-2">
                    <p>رقم الغرفة / النوع : @if ($labill->room)
                        {{ $labill->room->number }} @else فاتورة خارجية @endif
                    </p>
                </div>
                <div class="mx-2">
                    <p>التاريخ : {{ $labill->created_at->format('d/m/Y') }}</p>
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
                            <th class="unprint">مدخل البيانات</th>
                            @if (!$labill->done)
                                <th class="unprint text-center">#</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($detas))
                            @foreach ($detas as $detail)
                                @include('laundries.newbills.delete')
                                <tr>
                                    <td>{{ $detail->clothe->name }}</td>
                                    <td>{{ $detail->amount }}</td>
                                    <td>{{ $detail->clothe->price }}</td>
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->tax }}</td>
                                    <td class="unprint">{{ $detail->user->username }}</td>
                                    @if (!$labill->done)
                                        <td class="unprint">
                                            <button type="button" class="btn btn-tool" data-toggle="modal"
                                                data-target="#newbill{{ $detail->id }}">
                                                <i class="fas fa-trash text-danger fa-lg"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                                <p hidden>{{ $sp += $detail->price }}</p>
                                <p hidden>{{ $stax += $detail->tax }}</p>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (!$labill->done)
                    <tr class="table-danger text-center">
                        <button type="button" class="btn btn-primary w-100 rounded-0 unprint" data-toggle="modal"
                            data-target="#labill{{ $labill->id }}">
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
                                <td>{{ $labill->stamp }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>الفاتورة</td>
                                <td>{{ $sp }}</td>
                                <th>المجموع</th>
                                <th>{{ $sp + $stax + $labill->stamp }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <small><b>مدخل السند : {{ $labill->user->username }}</b></small>
    </div>
@endsection
