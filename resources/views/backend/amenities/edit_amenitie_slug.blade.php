@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <div class="row profile-body">
            <!-- left wrapper start -->

            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Edit Amenities</h6>

                            <form method="POST" action="{{ route('update.slug.amenities', $amenities->slug) }}"
                                class="forms-sample" id="myForm">
                                @csrf
                                @method('PUT')

                                {{-- <input type="hidden" name="slug" value="{{ $amenities->slug }}"> --}}
                                {{-- <input type="hidden" name="id" value="{{ $amenities->id }}"> --}}
                                {{-- Here we have to all of our field --}}

                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Amenities Name</label>
                                    <input type="text" name="amenities_name" class="form-control"
                                        value="{{ $amenities->amenities_name }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ $amenities->slug }}">
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- middle wrapper end -->
                <!-- right wrapper start -->

                <!-- right wrapper end -->
            </div>

        </div>
    @endsection
