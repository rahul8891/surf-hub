@extends('layouts.admin.master')
@section('content')
<?php 
?>
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
                        <div class="col-3">
                            <h2 class="">
                                {{ __(ucwords($users->user_profiles->first_name .' '.$users->user_profiles->last_name)) }}
                            </h2>
                            <p class="text-muted text-md"><b>User Name: </b> {{ __($users->user_name)}} </p>
                            <p class="text-muted text-md"><b>Email : </b> {{ __($users->email)}} </p>
                            <p class="text-muted text-md">
                                <b>Status : </b>
                                @if($users->status == config('customarray.status.ACTIVE'))
                                <span class="badge badge-success">{{ __($users->status)}}</span>
                                @elseif($users->status == config('customarray.status.DEACTIVATED'))
                                <span class="badge badge-danger">{{ __($users->status)}}</span>
                                @elseif($users->status == config('customarray.status.PENDING'))
                                <span class="badge badge-info">{{ __($users->status)}}</span>
                                @endif
                            </p>
                            <p class="text-muted text-md"><b>Facebook : </b> {{ __($users->user_profiles->facebook)}}
                            </p>
                            <p class="text-muted text-md"><b>Instagram : </b> {{ __($users->user_profiles->instagram)}}
                            </p>
                            <p class="text-muted text-md"><b>Country : </b>
                                {{ __($users->user_profiles->countries->name)}} </p>
                            <p class="text-muted text-md"><b>State : </b>
                                {{ __($users->user_profiles->states ? $users->user_profiles->states->name : 'NA')}} </p>
                            <p class="text-muted text-md"><b>City : </b> NA </p>
                        </div>
                        <div class="col-3">
                            <h2 class="lead"><b><br /></b></h2>
                            <p class="text-muted text-md"><b>Phone: </b> {{ __($users->user_profiles->phone)}} </p>
                            <p class="text-muted text-md"><b>Gender: </b> {{ __($users->user_profiles->gender)}} </p>
                            <p class="text-muted text-md"><b>Date Of Birth : </b> {{ __($users->user_profiles->dob)}}
                            </p>
                            <p class="text-muted text-md"><b>Relationship : </b>
                                {{ __($users->user_profiles->relationship)}} </p>
                            <p class="text-muted text-md"><b>Suburb : </b> {{ __($users->user_profiles->suburb)}} </p>
                            <p class="text-muted text-md"><b>Preferred Location : </b>
                                {{ __($users->user_profiles->preferred_location)}} </p>
                            <p class="text-muted text-md"><b>Address : </b>
                                {{ _($users->user_profiles->address ? $users->user_profiles->address :  'NA') }} </p>

                        </div>
                        <div class="col-4 text-center">
                            @if($users->profile_photo_path)
                            <a href="{{ asset('storage/'.$users->profile_photo_path) }}" data-toggle="lightbox"
                                data-title="{{ __(ucwords($users->user_profiles->first_name .' '.$users->user_profiles->last_name)) }}"
                                data-gallery="gallery">
                                <img src="{{ asset('storage/'.$users->profile_photo_path) }}"
                                    class="img-circle img-fluid" height="40%" width="40%" alt="Profile Photo" />
                            </a>
                            @else
                            <img class="img-circle img-fluid" src="{{ asset("/AdminLTE/dist/img/avatar5.png")}}"
                                alt="Profile Photo" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <a href="{{ route('adminUserListIndex')}}" class="btn btn-sm btn-default">
                            <i class="fa fa-chevron-left"></i> Back
                        </a>
                        <a href="{{route('adminUserEdit', Crypt::encrypt($users->id))}}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection