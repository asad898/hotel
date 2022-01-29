@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title class="unprint">ميزان المراجعة</title>
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
        <h3 class="text-center my-4">ميزان المراجعة</h3>
        <div class="d-flex my-3">
            @if ($from)
                من {{ $from }} &nbsp; الى
            @endif
            &nbsp;{{ $to }}
        </div>
        <div class="col-md-12 mb-2 unprint">
            <form action="{{ route('journal.balance') }}" method="GET" role="search">
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
            @if (count($myA))
                <div class="d-flex justify-content-center text-center">
                    <div class="card col-md-10">
                        <div class="card-header">
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 150px">ارصدة مدينة</th>
                                        <th style="width: 150px">ارصدة دائنة</th>
                                        <th>اسم الحساب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myA as $my)
                                        @if ($my['price'] != 0)
                                            <tr>
                                                <td>
                                                    @if ($my['state'] == 'credit')
                                                        {{ $my['price'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($my['state'] == 'debit')
                                                        {{ $my['price'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $my['name'] }}
                                                </td>
                                            </tr>

                                        @endif

                                    @endforeach
                                    <tr class="table-primary">
                                        <td><b>{{ $sum1 }}</b></td>
                                        <td><b>{{ $sum2 }}</b></td>
                                        <td><b>الاجمالي</b></td>
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
        @endif
    </div>
@endsection
