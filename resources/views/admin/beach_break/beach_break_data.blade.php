@extends('layouts.admin.admin_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="middle-content">
                <div class="table-strip-wrap">
                    <div class="strip-table-header">
                        <h2>Users</h2>
                        <div class="filter dropdown searchByFilter">
                            <form class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="row">
                                    <label for="serachBy" class="col-sm-4 col-form-label" >Search by</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control mb-0" id="serachBy">
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown-menu">
                                <div class="filter-header">
                                    <h5>Search by</h5>
                                    <a href="#">Clear</a>
                                </div>
                                <div class="filter-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >User Name</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >First Name</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >Sur Name</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >Age</label>
                                                <div class="d-flex w-100">
                                                    <div class="align-items-center d-flex">
                                                        <label class="form-label me-3" >From</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                    <div class="align-items-center d-flex ms-2">
                                                        <label class="form-label me-3" >To</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >#of Uploads</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >User Type</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >#of Posts</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >Status</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >Country</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >State</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >Postcode</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                            <div class="align-items-center d-flex mb-4">
                                                <label class="form-label me-3 w-150" >Gender</label>
                                                <input type="text" class="form-control mb-0">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn blue-btn w-150">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">

                            <thead>
                                <tr>
                                    <th>User #</th>
                                    <th>User Name</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>#Of Uploads</th>
                                    <th>#Of Posts</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $value)
                                <tr>
                                    <td>{{ ($users->currentpage()-1) * $users->perpage() + $key + 1  }}</td>
                                    <td>{{$value->user_name}}</td>
                                    <td>{{ __(ucwords($value->user_profiles->first_name .' '.$value->user_profiles->last_name)) }}</td>
                                    <td>45</td>
                                    <td>231</td>
                                    <td>221</td>
                                    <td>{{$value->status}}</td>
                                    <td>
                                        <a href="{{route('adminUserDetails', Crypt::encrypt($value->id))}}" class="blue-txt">View</a>
                                        |
                                        <a href="{{route('adminUserEdit', Crypt::encrypt($value->id))}}" class="blue-txt">Edit</a>
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
</section>
@endsection