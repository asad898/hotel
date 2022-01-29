@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>قائمة الدخل</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid m-0">
        <h3 class="text-center my-4">قائمة الدخل</h3>
        <div class="col-md-12 mb-2 unprint">
            <form action="{{ route('journal.income') }}" method="GET" role="search">
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
        <div class="d-flex justify-content-center my-3">
            @if ($from)
                من {{ $from }} &nbsp; الى
            @endif
            &nbsp;{{ $to }}
        </div>
        <div class="row justify-content-center">
            @if ($to)
                <div class="card col-md-10">
                    <div class="card-header">
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="text-center table-danger">
                                    <td></td>
                                    <td><b>الإيرادات</b></td>
                                    <td></td>
                                </tr>
                                @foreach ($myA as $item)
                                    @if ($item['price'])
                                        <tr>
                                            <td>{{ $item['price'] }}</td>
                                            <td></td>
                                            <td>{{ $item['name'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td>{{ $sum1 }}</td>
                                    <td></td>
                                    <td><b>اجمالي الإيرادات</b></td>
                                </tr>
                                <tr class="text-center table-danger">
                                    <td></td>
                                    <td><b>المصروفات<b></td>
                                    <td></td>
                                </tr>
                                @foreach ($myB as $item)
                                    @if ($item['price'])
                                        <tr class="">
                                            <td></td>
                                            <td>{{ $item['price'] }}</td>
                                            <td>{{ $item['name'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td>{{ $sum2 }}</td>
                                    <td><b>اجمالي المصروفات</b></td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($sum1 > $sum2)
                            <h3 class="mt-5">صافي ربح {{ $sum1 - $sum2 }}</h3>
                        @elseif($sum2 > $sum1)
                            <h3 class="mt-5">صافي خسارة {{ $sum1 - $sum2 }}</h3>
                        @else
                            <h3 class="mt-5">الجانبان متساويان</h3>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- {{ $entrys->links() }} --}}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
