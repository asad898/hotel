@extends('layouts.app')
@section('head')
    <title>الحسابات الفرعية</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
@include('accounts.subAccounts.create')
    <div class="container-fluid">
        <h3 class="text-center mb-5">{{ $mainAccount->acc_name }}</h3>
    <div class="mx-2 unprint">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSubAccount">
            <i class="fas fa-plus"></i>
            إضافة حساب
        </button>
    </div>
        <div class="row">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row text-left" dir="ltr">
                        <div class="col-sm-12">
                            <table id="example1" dir="rtl" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">رقم الحساب</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending">اسم الحساب</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">تاريخ الانشاء</th>
                                        <th class="sorting text-center unprint" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="Browser: activate to sort column ascending">#</th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @if (count($subAccounts))
                                        @foreach ($subAccounts as $sub)
                                            @if ($sub->main_accounts_id == $mainAccount->id)
                                            @include('accounts.subAccounts.edit')
                                                <tr class="odd">
                                                    <td class="dtr-control sorting_1" tabindex="0">
                                                        {{ $sub->id }}
                                                    </td>
                                                    <td>{{ $sub->name }}</td>
                                                    <td>
                                                        {{ $sub->created_at }}
                                                    </td>
                                                    <td class="unprint text-center">
                                                        <button type="button" class="btn btn-tool" data-toggle="modal"
                                                            data-target="#updateSubAccount{{ $sub->id }}">
                                                            <i class="fas fa-lg fa-edit text-success"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>لا توجد حسابات حتى الآن</p>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" rowspan="1" colspan="1">رقم الحساب</th>
                                        <th class="text-center" rowspan="1" colspan="1">اسم الحساب</th>
                                        <th class="text-center" rowspan="1" colspan="1">تاريخ الانشاء</th>
                                        <th class="text-center unprint" rowspan="1" colspan="1">#</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "excel", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

    </script>
@endpush