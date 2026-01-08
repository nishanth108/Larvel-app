@extends('admin.admin_dashboard')
@section('admin')


<div class="page-content">

    <style type="text/css">
        .badge-bg-danger {
            text-transform: capitalize;
        }
    </style>

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
                  <table  class="table">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Role Name</th>
                        <th>Permission</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $item )
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->name }}</td>
                        {{-- Here we have to load multiple permission --}}
                        <td>
                            @foreach ($item->permissions as $prem)
                                <span class="badge bg-danger">{{ $prem->name }}</span>

                            @endforeach
                        <td>
                            <a type="button" href="{{ route('admin.edit.roles',$item->id)  }}" class="btn btn-inverse-warning">Edit</a>
                            <a type="button" href="{{ route('admin.delete.roles',$item->id) }}" class="btn btn-inverse-danger" id="delete">Delete</a>
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
