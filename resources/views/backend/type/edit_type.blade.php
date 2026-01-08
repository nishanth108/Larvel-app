@extends('admin.admin_dashboard')
@section('admin')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="page-content">

        <div class="row profile-body">
            <!-- left wrapper start -->

            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Edit Property Type</h6>

                            <form action="{{ route('update.type') }}" method="POST" class="forms-sample" id="editData">
                                @csrf

                                {{-- Here we have to all of our field --}}
                                <input type="hidden" name="id" value="{{ $types->id }}">

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Type Name</label>
                                    <input type="text" name="type_name"
                                        class="form-control @error('type_name') is-invalid @enderror"
                                        value="{{ $types->type_name }}">
                                    @error('type_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Type Icon</label>
                                    <input type="text" name="type_icon"
                                        class="form-control @error('type_icon') is-invalid @enderror"
                                        value="{{ $types->type_icon }}">
                                    @error('type_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- middle wrapper end -->
            <!-- right wrapper start -->

            <!-- right wrapper end -->
        </div>

    </div>
    @push('edit.amenities.script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#editData').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: form.serialize(),


                    beforeSend: function() {},
                    success: function(response) {
                        toastr.success(response.message);
                        // update inputs with latest values
                        $('input[name="type_name"]').val(response.data.type_name);
                        $('input[name="type_icon"]').val(response.data.type_icon);
                        // form.trigger('reset');
                    }

                })
            });
        </script>
    @endpush
@endsection
