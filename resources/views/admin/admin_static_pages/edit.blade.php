@extends('layouts.admin.admin_layout')
@section('content')
<!--/. container-fluid -->

<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="middle-content">
                <div class="table-strip-wrap">
                    <div class="strip-table-header">
                            <a class="align-left mb-3 mt-3" href="{{ route('adminPageIndex') }}">
                                <img src="/img/back-btn.png" alt="back" class="align-middle">
                                Edit Page Details</a>
                        
                    </div>
                    <div class="mt-2">
                        <form role="form" method="POST" action="{{ route('adminPageUpdate',Crypt::encrypt($pages->id)) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Row Start -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label> {{ _('Title') }} <span class="required">*</span> </label>
                                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                               value="{{ old('title',$pages->title) }}" required autocomplete="title" placeholder=""
                                               >
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">

                                        <div class="">
                                            <textarea class="textarea" name="body" style="height:300px;"
                                                      placeholder="Place some text here" required>{{ __($pages->body) }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <button class="btn blue-btn w-150" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection