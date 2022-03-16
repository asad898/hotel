@extends('layouts.app')
@section('head')
    <title>تعديل التعليق</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <h3 class="text-center">تعديل التعليقات</h3>
        {!! Form::open(['route' => ['comment.update', $comment->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
        @csrf
        @method('put')
        <div class="modal-body">
            <div class="form-group row mx-0">

                <div class="form-group col-md-6">
                    <label for="name" class="">التعليق</label>
                    <textarea name="comment" id="" cols="10" rows="8"
                        class="form-control">{{ $comment->comment }}</textarea>
                </div>
            </div>
        </div>
        <div class="">
            {{ Form::Submit('حفظ', ['class' => 'btn btn-info']) }}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
