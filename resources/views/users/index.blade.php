@extends('layouts.app')
@section('head')
    <title>Hotel - Users</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <h1 class="text-center">عرض مستخدمين النظام</h1>
        <div class="row">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row text-left" dir="ltr">
                        <div class="col-sm-12">
                            <table id="example1" dir="rtl" class="table table-bordered table-striped dataTable dtr-inline"
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending">تاريخ
                                            التسجيل</th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending">رقم</th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">المستخدم
                                        </th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">الصلاحية
                                        </th>
                                        <th class="sorting text-right sorting_asc" tabindex="0" aria-controls="example1"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">الهاتف
                                        </th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending">المفاتيح
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @if (count($users))
                                        @foreach ($users as $user)
                                            <tr class="odd">
                                                <td>{{ $user->created_at }}</td>
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    {{ $user->id }}
                                                </td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    {{ $user->tel }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('users.show', $user->username) }}" class="btn btn-tool">
                                                        <i class="fa fa-address-card fa-lg text-primary" aria-hidden="true"></i>
                                                    </a>
                                                    @if (auth()->user()->role == "Manager")
                                                        @include('users.delete')
                                                        <button type="button" class="btn btn-tool" data-toggle="modal"
                                                            data-target="#deleteUser{{ $user->id }}">
                                                            <i class="fas fa-trash text-danger fa-lg"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>لا يوجد مستخدمين حالياً</p>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" rowspan="1" colspan="1">تاريخ التسجيل</th>
                                        <th class="text-right" rowspan="1" colspan="1">رقم</th>
                                        <th class="text-right" rowspan="1" colspan="1">المستخدم</th>
                                        <th class="text-right" rowspan="1" colspan="1">الصلاحية</th>
                                        <th class="text-right" rowspan="1" colspan="1">الهاتف</th>
                                        <th class="text-right" rowspan="1" colspan="1">المفاتيح</th>
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
