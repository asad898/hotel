@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>قائمة المركز المالي</title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid justify-content-center row m-0">
        <h3 class="text-center mb-3">قائمة المركز المالي</h3>
        <div class="col-md-12 mb-2">
            <form action="{{ route('statement.income') }}" method="GET" role="search">
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
        @if ($to)
            <div class="row col-md-12 m-0 justify-content-center">
                <div class="card col-md-6">
                    <div class="card-header">
                        الاصول
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                @foreach ($myA as $item)
                                    @if ($item['price'])
                                        <tr class="">
                                            <td></td>
                                            <td>{{ $item['price'] }}</td>
                                            <td>{{ $item['name'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr class="table-primary">
                                    <td></td>
                                    <td>{{ $sum1 }}</td>
                                    <td><b>المجموع</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- {{ $entrys->links() }} --}}
                    </div>
                </div>

                <div class="card col-md-6">
                    <div class="card-header">
                        حقوق الملاك + الخصوم
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                @foreach ($myB as $item)
                                    @if ($item['price'])
                                        <tr class="">
                                            <td></td>
                                            <td>{{ $item['price'] }}</td>
                                            <td>{{ $item['name'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr class="table-primary">
                                    <td></td>
                                    <td>{{ $sum2 }}</td>
                                    <td><b>المجموع</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- {{ $entrys->links() }} --}}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
