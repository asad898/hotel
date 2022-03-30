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
        <h3 class="text-center my-4">تقرير الغرف كاش</small></h3>
        <div class="col-md-12 mb-2 unprint">
            <form action="{{ route('rooms.cash') }}" method="GET" role="search">
                <div class="row">
                    <div class="d-flex m-2">
                        <label for="from" class="mx-2">من</label>
                        <input type="date" value="{{ old('from') }}" class="form-control" name="from" id="from">
                    </div>
                    <div class="d-flex m-2">
                        <label for="to" class="mx-2">الى</label>
                        <input type="date" value="{{ old('to') }}" class="form-control" name="to" id="to">
                        <button class="btn btn-info mx-2" type="submit" title="Search projects">
                            <span class="fas fa-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="text-right" dir="rtl">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        @if ($from)
                            من {{ $from }} &nbsp; الى
                        @endif
                        &nbsp;{{ $to }}
                        <button type="button" onclick="window.print()" class="btn btn-info unprint mx-3 my-2">
                            <i class="fa fa-print" aria-hidden="true"></i> طباعة
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover my-3">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center" style=" width: 10px">الغرفة</th>
                                <th class="text-center">اسم النزيل</th>
                                <th class="text-center">اسم المرافق</th>
                                <th class="text-center unprint">الجهة</th>
                                <th class="text-center">البيان</th>
                                <th class="text-center">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($myA))
                                @foreach ($myA as $bill)
                                    @if ($bill['leaDate'] != "-")
                                        <tr class='clickable-row' data-href='{{ route('bill.show.trashed', $bill['bill_id']) }}'>
                                    @else
                                        <tr class='clickable-row' data-href='{{ route('bill.show', $bill['bill_id']) }}'>
                                    @endif
                                        <td>{{ $bill['bill_id'] }}</td>
                                        <td>{{ $bill['roomNumber'] }}</td>
                                        <td>{{ $bill['guestName'] }}</td>
                                        <td>{{ $bill['partnerName'] }}</td>
                                        <td class="unprint">{{ $bill['ins'] }}</td>
                                        <td>{{ $bill['statment'] }}</td>
                                        <td>{{ $bill['price'] }}</td>
                                        <td hidden>{{ $tot += $bill['price'] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td hidden>{{ $rec = count($myA) }}</td>
                                <td>المجموع</td>
                                <td colspan="4" class="text-center">عدد السجلات{{ $rec }}</td>
                                <td class="unprint"></td>
                                <td>{{ $tot }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
@endsection
