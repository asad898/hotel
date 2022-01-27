@extends('layouts.app')
@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>إنشاء قيد</title>
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
        <h3 class="text-center">إنشاء قيد</h3>
        <form class="text-right" method="POST" action="{{ route('pay.store') }}">
            @csrf
            <div class="modal-body col-md-6">
                <div class="form-group row mx-0">
                    <div class="form-group col-md-6">
                        <label for="name" class="font-weight-light">من حساب</label>
                        <input name="debit" class="form-control" list="debit">
                        <datalist id="debit">
                            @if (count($accounts))
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="nationality" class="font-weight-light">الى حساب</label>
                        <input name="credit" class="form-control" list="credit">
                        <datalist id="credit">
                            @if (count($accounts))
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>
                </div>
                <div class="form-group row mx-0">
                    <div class="form-group col-md-6">
                        <label for="name" class="font-weight-light">البيان</label>
                        <input name="statement" type="text" class="form-control" id="statement" placeholder=""
                            value="{{ old('statement') }}" autofocus required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="price" class="font-weight-light">المبلغ</label>
                        <input name="price" type="text" class="form-control" id="price" placeholder=""
                            value="{{ old('price') }}" autofocus required>
                    </div>
                </div>
            </div>
            <div class="row mx-3">
                <input type="submit" class="btn btn-primary py-2" value="حفظ">
            </div>
        </form>
    </div>
@endsection
