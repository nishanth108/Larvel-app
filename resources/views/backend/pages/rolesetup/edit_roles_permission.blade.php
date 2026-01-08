@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

    <style type="text/css">
        .form-check-label {
            text-transform: capitalize;
        }
    </style>

        <div class="row profile-body">
          <!-- left wrapper start -->

          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
             <div class="card">
              <div class="card-body">

								<h6 class="card-title">Edit Roles in Permission</h6>

								<form method="POST" action="{{ route('admin.roles.update',$role->id) }}" class="forms-sample"  id="myForm">
                                    @csrf

                                    {{-- Here we have to all of our field --}}

								<div class="form-group mb-3">
									<label for="exampleInputEmail1" class="form-label">Role Name</label>
                                    <h3>{{ $role->name }}</h3>
								</div>

                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="checkDefaultmain">
                                    <label for="checkDefaultmain" class="form-check-label">Permission All</label>
                                </div>
                                <hr>


                                @foreach ($permission_groups as $group)


                                <div class="row">
                                    <div class="col-3">
                                        {{-- PHP CODE --}}
                                        @php
                                            $permissions = App\Models\User::getPermissionGroupName($group->group_name)
                                        @endphp
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input group-checkbox group_{{ $group->group_name }}" id="checkDefault" {{
                                                App\Models\User::roleHasPermission($role,$permissions) ? "checked" : ""}}  data-group="{{ $group->group_name }}">
                                            <label for="checkDefault" class="form-check-label">{{ $group->group_name }}</label>
                                        </div>
                                    </div>

                                <div class="col-9">
                                    @foreach($permissions as $permission)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input  permission-checkbox" name="permission[]"
                                            id="checkDefault{{ $permission->id }}" data-group="{{ $group->group_name }}" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} >
                                            <label for="checkDefault{{ $permission->id }} " class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                    <br>
                                </div>

                                </div>
                                <br>

                                @endforeach
                                {{-- End Row --}}
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
        updateMainCheckbox();
        $('#checkDefaultmain').click(function(){

            if($(this).is(':checked')) {
                $('input[type = checkbox]').prop('checked',true);
            } else {
                $('input[type = checkbox]').prop('checked',false);
            }
        });

        $('.group-checkbox').click(function(){
            var groupName = $(this).data('group');
            var isChecked = $(this).is(':checked');
            if(!isChecked) {
                $('#checkDefaultmain').prop('checked',false);
            }
            $('.permission-checkbox[data-group="' + groupName + '"]').prop('checked', isChecked);

        updateMainCheckbox();

        });

        $('.permission-checkbox').click(function() {
            var groupName = $(this).data('group');

            var allPermission = $('.permission-checkbox[data-group="'+groupName+'"]');
            var checkedPermission = $('.permission-checkbox[data-group="'+groupName+'"]:checked');
            console.log(allPermission.length);
            console.log(checkedPermission.length);

            if(allPermission.length === checkedPermission.length) {
                $('.group_'+groupName).prop('checked',true);
            }
            else {
                $('.group_'+groupName).prop('checked',false);
                $('.checkDefaultmain').prop('checked',false);
            }
            updateMainCheckbox();
        })
        updateMainCheckbox();
        //function
       function updateMainCheckbox() {
        var allGroupCheckbox = $('.group-checkbox').length;
        var allGroupChecked = $('.group-checkbox:checked').length;
        $('#checkDefaultmain').prop('checked', allGroupCheckbox === allGroupChecked);
    }
    </script>



@endsection
