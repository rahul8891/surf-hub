@extends('layouts.user.new_layout')
@section('content')
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible" role="alert" id="msg">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ ucfirst($message) }}
</div>
@elseif ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible" role="alert" id="msg">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ ucfirst($message) }}
</div>
@endif
<div class="contact-wrap">
            <div class="container">
                <h1>Contact Us</h1>
                <p>Submit your detail here with message, We will
                    consider your query shortly</p>

                 <form class="form" role="form" id="contact_us" name="contact_us" method="get" action="{{ route('getQuery') }}" enctype="multipart/form-data">
                   @csrf
                    <div>
                        <input type="text" name="name" placeholder="User Name" class="form-control ps-2" minlength="5" value="{{ old('name') }}" autocomplete="name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="email" placeholder="Email" class="form-control ps-2" value="{{ old('email') }}" autocomplete="email" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="subject" placeholder="Subject" class="form-control ps-2">
                        @error('subject')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <textarea name="description" class="form-control ps-2" placeholder="Message" style="height: 80px"></textarea>
                        @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                    </div>
                    <button type="submit" class="btn blue-btn w-100">SEND MESSAGE</button>
                </form>
            </div>
        </div>

@endsection