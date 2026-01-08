@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">



        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Contact Informstion</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>email</th>
                                        <th>subject</th>
                                        <th>message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contact as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->subject }}</td>
                                            <td> {{ Str::limit($item->message, 50) }}
                                                @if (strlen($item->message) > 50)
                                                    <a href="javascript:void(0)" class="read-more text-primary"
                                                        data-id="{{ $item->id }}">
                                                        Read more
                                                    </a>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <a type="button" href="{{ route('edit.permission', $item->id) }}"
                                                    class="btn btn-inverse-warning">Edit</a>
                                                <a type="button" href="{{ route('delete.permission', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete">Delete</a>
                                            </td> --}}
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



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Monitor all "read-more" elements
            document.querySelectorAll('.read-more').forEach(function(link) {

                link.addEventListener('click', function() {

                    // Read ID from data-id
                    let contactId = this.dataset.id;

                    // AJAX call
                    fetch(`/enquiries/${contactId}/message`)
                        .then(response => response.json())
                        .then(data => {

                            // Fill modal
                            document.getElementById('modalTitle').innerText =
                                data.name + ' (' + data.email + ')';

                            document.getElementById('modalMessage').innerText =
                                data.message;

                            // Open modal
                            let modal = new bootstrap.Modal(
                                document.getElementById('messageModal')
                            );
                            modal.show();
                        });

                });

            });

        });
    </script>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
