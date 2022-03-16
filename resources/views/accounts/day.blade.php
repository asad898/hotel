@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>دفتر اليومية</title>
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
        <h3 class="text-center my-4">دفتر اليومية</h3>
        <div class="d-flex my-3">
            @if ($from)
                من {{ $from }} &nbsp; الى
            @endif
            &nbsp;{{ $to }}
        </div>
        <div class="col-md-12 mb-2 unprint">
            <form action="{{ route('journal.index') }}" method="GET" role="search">
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
        @if (count($entrys))
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 40px">مبالغ دائنة</th>
                                    <th style="width: 40px">مبالغ مدينة</th>
                                    <th>البيان</th>
                                    <th style="width: 150px">التاريخ</th>
                                    <th class="unprint text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entrys as $entry)
                                    @include('accounts.pay.delete')
                                    <tr class="table-warning">
                                        <td>{{ $entry->id }}</td>
                                        <td></td>
                                        <td>
                                        </td>
                                        <td>{{ $entry->statement }}</td>
                                        <td></td>
                                        <td class="unprint text-center">
                                            <button type="button" class="btn btn-tool" data-toggle="modal"
                                                data-target="#deleteEntry{{ $entry->id }}">
                                                <i class="fas fa-trash text-danger fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>{{ $entry->c_amount }}</td>
                                        <td></td>
                                        <td>من ح/ {{ $entry->dAccount->name }}</td>
                                        <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                                        <td class="unprint"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            {{ $entry->d_amount }}
                                        </td>
                                        <td>الى ح/ {{ $entry->cAccount->name }}</td>
                                        <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                                        <td class="unprint"></td>
                                    </tr>
                                @endforeach
                                <tr class="table-primary">
                                    <td><b>مجموع</b></td>
                                    <td><b>{{ $creditSum }}</b></td>
                                    <td><b>{{ $debitSum }}</b></td>
                                    <td></td>
                                    <td></td>
                                    <td class="unprint"></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
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
