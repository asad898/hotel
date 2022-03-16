@extends('layouts.app')
@section('head')
    <title>فواتير المطعم</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <h1 class="text-center mb-4">فواتير المغسلة غرف</h1>
        <div class="col-md-6 mt-3 unprint">
            <form action="{{ route('laundry.bills') }}" method="GET" role="search">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-info rounded-0" type="submit" title="Search projects">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <input type="text" class="form-control" name="term" placeholder="البحث برقم الفاتورة" id="term">
                    <a href="{{ route('laundry.bills') }}" class="">
                        <span class="input-group-btn">
                            <button class="btn btn-danger rounded-0" type="button" title="Refresh page">
                                <span class="fas fa-sync-alt"></span>
                            </button>
                        </span>
                    </a>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="card-body">
                <div class="card col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-hover text-right">
                            <thead>
                                <tr>
                                    <th scope="col">رقم الفاتورة</th>
                                    <th scope="col">رقم الغرفة</th>
                                    <th scope="col">المبلغ</th>
                                    <th scope="col">التاريخ</th>
                                    <th scope="col">الحالة</th>
                                    <th scope="col" class="unprint">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($bills))
                                    @foreach ($bills as $bill)
                                        @if ($bill->room_id != 300)
                                            <tr class="odd">
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    {{ $bill->id }}
                                                </td>
                                                <td>
                                                    @if ($bill->room_id == 300)
                                                        فاتورة خارجية
                                                    @else
                                                        {{ $bill->room->number }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $bill->total + $bill->tax + $bill->stamp }}
                                                </td>
                                                <td>{{ $bill->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($bill->done == 0)
                                                        غير محفوظة
                                                    @else
                                                        محفوظة
                                                    @endif
                                                </td>
                                                <td class="unprint">
                                                    <a href="/labill/{{ $bill->id }}" class="btn btn-tool">
                                                        <i class="fa fa-folder text-info fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-5 justify-content-center">
                        {{ $bills->links() }}
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
