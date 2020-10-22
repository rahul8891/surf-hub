@extends('layouts.master')
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
      <form role="form" method="POST" action="{{ route('adminUserUpdate',Crypt::encrypt($users->id)) }}" enctype="multipart/form-data">
         @csrf
         <div class="card-body">
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label> {{ _('User Name') }} <span class="required">*</span> </label>
                     <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name',$users->name) }}" required autocomplete="name"  placeholder="" readonly>                   
                     @error('name')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('First Name') }} <span class="required">*</span></label>
                     <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name',$users->user_profiles->first_name)}} " placeholder="" required>
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
                     <input type="text" class="form-control" name="last_name" value="{{ old('last_name',$users->user_profiles->last_name) }}" placeholder="">
                  </div>
               </div>
            </div>
            <!-- Row End -->
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Email') }} <span class="required">*</span></label>
                     <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$users->email) }}" placeholder="" required readonly>
                     @error('email')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Phone') }}</label>
                     <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone',$users->user_profiles->phone) }}" autocomplete="phone">
                     @error('phone')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Facebook Profile Link') }}</label>
                     <input type="text" class="form-control" name="facebook" value="{{ old('facebook',$users->user_profiles->facebook) }}" autocomplete="facebook">
                  </div>
               </div>
            </div>
            <!-- Row End -->
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Instagram Profile Link') }}</label>
                     <input type="text" class="form-control" name="instagram" value="{{ old('instagram',$users->user_profiles->instagram) }}" autocomplete="instagram">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Country') }} <span class="required">*</span></label>
                     <select class="form-control select2 @error('country_id') is-invalid @enderror" style="width: 100%;" name="country_id" required>
                        <option value="">--Select--</option>
                        @foreach($countries as $key => $value)
                        <option value="{{ $value->id }}" {{ ( $value->id == $users->user_profiles->country_id) ? 'selected' : '' }}>{{ $value->name }}</option>
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
                     <label>{{ __('Preferred Language') }} <span class="required">*</span></label>
                     <select class="form-control select2 @error('language') is-invalid @enderror" style="width: 100%;" name="language" required>
                        <option value="">--Select--</option>
                        @foreach($language as $key => $value)
                        <option value="{{ $key }}" {{ ( $key = $users->user_profiles->language) ? 'selected' : '' }}>{{ $value }}</option>
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
                     <label>{{ __('Account Type') }} <span class="required">*</span></label>
                     <select class="form-control select2 @error('account_type') is-invalid @enderror" style="width: 100%;" name="account_type" required>
                        <option value="">--Select--</option>
                        @foreach($accountType as $key => $value)
                        <option value="{{ $key }}" {{ ( $key = $users->account_type) ? 'selected' : '' }}>{{ $value }}</option>
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
                     <label for="exampleInputFile">{{ __('Profile Photo') }}</label>
                     <div class="input-group">
                        <div class="custom-file">
                           <input type="file" class="custom-file-input" id="exampleInputFile" type="file" name="profile_photo_name" value="{{ old('profile_photo_name') }}">
                           <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                    <img src="{{ asset('storage/'.$users->profile_photo_path) }}" id="category-img-tag" class="" width="80px" /> 
                  </div>
               </div>
            </div>
            <!-- Row End -->                       
         </div>
         <!-- /.card-body -->     
         <div class="card-footer">
            <a href="{{ route('adminUserListIndex')}}" class="btn btn-default">Back</a>
            <button type="submit" id="next" class="btn btn-info float-right">Submit</button>
         </div>
      </form>
      <!-- /.card-footer -->
   </div>
@endsection