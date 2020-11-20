@extends('layouts.admin.master')
@section('content')
<!--/. container-fluid -->

<!-- right column -->
<div class="col-md-12">
    <!-- general form elements disabled -->
    <!-- <div id="loader"></div> -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New User</h3>
        </div>
        <!-- /.card-header -->
        <form role="form" id="register" name="register" method="POST" action="{{ route('adminUserStore') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <img src="{{asset("/AdminLTE/dist/img/avatar5.png")}}" alt="Profile Photo" class="img-circle img-fluid" />
                        </div>
                    </div>
                    <div class="col-sm-4 py-5">
                        <div class="form-group">
                            <label for="exampleInputFile">{{ __('Profile Photo') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile"
                                        name="profile_photo_name" value="{{ old('profile_photo_name') }}">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="imgWrap upload-btn-wrapper">
                            <img src="{{asset("/AdminLTE/dist/img/avatar5.png")}}" alt="Profile Photo" class="img-circle img-fluid" />
                            <input type="file" accept=".png .jpg .jpeg" id='exampleInputFile' name="profile_photo_name">
                            <input type="hidden" accept=".png .jpg .jpeg" id='imagebase64' name="profile_photo_blob">
                        </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <img src="#" id="category-img-tag" class="" width="80px" />
                                </div>
                            </div> --}}

                    </div>
                    
                    <!-- Row end -->
                </div>
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('First Name') }} <span class="required">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                name="first_name" autofocus value="{{ old('first_name')}}" placeholder="First Name" required>
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
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"
                                placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label> {{ _('User Name') }} <span class="required">*</span> </label>
                            <input class="form-control @error('user_name') is-invalid @enderror" type="text" name="user_name"
                                value="{{ old('user_name') }}"  autocomplete="user_name" placeholder="User Name" required>
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
                                value="{{ old('email') }}" placeholder="Email" required>
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
                                <option value="{{ $key }}">{{ $value }}</option>
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
                                <option value="{{ $key }}">{{ $value }}</option>
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
                                    {{ old('country_id') == $value->id ? "selected" : "" }}>
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
                                value="{{ old('phone') }}" placeholder="Phone No." autocomplete="phone" minlength="10" maxlength="15">
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

                            <input type="text"
                                class="form-control @error('local_beach_break') is-invalid @enderror search-box"
                                name="local_beach_break" placeholder="Search Beach Break "
                                value="{{ old('local_beach_break')}}">
                            @error('local_beach_break')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <input type="hidden" name="local_beach_break_id" id="local_beach_break_id"
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
                            <input type="text" class="form-control" name="facebook" value="{{ old('facebook') }}"
                                autocomplete="facebook">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ _('Instagram Profile Link') }}</label>
                            <input type="text" class="form-control" name="instagram" value="{{ old('instagram') }}"
                                autocomplete="instagram">
                        </div>
                    </div>
                </div>
                <!-- Row End -->
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{ __('Password') }} <span class="required">*</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password"
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
                </div>
                <!-- Row End -->
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" checked>
                                <label class="form-check-label">Accept legal <a href="javaScript:void(0)">terms and
                                        conditions!</a></label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row End -->
            </div>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button class="btn btn-success crop_image">Crop</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts/models/image_crop')
    @endsection