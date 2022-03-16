@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>دفتر الاستاذ</title>
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
        <h3 class="text-center my-4 unprint">دفتر الاستاذ</h3>
        <div class="col-md-12 mb-2 unprint">
            <form action="{{ route('journal.single') }}" method="GET" role="search">
                <div class="row">
                    <div class="d-flex m-2">
                        <label for="account" class="mx-2">الحساب</label>
                        <input name="account" class="form-control" list="account">
                        <datalist id="account">
                            @if (count($accounts))
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>
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
            @if (count($accounts))
                @foreach ($accounts as $account)
                    @if ($account->id == $account1)
                        <h4 class="text-center my-3">
                            حساب {{ $account->name }}
                        </h4>
                    @endif
                @endforeach
            @endif
            <div class="d-flex justify-content-center my-3">
                @if ($from)
                    من {{ $from }} &nbsp; الى
                @endif
                &nbsp;{{ $to }}
            </div>
            <div class="row m-0 justify-content-center">
                <div class="card col-md-6">
                    <div class="card-header">
                        <h4>حسابات مدينة</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 100px">المبالغ</th>
                                    <th>البيان</th>
                                    <th style="width: 100px">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entrys as $entry)
                                    @if ($entry->credit != $account1)
                                        <tr class="table-danger">
                                            <td>{{ $entry->c_amount }}</td>
                                            <td>الى ح/{{ $entry->cAccount->name }}</td>
                                            <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if ($creditSum < $debitSum)
                                    <tr class="table-success">
                                        <td>{{ $stage }}</td>
                                        <td>رصيد (مرحل)</td>
                                        <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endif
                                <tr class="table-primary">
                                    <td><b>المجموع</b></td>
                                    <td><b>{{ $bigSum }}</b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($creditSum > $debitSum)
                            <b class="mt-5">رصيد منقول {{ $stage }}</b>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- {{ $entrys->links() }} --}}
                    </div>
                </div>

                <div class="card col-md-6">
                    <div class="card-header">
                        <h4>حسابات دائنة</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 100px">المبالغ</th>
                                    <th>البيان</th>
                                    <th style="width: 100px">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entrys as $entry)
                                    @if ($entry->debit != $account1)
                                        <tr class="table-warning">
                                            <td>{{ $entry->d_amount }}</td>
                                            <td>من ح/{{ $entry->dAccount->name }}</td>
                                            <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if ($creditSum > $debitSum)
                                    <tr class="table-success">
                                        <td>{{ $stage }}</td>
                                        <td>رصيد (مرحل)</td>
                                        <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endif
                                <tr class="table-primary">
                                    <td><b>المجموع</b></td>
                                    <td><b>{{ $bigSum }}</b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($creditSum < $debitSum)
                            <b class="mt-4">رصيد منقول {{ $stage }}</b>
                        @endif
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
