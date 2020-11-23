@extends('layouts.admin.master')
@section('content')
<?php 
?>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Post Details</h3>
        </div>
    </div>
    <div class="row d-flex align-items-stretch">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-muted">
                                {{ __($post->post_text)}}
                            </h4>
                            {{-- <p class="text-muted text-md"><b>Post text: </b> {{ __($post->post_text)}} </p> --}}
                            <p class="text-muted text-md"><b>Post Type : </b> {{ __($post->post_type)}} </p>
                            <p class="text-muted text-md"><b>Country : </b> {{ __($post->countries->name)}} </p>
                            <p class="text-muted text-md"><b>state : </b> {{ __($post->states ? $post->states->name : 'NA')}} </p>
                            <p class="text-muted text-md"><b>Beach Break : </b> {{ __($post->beach_breaks->beach_name)}}</p>
                            <p class="text-muted text-md"><b>Board Type : </b> {{ __($post->board_type)}}</p>
                            <p class="text-muted text-md"><b>wave size : </b> {{ __($post->wave_size)}}</p>
                            <p class="text-muted text-md"><b>Surfer : </b> {{ __($post->surfer)}}</p>
                            <p class="text-muted text-md"><b>Surf Start Date : </b> {{ __($post->surf_start_date)}}</p>
                            <p class="text-muted text-md"><b>Surf end Date : </b> {{ __($post->surf_end_date)}}</p>
                            <p class="text-muted text-md"><b>Optional Info : </b> {{ __($post->optional_info)}}</p>
                            <p class="text-muted text-md"><b>Uploaded on : </b> {{ __()}}</p>
                            <p class="text-muted text-md"><b>Last Update : </b> {{ __()}}</p>
                        </div>
                        <div class="col-6">
                            <label for="exampleInputFile">{{ __('Profile Photo') }}</label>
                            <div class="imgWrap upload-btn-wrapper form-group">
                                
                                @if($post->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$post->user->profile_photo_path) }}" height="20%" width="20%"
                                alt="Profile Photo" data-userid="{{ $post->user->id }}" id="category-img-tag"
                                class="img-fluid" alt="" id="category-img-tag">
                                @else
                                <img src="{{ asset("/img/profile1.jpg")}}" height="20%" width="20%" alt="Profile Photo"
                                id="category-img-tag" data-userid="{{ $post->user->id }}" class="img-fluid">
                                @endif
                                
                        </div>
                            <h2 class="lead"><b><br /></b></h2>
                            <p class="text-muted text-md"><b>Username: </b> {{ __($post->user->user_name)}} </p>
                            <p class="text-muted text-md"><b>Email: </b> {{ __($post->user->email)}} </p>
                            <p class="text-muted text-md"><b>Full Name : </b> {{ __(ucwords($post->user_profiles->first_name .' '.$post->user_profiles->last_name))}}</p>
                            <p class="text-muted text-md"><b>Phone: </b> {{ __($post->user_profiles->phone)}} </p>
                            <p class="text-muted text-md"><b>Gender: </b> {{ __($post->user_profiles->gender)}} </p>
                            <p class="text-muted text-md"><b>Relationship : </b> {{ __($post->user_profiles->relationship)}} </p>
                            <p class="text-muted text-md"><b>Suburb : </b> {{ __($post->user_profiles->suburb)}} </p>
                            <p class="text-muted text-md"><b>Address : </b> {{ _($post->user_profiles->address ? $post->user_profiles->address :  'NA') }} </p>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <a href="{{ route('postIndex')}}" class="btn btn-sm btn-default">
                            <i class="fa fa-chevron-left"></i> Back
                        </a>
                        <a href="{{route('postEdit', Crypt::encrypt($post->id))}}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit Post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection