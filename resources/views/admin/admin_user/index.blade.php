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
                                <form class="filterWrap" action="{{route('adminUserListIndex')}}" aria-labelledby="dropdownMenuButton2" name="searchFilter">
                                    <div class="filter-body">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >User Name</label>
                                                    <input type="text" class="form-control mb-0" name="username">
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >First Name</label>
                                                    <input type="text" class="form-control mb-0" name="fName">
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >Sur Name</label>
                                                    <input type="text" class="form-control mb-0" name="lName">
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >Age</label>
                                                    <div class="d-flex w-100">
                                                        <div class="align-items-center d-flex">
                                                            <label class="form-label me-3" >From</label>
                                                            <input type="number" class="form-control mb-0" name="age_from">
                                                        </div>
                                                        <div class="align-items-center d-flex ms-2">
                                                            <label class="form-label me-3" >To</label>
                                                            <input type="number" class="form-control mb-0" name="age_to">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >#of Uploads</label>
                                                    <input type="text" class="form-control mb-0" name="uploads">
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >User Type</label>
                                                    <select class="form-control mb-0"
                                                            name="user_type" id="filter_user_type">
                                                        <option value="">--Select--</option>
                                                        <option value="USER">Surfer</option>
                                                        <option value="PHOTOGRAPHER">Photographer</option>
                                                        <option value="SURFER CAMP">Surf Camp</option>
                                                        <option value="ADVERTISEMENT">Advertiser</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >#of Posts</label>
                                                    <input type="text" class="form-control mb-0" name="posts">
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >Status</label>
                                                    <select class="form-control mb-0" name="status"> 
                                                        <option value="">--Select--</option>
                                                        <option value="ACTIVE">Active</option>
                                                        <option value="DEACTIVATED">InActive</option>
                                                    </select>
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >Country</label>
                                                    <select class="form-control mb-0" name="country_id" id="filter_country_id">
                                                        <option value="">-- Country --</option>
                                                        @foreach($countries as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                                {{ old('country_id',Request::get('country_id')) == $value->id ? "selected" : "" }}>
                                                            {{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >State</label>
                                                    <select class="form-control mb-0" name="state_id" id="filter_state_id">
                                                        <option selected="selected" value="">-- State --</option>
                                                        @foreach($states as $key => $value)
                                                        <option value="{{ $value->id }}" 
                                                                {{ old('state_id',Request::get('state_id')) == $value->id ? "selected" : "" }}>
                                                            {{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >Postcode</label>
                                                    <input type="text" class="form-control mb-0" name="postcode">
                                                </div>
                                                <div class="align-items-center d-flex mb-4">
                                                    <label class="form-label me-3 w-150" >Gender</label>
                                                    <select class="form-control mb-0" name="gender" id="gender">
                                                        <option value="">Gender</option>
                                                        @foreach($gender_type as $key => $value)
                                                        <option value="{{ $key }}">
                                                            {{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn blue-btn w-150">Search</button>
                                        </div>
                                    </div>
                                </form>
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
                                    <td>{{ __(ucwords($value->first_name .' '.$value->last_name)) }}</td>
                                        @if($value->dob && $value->dob != '0000-00-00')
                                    <td>
                                        {{date('Y') - date('Y',strtotime($value->dob))}}
                                    </td>
                                        @else
                                        <td>--</td>
                                        @endif
                                    <td>{{ $postArr[$value->user_id]['nUpload'] }}</td>
                                    <td>{{ $postArr[$value->user_id]['nPost'] }}</td>
                                    <td>{{$value->status}}</td>
                                    <td>
                                        @if($value->user_type == 'USER')
                                        <a href="{{route('surfer-profile', Crypt::encrypt($value->user_id))}}" class="blue-txt">View</a>
                                        @elseif($value->user_type == 'SURFER CAMP')
                                        <a href="{{route('resort-profile', Crypt::encrypt($value->user_id))}}" class="blue-txt">View</a>
                                        @elseif($value->user_type == 'PHOTOGRAPHER')
                                        <a href="{{route('photographer-profile', Crypt::encrypt($value->user_id))}}" class="blue-txt">View</a>
                                        @elseif($value->user_type == 'ADVERTISEMENT')
                                        <a href="{{route('surfer-profile', Crypt::encrypt($value->user_id))}}" class="blue-txt">View</a>
                                        @endif
                                        |
                                        <a href="{{route('adminUserEdit', Crypt::encrypt($value->user_id))}}" class="blue-txt">Edit</a>
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