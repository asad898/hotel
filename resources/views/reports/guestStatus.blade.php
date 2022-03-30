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
        <h3 class="text-center my-4">تقرير الغرف الساكنة</h3>
        <div class="text-right" dir="rtl">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <button type="button" onclick="window.print()" class="btn btn-info unprint mx-3 my-2">
                            <i class="fa fa-print" aria-hidden="true"></i> طباعة
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover my-3">
                        <thead>
                            <tr class="table-info">
                                <th class="text-center" style=" width: 10px">#</th>
                                <th class="text-center" style=" width: 10px">ر.النزيل</th>
                                <th class="text-center" style=" width: 10px">الغرفة</th>
                                <th class="text-center">النزيل</th>
                                <th class="text-center">المرافق</th>
                                <th class="text-center">العنوان</th>
                                <th class="text-center">الجهة</th>
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">الهوية</th>
                                <th class="text-center">رقم الهوية</th>
                                <th class="text-center">تاريخ الوصول</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($myA))
                                @foreach ($myA as $bill)
                                    <tr class='clickable-row' data-href='{{ route('bill.show', $bill['billId']) }}'>
                                        <td>{{ $bill['billId'] }}</td>
                                        <td>{{ $bill['guestId'] }}</td>
                                        <td>{{ $bill['roomNumber'] }}</td>
                                        <td>{{ $bill['guestName'] }}</td>
                                        @if($bill['partnerId'] != "-")
                                            <td>{{ $bill['partnerId'] }} / {{ $bill['partnerName'] }}</td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        <td>{{ $bill['guestAddress'] }}</td>
                                        <td>{{ $bill['institution'] }}</td>
                                        <td>{{ $bill['guestPhone'] }}</td>
                                        <td>{{ $bill['guestIdentity'] }}</td>
                                        <td>{{ $bill['guestIdentityId'] }}</td>
                                        <td>{{ $bill['billCreatedAt'] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <p class="mt-2">عدد السجلات {{ count($rooms) }}</p>
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
