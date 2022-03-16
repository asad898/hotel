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
            <p class="mx-3"><b>تاريخ المغادرة: </b> {{ $bill->deleted_at->format('d/m/Y') }}</p>
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
                                    <th class="unprint">رقم العملية</th>
                                    <th>البيان</th>
                                    <th>رقم الغرفة</th>
                                    <th>المبلغ</th>
                                    <th>الضريبة</th>
                                    <th>دمغة / سياحة</th>
                                    <th>المجموع</th>
                                    <th class="unprint">مدخل البيانات</th>
                                    <th class="unprint">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($details))
                                    @foreach ($details as $detail)
                                        <tr class="odd @if($detail->type == 'pay') unprint @endif">
                                            <td>{{ $detail->created_at->format('d/m/Y') }}</td>
                                            <td class="unprint">{{ $detail->id }}</td>
                                            <td>{{ $detail->statment }}</td>
                                            <td>{{ $detail->room->number }}</td>
                                            <td>{{ $detail->price }}</td>
                                            <td>{{ $detail->tax }}</td>
                                            <td>{{ $detail->tourism }}</td>
                                            <td>
                                                @if ($detail->type == "pay")
                                                {{ $detail->tourism + $detail->tax + $detail->price }}-
                                                @else
                                                {{ $detail->tourism + $detail->tax + $detail->price }}
                                                @endif
                                            </td>
                                            @if ($detail->type != 'pay')
                                                <td hidden>{{ $s += $detail->tourism + $detail->tax + $detail->price }}
                                                </td>
                                            @endif
                                            <td class="unprint">{{ $detail->user->username }}</td>
                                            @if (auth()->user()->mm)
                                            @include('details.delete')
                                            <td class="unprint">
                                                <div class="d-flex">
                                                        @if (auth()->user()->mm)
                                                        <button type="button" class="btn btn-tool" data-toggle="modal"
                                                            data-target="#deleteBillDeta{{ $detail->id }}">
                                                            <i class="fas fa-trash text-danger fa-lg"></i>
                                                        </button>
                                                            <a href="{{ route('details.edit', $detail->id) }}">
                                                                <i class="fas fa-edit text-info fa-lg"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                                @if (count($dres))
                                    @foreach ($dres as $dre)
                                    @if($dre->done != 0)
                                        <tr class="odd">
                                            <td>{{ $dre->created_at->format('d/m/Y') }}</td>
                                            <td class="unprint">{{ $dre->id }}</td>
                                            <td> فاتورة مطعم بالرقم{{ $dre->id }}</td>
                                            <td>{{ $dre->room->number }}</td>
                                            <td>{{ $dre->total }}</td>
                                            <td>{{ $dre->tax }}</td>
                                            <td>{{ $dre->stamp }}</td>
                                            <td>{{ $dre->total + $dre->tax + $dre->stamp }}</td>
                                            <td hidden>{{ $s += $dre->total + $dre->tax + $dre->stamp }}</td>
                                            <td class="unprint">{{ $dre->user->username }}</td>
                                            <td class="unprint">
                                                <a href="/rebill/{{ $dre->id }}" class="btn btn-tool">
                                                    <i class="fa fa-folder text-info fa-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                                @if (count($dlan))
                                    @foreach ($dlan as $dre)
                                    @if($dre->done != 0)
                                        <tr class="odd">
                                            <td>{{ $dre->created_at->format('d/m/Y') }}</td>
                                            <td class="unprint">{{ $dre->id }}</td>
                                            <td> فاتورة مغسلة بالرقم{{ $dre->id }}</td>
                                            <td>{{ $dre->room->number }}</td>
                                            <td>{{ $dre->total }}</td>
                                            <td>{{ $dre->tax }}</td>
                                            <td>{{ $dre->stamp }}</td>
                                            <td>{{ $dre->total + $dre->tax + $dre->stamp }}</td>
                                            <td hidden>{{ $s += $dre->total + $dre->tax + $dre->stamp }}</td>
                                            <td class="unprint">{{ $dre->user->username }}</td>
                                            <td class="unprint">
                                                <a href="/labill/{{ $dre->id }}" class="btn btn-tool">
                                                    <i class="fa fa-folder text-info fa-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                                <tr class="table-danger">
                                    <td><b>المجموع</b></td>
                                    <td class="unprint"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>{{ $s }} </b></td>
                                    <td class="unprint"></td>
                                    <td class="unprint"></td>
                                </tr>
                            </tbody>
                        </table>
                        @if (auth()->user()->mm)
                            @include('bills.detas.create')
                            <tr class="table-danger text-center">
                                <button type="button" class="btn btn-primary w-100 rounded-0 unprint" data-toggle="modal"
                                    data-target="#roomCreate">
                                    <i class="fas fa-plus"></i>
                                    إضافة عنصر
                                </button>
                            </tr>
                        @endif
                    </div>
                    <small class="unprint"><b>مدخل الفاتوره : </b>{{ $bill->user->username }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
