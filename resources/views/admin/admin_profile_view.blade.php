@extends('admin.admin_dashboard')
@section('admin')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">

        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">

                            @php
                                $id = Auth::user()->id;
                                $profileData = App\Models\User::find($id);
                            @endphp

                            <div>
                                <img class="wd-100 rounded-circle preview-Image"
                                    src="{{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                    alt="profile">
                                <span class="h4 ms-3">{{ $profileData->name }}</span>
                            </div>

                        </div>

                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Name :</label>
                            <p class="text-muted usernameField">{{ $profileData->username }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase ">Email:</label>
                            <p class="text-muted emailField">{{ $profileData->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                            <p class="text-muted phoneField">{{ $profileData->phone }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                            <p class="text-muted addressField">{{ $profileData->address }}</p>
                        </div>
                        <div class="mt-3 d-flex social-links">
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="github"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="twitter"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Update Admin Profile</h6>

                            <form method="POST" action="{{ route('admin.profile.store') }}" class="forms-sample"
                                enctype="multipart/form-data" id="myForm">
                                @csrf

                                {{-- Here we have to all of our field --}}
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label ">Username</label>
                                    <input type="text" name="username" class="form-control" id="exampleInputUsername1"
                                        autocomplete="off" value="{{ $profileData->username }}">
                                    <small class="text-danger error-username"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputName" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputName"
                                        autocomplete="off" value="{{ $profileData->name }}">
                                    <small class="text-danger error-name"></small>


                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail"
                                        autocomplete="off" value="{{ $profileData->email }}">
                                    <small class="text-danger error-email"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPhone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="exampleInputPhone"
                                        autocomplete="off" value="{{ $profileData->phone }}">
                                    <small class="text-danger error-phone"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputCity" class="form-label">City Name</label>
                                    <input type="text" name="city_name" class="form-control" id="exampleInputCity"
                                        autocomplete="off" value="{{ $profileData->city_name }}">
                                    <small class="text-danger error-city_name"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputAddress" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="exampleInputAddress"
                                        autocomplete="off" value="{{ $profileData->address }}">
                                    <small class="text-danger error-address"></small>

                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Photo</label>
                                    <input type="file" name="photo" class="form-control" id="image">
                                    <small class="text-danger error-photo"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="previewImage" class="form-label "></label>
                                    <img class="wd-80 rounded-circle preview-Image" id="previewImage"
                                        src="{{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                        alt="profile">
                                </div>
                                <div id="formMessage"></div>
                                <button type="submit" class="btn btn-primary me-2" id="submitBtn">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {



            $('#myForm').on('submit', function(e) {
                e.preventDefault();

                let form = this;
                let url = $(this).attr('action');
                let formData = new FormData(form);

                // assigning the info
                let name = $('#exampleInputUsername1').val();
                let email = $('#exampleInputEmail').val();
                let phone = $('#exampleInputPhone').val();
                let address = $('#exampleInputAddress').val();



                // Button Loading Screen
                let btn = $('#submitBtn');
                let originalText = btn.text();

                btn.prop('disabled', true);
                btn.html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Saving...'
                );




                $('small.text-danger').html('');
                $('#formMessage').html('');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {

                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        };

                        toastr[response.alertType](response.message);
                    },

                    error: function(xhr) {

                        if (xhr.status === 401) {
                            toastr.error('Please login to submit this form.');
                            return;
                        }

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, message) {
                                $('.error-' + field).html(message[0]);
                            });
                        } else {
                            toastr.error('Something went wrong.');
                        }
                    },

                    complete: function() {
                        btn.prop('disabled', false);
                        btn.text(originalText);
                        //updating the info
                        $('.usernameField').text(name);
                        $('.emailField').text(email);
                        $('.phoneField').text(phone);
                        $('.address').text(address);
                    }
                });
            });



            // image rendering
            $('#image').on('change', function() {
                let file = this.files[0];
                console.log(file);

                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('.preview-Image').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(file);

                }
            });




        }); //End
    </script>
@endsection
