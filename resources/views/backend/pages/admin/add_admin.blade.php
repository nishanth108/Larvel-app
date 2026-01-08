@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

        <div class="row profile-body">
          <!-- left wrapper start -->

          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-12 middle-wrapper">
            <div class="row">
             <div class="card">
              <div class="card-body">

								<h6 class="card-title">Add Admin</h6>

								<form method="POST" action="{{ route('store.admin') }}" class="forms-sample"  id="myForm">
                                    @csrf

                                    {{-- Here we have to all of our field --}}

									<div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Admin User Name</label>
                                        <input type="text" name="username" class="form-control" >
									</div>
                                    <div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Admin Name</label>
                                        <input type="text" name="name" class="form-control" >
									</div>
                                    <div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Admin Email</label>
                                        <input type="text" name="email" class="form-control" >
									</div>
                                    <div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Admin Phone</label>
                                        <input type="text" name="phone" class="form-control" >
									</div>
                                    <div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Admin Adress</label>
                                        <input type="text" name="address" class="form-control" >
									</div>
                                    <div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Admin password</label>
                                        <input type="text" name="password" class="form-control" >
									</div>
                                    <div class="form-group mb-3">
										<label for="exampleInputEmail1" class="form-label">Role Name</label>
                                        <select name="roles" class="form-select" id="exampleFormControlSelect1">
                                            <option selected="" disabled="">Select Group</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
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

   <script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({

            rules: {
                name: { required : true },
                username: { required : true },
                phone: { required : true },
                email: { required : true },
                address: { required : true },
                password: { required : true },
                roles: { required : true },
            },

            messages: {
                name: {
                    required : 'Please Enter Role Name',
                },
                username: {
                    required : 'Please Enter Admin UserName',
                },
                phone: {
                    required : 'Please Enter Admin Phone Number',
                },
                email: {
                    required : 'Please Enter Admin Email',
                },
                address: {
                    required : 'Please Enter Admin Address',
                },
                password: {
                    required : 'Please Enter Admin Password',
                },
                roles: {
                    required : 'Please Select Admin Role',
                },
            },

            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },

            highlight : function(element){
                $(element).addClass('is-invalid');
            },

            unhighlight : function(element){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
