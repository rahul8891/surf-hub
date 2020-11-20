@extends('layouts.admin.master')
@section('content')
<!--/. container-fluid -->

<!-- right column -->
<div class="col-md-12">
    <!-- general form elements disabled -->
    <div id="loader"></div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit User Details</h3>
        </div>
        <!-- /.card-header -->
        <form role="form" id="update" name="update_profile" method="POST" action="{{ route('adminUserUpdate',Crypt::encrypt($users->id)) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="profileImgDetail">
                            {{-- <!-- <div class="imgWrap">
                                @if($users->profile_photo_path)
                                <img src="{{ asset('storage/'.$users->profile_photo_path) }}" class="img-fluid image"
                                    alt="" id="category-img-tag">
                                @else
                                <img src="{{ asset("/img/profile1.jpg")}}" class="img-fluid image" alt=""
                                    id="category-img-tag">
                                @endif
                            </div> --> --}}
                            <div class="imgWrap upload-btn-wrapper ">
                                @if($users->profile_photo_path)
                                <img src="{{ asset('storage/'.$users->profile_photo_path) }}" class="img-fluid image"
                                    alt="" id="category-img-tag">
                                @else
                                <img src="{{ asset("/img/profile1.jpg")}}" class="img-fluid image" alt=""
                                    id="category-img-tag">
                                @endif
                                <input type="file" accept=".png, .jpg, .jpeg" id="exampleInputProfileFile"
                                    name="profile_photo_name" />
                                <input type="text" accept=".png, .jpg, .jpeg" id="imagebase64"
                                    name="profile_photo_blob" />

                            </div>
                        </div>
                        <span id="imageError" class="notDisplayed required">{{ __('Please upload files having
                                            extensions: jpg, jpeg, png') }}</span>
                    
                    <!-- Row end -->
                </div>
                </div>
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('First Name') }} <span class="required">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                name="first_name" autofocus value="{{ old('first_name',$users->user_profiles->first_name)}} " placeholder="First Name" required>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Last Name') }}</label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name',$users->user_profiles->last_name) }}"
                                placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label> {{ _('User Name') }} <span class="required">*</span> </label>
                            <input class="form-control @error('user_name') is-invalid @enderror" type="text" name="user_name"
                            value="{{ old('name',$users->user_name) }}"  autocomplete="user_name" placeholder="User Name" readonly required>
                            @error('user_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Row End -->
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Email') }} <span class="required">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email',$users->email) }}" placeholder="Email" readonly required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Account Type') }} <span class="required">*</span></label>
                            <select class="form-control select2 @error('account_type') is-invalid @enderror"
                                style="width: 100%;" name="account_type" required>
                                <option value="">--Select--</option>
                                @foreach($accountType as $key => $value)
                                <option value="{{ $key }}" {{ ( $key = $users->account_type) ? 'selected' : '' }}>
                                    {{ $value }}</option>
                                @endforeach
                            </select>
                            @error('account_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Preferred Language') }} <span class="required">*</span></label>
                            <select class="form-control select2 @error('language') is-invalid @enderror"
                                style="width: 100%;" name="language" required>
                                <option value="">--Select--</option>
                                @foreach($language as $key => $value)
                                <option value="{{ $key }}"
                                    {{ ( $key = $users->user_profiles->language) ? 'selected' : '' }}>{{ $value }}
                                </option>
                                @endforeach
                            </select>
                            @error('language')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Row End -->
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Country') }} <span class="required">*</span></label>
                            <select
                                class="form-control select2 select2-hidden-accessible country local_beach_break_id"
                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                name="country_id" required>
                                <option value="" data-phone="">-- Country --</option>
                                @foreach($countries as $key => $value)
                                <option value="{{ $value->id }}" data-phone="{{$value->phone_code}}"
                                    {{ ( $value->id == $users->user_profiles->country_id) ? 'selected' : '' }}>
                                    {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Phone') }}</label>
                            <input type="text" class="form-control phone @error('phone') is-invalid @enderror" name="phone" required
                            value="{{ old('phone',$users->user_profiles->phone) }}" placeholder="Phone No." autocomplete="phone" minlength="10" maxlength="15">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                   
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Search Beach Break') }}</label>
                            @php
                                $bb=$users->user_profiles->beach_breaks;
                                $beach_break = $bb->beach_name.','.$bb->break_name .''.$bb->city_region.','.$bb->state.','.$bb->country;
                            @endphp
                            <input type="text"
                                class="form-control @error('local_beach_break') is-invalid @enderror search-box"
                                name="local_beach_break" placeholder="Search Beach Break "
                                value="{{ old('local_beach_break',$beach_break)}}">
                            @error('local_beach_break')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        <input type="hidden" value="{{old('local_beach_break',$users->user_profiles->local_beach_break_id)}}" name="local_beach_break_id" id="local_beach_break_id"
                                class="form-control">

                            <div class="auto-search search1" id="country_list"></div>
                        </div>
                    </div>
                </div>
                <!-- Row End -->
                <div class="row">
                    <!-- Row Start -->
                    
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Facebook Profile Link') }}</label>
                            <input type="text" class="form-control" name="facebook" value="{{ old('facebook',$users->user_profiles->facebook) }}"
                                autocomplete="facebook">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Instagram Profile Link') }}</label>
                            <input type="text" class="form-control" name="instagram" value="{{ old('instagram',$users->user_profiles->instagram) }}"
                                autocomplete="instagram">
                        </div>
                    </div>
                </div>
                <!-- Row End -->
                {{-- <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Password') }} <span class="required">*</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                             name="password"  autocomplete="new-password" placeholder="New Password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }} <span class="required">*</span></label>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                 name="password_confirmation"  autocomplete="password_confirmation" placeholder="Re-type Password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div> --}}
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('adminUserListIndex')}}" class="btn btn-default">Back</a>
                <button type="submit" id="next1" class="btn btn-info float-right">Submit</button>
            </div>
        </form>
        <!-- /.card-footer -->
    </div>
    <div id="myModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><img src="{{ asset("/img/logo_small.png")}}"> &nbsp; Crop
                        Image
                    </h5>
                    <button type="button" class="close1" data-dismiss="modal" aria-label="Close">
                        <img alt="" src="{{ asset("/img/close.png")}}">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="image"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center justify-content-center">
                    <button class="btn btn-success crop_profile_image">Crop</button>
                </div>
            </div>
        </div>
    </div>
    @endsection