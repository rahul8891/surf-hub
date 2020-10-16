@extends('layouts.master')
@section('content')
<!--/. container-fluid -->

<!-- right column -->
<div class="col-md-12">
   <!-- general form elements disabled -->
   <div id="loader"></div>
   <div class="card card-primary">
      <div class="card-header">
         <h3 class="card-title">Create New User</h3>
      </div>
      <!-- /.card-header -->
      <form role="form" method="POST" action="{{ route('adminUserStore') }}" enctype="multipart/form-data">
         @csrf
         <div class="card-body">
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label> {{ _('User Name') }} <span class="required">*</span> </label>
                     <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"  placeholder="">
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
                     <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name')}} " placeholder="" required>
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
                     <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="">
                  </div>
               </div>
            </div>
            <!-- Row End -->
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Email') }} <span class="required">*</span></label>
                     <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="" required>
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
                     <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone">
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
                     <input type="text" class="form-control" name="facebook" value="{{ old('facebook') }}" autocomplete="facebook">
                  </div>
               </div>
            </div>
            <!-- Row End -->
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Instagram Profile Link') }}</label>
                     <input type="text" class="form-control" name="instagram" value="{{ old('instagram') }}" autocomplete="instagram">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ _('Country') }} <span class="required">*</span></label>
                     <select class="form-control select2 @error('country_id') is-invalid @enderror" style="width: 100%;" name="country_id" required>
                        <option value="">--Select--</option>
                        @foreach($countries as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                     <label>{{ __('Account Type') }} <span class="required">*</span></label>
                     <select class="form-control select2 @error('account_type') is-invalid @enderror" style="width: 100%;" name="account_type" required>
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
                    <img src="#" id="category-img-tag" class="" width="80px" /> 
                  </div>
               </div>
            </div>
            <!-- Row End -->
            <div class="row">
               <!-- Row Start -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>{{ __('Password') }} <span class="required">*</span></label>
                     <input  class="form-control @error('password') is-invalid @enderror" type="password" value="admin@123" name="password" required autocomplete="new-password">
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
                     <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="admin@123" name="password_confirmation" required autocomplete="new-password">
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
                        <label class="form-check-label">Accept legal <a href="javaScript:void(0)">terms and conditions!</a></label>
                     </div>
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