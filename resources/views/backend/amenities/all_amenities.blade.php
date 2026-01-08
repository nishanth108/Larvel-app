@extends('admin.admin_dashboard')
@section('admin')
    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css">
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css"> --}}
    @endpush
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a type="button" href="{{ route('add.amenitie') }}" class="btn btn-primary">Add Amenities</a>
                &nbsp;&nbsp;&nbsp;
                {{-- <a type="button" href="{{ route('get.amenities.export') }}" class="btn btn-primary">Export</a> --}}
                {{-- <button type="button" id="excelExportBtn" class="btn btn-inverse-info">Excel Export</button>
                &nbsp;&nbsp;&nbsp;
                <button type="button" id="pdfExportBtn" class="btn btn-danger">PDF Export</button> --}}
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Amenities Type All</h6>
                        <div class="table-responsive">
                            <table id="amenitiesTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Amenitie Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($amenities as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->amenities_name }}</td>
                                            <td>
                                                @if (Auth::user()->can('amenities.edit'))
                                                    <a type="button" href="{{ route('edit.amenitie', $item->id) }}"
                                                        class="btn btn-inverse-warning">Edit</a>
                                                @endif
                                                @if (Auth::user()->can('amenities.delete'))
                                                    <a type="button" href="{{ route('delete.amenitie', $item->id) }}"
                                                        class="btn btn-inverse-danger" id="delete">Delete</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('script')
        <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

        <!-- DataTables Buttons core -->
        <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>

        <!-- Export dependencies -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <!-- Buttons for Excel / PDF / Print -->
        <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#amenitiesTable').DataTable({
                    columnDefs: [{
                            targets: [2],
                            searchable: false,
                            // visible: false,

                        } // Sl No & Action
                    ],
                    layout: {
                        topStart: {
                            buttons: [{
                                    extend: 'excel',
                                    text: '<span class="custom-btn excel-btn btn-primary"><i class="fa fa-file-excel"></i> Export Excel</span>',
                                    exportOptions: {
                                        columns: [0, 1] // ONLY export Sl & Name
                                    },
                                    className: 'btn btn-success btn-sm btn-reset'
                                },
                                {
                                    extend: 'pdf',
                                    text: '<span class="custom-btn pdf-btn"> Export PDF</span>',
                                    exportOptions: {
                                        columns: [0, 1]
                                    },
                                    className: 'btn btn-danger btn-sm btn-reset ms-2'
                                }
                            ]
                        }

                    }

                });
            });
        </script>
    @endpush
@endsection
