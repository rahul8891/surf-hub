@extends('layouts.admin.master')
@section('content')
<!--/. container-fluid -->

<!-- right column -->
<div class="col-md-12">
    <!-- general form elements disabled -->
    <!-- <div id="loader"></div> -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Page Details</h3>
        </div>
        <!-- /.card-header -->
        <form role="form" method="POST" action="{{ route('adminPageUpdate',Crypt::encrypt($pages->id)) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Row Start -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label> {{ _('Title') }} <span class="required">*</span> </label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                value="{{ old('title',$pages->title) }}" required autocomplete="title" placeholder=""
                                readonly>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label> {{ _('Body') }} <span class="required">*</span> </label>
                            <div class="card-body pad">
                                <div class="">
                                    <textarea class="textarea" name="body" style="height:150px;"
                                        placeholder="Place some text here" required>{{ __($pages->body) }} </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row End -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('adminPageIndex')}}" class="btn btn-default">Back</a>
                <button type="submit" id="next" class="btn btn-info float-right">Submit</button>
            </div>
        </form>
        <!-- /.card-footer -->
    </div>
    @endsection