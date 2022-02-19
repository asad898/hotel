@extends('layouts.app')
@section('head')
    <title>Hotel - Restaurants - Bills</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <h1 class="text-center mb-4">فواتير المطعم للنزلاء الحاليين</h1>
        <div class="row">
            <div class="card-body">
                <div class="card col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-hover text-right">
                            <thead>
                                <tr>
                                    <th scope="col">رقم الفاتورة</th>
                                    <th scope="col">النزيل</th>
                                    <th scope="col">رقم الغرفة</th>
                                    <th scope="col">المبلغ</th>
                                    <th scope="col">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($bills))
                                    @foreach ($bills as $bill)
                                        <tr class="odd">
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                <a href="{{ route('restaurants.show', $bill->id) }}">
                                                    {{ $bill->id }}
                                                </a>
                                            </td>
                                            <td>{{ $bill->guest->name }} @if ($bill->partner) + {{ $bill->partner->name }}
                                                @endif
                                            </td>
                                            <td>{{ $bill->room->number }}</td>
                                            <td>
                                                {{ $bill->price }}
                                            </td>
                                            <td>{{ $bill->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p>لا توجد فواتير حتى الآن</p>
                                @endif
                            </tbody>
                        </table>
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
