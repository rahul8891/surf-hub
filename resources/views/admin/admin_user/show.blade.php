@extends('layouts.master')
@section('content')

<div class="col-md-12">
   <div class="card card-primary">
      <div class="card-header">
         <h3 class="card-title">User Details</h3>
      </div>
   </div>
   <div class="row d-flex align-items-stretch">
      <div class="col-12">
         <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
            </div>
            <div class="card-body pt-0">
               <div class="row">
                  <div class="col-7">
                     <h2 class="lead"><b>{{ __(ucwords($users->user_profiles->first_name .' '.$users->user_profiles->last_name)) }}</b></h2>
                     <p class="text-muted text-md"><b>User Name: </b> {{ __($users->name)}} </p>
                     <p class="text-muted text-md"><b>Email : </b> {{ __($users->email)}} </p>
                     <p class="text-muted text-md">
                         <b>Status : </b>
                         @if($users->status == 'ACTIVE')
                         <span class="badge badge-success">{{ __($users->status)}}</span> 
                         @elseif($users->status == 'DEACTIVATED')
                         <span class="badge badge-danger">{{ __($users->status)}}</span>
                         @elseif($users->status == 'PENDING')
                         <span class="badge badge-info">{{ __($users->status)}}</span>
                         @endif
                    </p>
                    <p class="text-muted text-md"><b>Facebook : </b> {{ __($users->user_profiles->facebook)}}  </p>
                    <p class="text-muted text-md"><b>Instagram : </b> {{ __($users->user_profiles->instagram)}}  </p>
                     <p class="text-muted text-md"><b>Country : </b> {{ __($users->user_profiles->countries->name)}}  </p>
                     <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: {{ _($users->user_profiles->address ? $users->user_profiles->address :  'NA') }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + {{ _($users->user_profiles->phone ? $users->user_profiles->phone : 'xxxx-xxx-xxx' )}}</li>
                     </ul>
                  </div>
                  <div class="col-5 text-center">
                    @if($users->profile_photo_path)
                        <img class="img-circle img-fluid" src="{{ asset('storage/'.$users->profile_photo_path) }}" height="35%" width="35%" alt="Profile Photo"/>
                        @else
                        <img class="img-circle img-fluid" src="{{ asset("/AdminLTE/dist/img/avatar5.png")}}" alt="Profile Photo"/>
                    @endif 
                  </div>
               </div>
            </div>
            <div class="card-footer">  
                <div class="text-right">
                    <a href="{{ route('adminUserListIndex')}}" class="btn btn-sm btn-default">
                      <i class="fa fa-chevron-left"></i> Back
                    </a>
                    <a href="#" class="btn btn-sm btn-primary">
                      <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>                
            </div>
         </div>
      </div>      
   </div>
</div>
@endsection