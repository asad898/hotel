@extends('layouts.app')
@section('head')
    <title>
        فاتورة {{ $bill->guest->name }} @if ($bill->partner)
                +{{ $bill->partner->name }} @endif بالرقم {{ $bill->id }} - {{ $bill->institution->name }}
    </title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <h4 class="text-center mb-2">
            فاتورة {{ $bill->guest->name }} @if ($bill->partner)
                +{{ $bill->partner->name }} @endif بالرقم {{ $bill->id }}
        </h4>
        <h5 class="text-center mb-2">{{ $bill->institution->name }}</h5>
        <div class="row">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row text-left" dir="ltr">
                        <div class="col-sm-12">
                            <table id="example1" dir="rtl" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending">التاريخ</th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">رقم العملية</th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">الوجية</th>
                                        <th class="sorting text-right" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                            aria-label="Browser: activate to sort column ascending">المبلغ</th>
                                        <th class="sorting text-right sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                             aria-label="Rendering engine: activate to sort column descending">المجموع
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @if (count($details))
                                        @foreach ($details as $detail)
                                            <tr class="odd">
                                                <td>{{ $detail->created_at }}</td>
                                                <td class="dtr-control sorting_1" tabindex="0">{{ $detail->id }}</td>
                                                <td>{{ $detail->clothe->name }}</td>
                                                <td>{{ $detail->clothe->price }} * {{ $detail->amount }}</td>
                                                <td>{{ $detail->clothe->price * $detail->amount }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>لا توجد فواتير مغسلة حتى الآن</p>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" rowspan="1" colspan="1">التاريخ</th>
                                        <th class="text-right" rowspan="1" colspan="1">رقم العملية</th>
                                        <th class="text-right" rowspan="1" colspan="1">الوجية</th>
                                        <th class="text-right" rowspan="1" colspan="1">المبلغ</th>
                                        <th class="text-right" rowspan="1" colspan="1">المجموع</th>
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
