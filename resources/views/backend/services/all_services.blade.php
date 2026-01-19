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
                            <table id="serviceTabel" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Service Name</th>
                                        <th>Icon Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($serviceData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->amenities_name }}</td>
                                            <td>{{ $item->icon_name }}</td>
                                            <td>
                                                {{-- @if (Auth::user()->can('amenities.edit')) --}}
                                                <a type="button" href="{{ route('edit.service', $item->id) }}"
                                                    class="btn btn-inverse-warning">Edit</a>
                                                {{-- @endif --}}
                                                {{-- @if (Auth::user()->can('amenities.delete')) --}}
                                                <a type="button" href="{{ route('delete.service', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete">Delete</a>
                                                {{-- @endif --}}

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
                $('#serviceTabel').DataTable({});
            });
        </script>
    @endpush
@endsection
