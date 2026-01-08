@extends('admin.admin_dashboard')
@section('admin')

<style>
    .eye_icon {
    align-items: center;
    justify-content: center;
    }
</style>



<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
                        <a type="button" href="{{ route('add.roles') }}" class="btn btn-inverse-info">Add Role</a>
                       	</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Roles All</h6>
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Role Name</th>
                        <th class="text-center">permission</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $item )
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center"><a href="{{ route('admin.edit.roles',$item->id) }}"><i class="fa-solid fa-eye"></i></a></td>
                        <td>
                            <a type="button" href="{{ route('edit.roles',$item->id)  }}" class="btn btn-inverse-warning">Edit</a>
                            <a type="button" href="{{ route('delete.roles',$item->id) }}" class="btn btn-inverse-danger" id="delete">Delete</a>
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





@endsection
