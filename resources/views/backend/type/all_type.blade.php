@extends('admin.admin_dashboard')
@section('admin')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css">
    @endpush
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a type="button" href="{{ route('add.type') }}" class="btn btn-inverse-info">Add Property Type</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Property Type All</h6>
                        <div class="table-responsive">
                            <table id="typeTabel" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Type Name</th>
                                        <th>Type Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($types as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->type_name }}</td>
                                            <td>{{ $item->type_icon }}</td>
                                            <td>
                                                @if (Auth::user()->can('edit.type'))
                                                    <a type="button" href="{{ route('edit.type', $item->id) }}"
                                                        class="btn btn-inverse-warning">Edit</a>
                                                @endif
                                                @if (Auth::user()->can('delete.type'))
                                                    <a type="button" href="{{ route('delete.type', $item->id) }}"
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


    @push('datatables')
        <!-- DataTables core -->
        <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
        <!-- DataTables Buttons -->
        <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#typeTabel').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('type.getType') }}",
                        type: "POST"
                    },
                    order: [
                        [1, 'DESC']
                    ],
                    pageLength: 10,
                    searching: true,
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'type_name'
                        },
                        {
                            data: 'type_icon'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                return `
                                    <a type="button" href="/edit/type/${row.id}"
                                                        class="btn btn-inverse-warning">Edit</a>
                                    <a type="button" href="/delete/type/${row.id}"
                                                        class="btn btn-inverse-danger" id="delete">Delete</a>
                    `;
                            }
                        }
                    ]
                });

            });
        </script>
    @endpush
@endsection
