@extends('layouts.app')
@section('head')
    <title>فاتورة مطعم</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('restaurants.newbills.create')
    @include('restaurants.newbills.edit')
    @include('restaurants.newbills.save')
    @include('restaurants.newbills.saveCash')
    @include('restaurants.newbills.deleteB')
    <div class="container-fluid">
        <h3 class="text-center pb-4 mt-4">فاتورة مطعم بالرقم {{ $rebill->id }}
            @if (!$rebill->done)
                <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                    data-target="#deleteB{{ $rebill->id }}">
                    <i class="fas fa-trash text-danger fa-lg"></i>
                </button>
                <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                    data-target="#editRe">
                    <i class="fas fa-edit text-info fa-lg"></i>
                </button>
            @endif
            @if ($rebill->done and auth()->user()->mm)
                <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                    data-target="#deleteB{{ $rebill->id }}">
                    <i class="fas fa-trash text-danger fa-lg"></i>
                </button>
            @endif
            @if ($rebill->done and auth()->user()->mm)
                <button type="button" class="btn btn-tool unprint" data-toggle="modal"
                    data-target="#editRe{{ $rebill->id }}">
                    <i class="fas fa-edit text-info fa-lg"></i>
                </button>
            @endif
        </h3>
        @if (!$rebill->total == 0)
            @if (!$rebill->done and $rebill->room_id != 300)
                <button type="button" class="btn btn-primary unprint mb-4" data-toggle="modal"
                    data-target="#rebillsave{{ $rebill->id }}">
                    <i class="fas fa-plus"></i>
                    حفظ الفاتورة
                </button>
            @endif
            @if (!$rebill->done and $rebill->room_id == 300)
                <button type="button" class="btn btn-success unprint mb-4" data-toggle="modal"
                    data-target="#cashsave{{ $rebill->id }}">
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
                    <p>رقم الفاتورة : {{ $rebill->id }}</p>
                </div>
                <div class="mx-2">
                    <p>رقم الغرفة / النوع : @if ($rebill->room)
                        {{ $rebill->room->number }} @else فاتورة خارجية @endif
                    </p>
                </div>
                <div class="mx-2">
                    <p>التاريخ : {{ $rebill->created_at->format('d/m/Y') }}</p>
                </div>
                @if ($rebill->room)
                <div class="mx-2">
                    <p>فاتورة النزيل : {{ $rebill->bill_id }}</p>
                </div>
                @endif
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
                            @if (!$rebill->done)
                                <th class="unprint text-center">#</th>
                            @endif
                            @if ($rebill->done and auth()->user()->mm)
                                <th class="unprint text-center">#</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($detas))
                            @foreach ($detas as $detail)
                                @include('restaurants.newbills.delete')
                                <tr>
                                    <td>{{ $detail->meal->name }}</td>
                                    <td>{{ $detail->amount }}</td>
                                    <td>{{ $detail->meal->price }}</td>
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->tax }}</td>
                                    <td class="unprint">{{ $detail->user->username }}</td>
                                    @if (!$rebill->done)
                                        <td class="unprint">
                                            <button type="button" class="btn btn-tool" data-toggle="modal"
                                                data-target="#newbill{{ $detail->id }}">
                                                <i class="fas fa-trash text-danger fa-lg"></i>
                                            </button>
                                        </td>
                                    @endif
                                    @if ($rebill->done and auth()->user()->mm)
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
                @if (!$rebill->done)
                    <tr class="table-danger text-center">
                        <button type="button" class="btn btn-primary w-100 rounded-0 unprint" data-toggle="modal"
                            data-target="#rebill{{ $rebill->id }}">
                            <i class="fas fa-plus"></i>
                            إضافة عنصر
                        </button>
                    </tr>
                @endif
                @if ($rebill->done and auth()->user()->mm)
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

        <small class="unprint"><b>مدخل السند : {{ $rebill->user->username }}</b></small>
    </div>
@endsection
