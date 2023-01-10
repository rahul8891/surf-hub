@extends('layouts.admin.admin_layout')
@section('content')

<section class="home-section">
            <div class="container">
                <div class="home-row">
                    <div class="middle-content">
                        <div class="table-strip-wrap">
                            <div class="strip-table-header">
                                <h2>Pages</h2>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">

                                    <thead>
                                        <tr>
                                            <th>User #</th>
                                            <th>Page Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($pages as $key => $value)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ __($value->title) }}</td>
                                            <td><a class="blue-txt add-ads" data-bs-toggle="modal" data-bs-target="#editAdsModal" data-id="{{ $value->id }}">Add Ads</a></td>
                                            <td><a class="blue-txt" href="{{route('adminPageEdit', Crypt::encrypt($value->id))}}">Edit</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="editAdsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editAdsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="" id="" method="POST" name="storeAdminAds" action="{{ route('storeAdminAds') }}" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdsModalLabel">Home Page Ads</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" name="position[]" type="checkbox" value="TOPLEFT" id="topLeft">
                                <label class="form-check-label" for="topLeft">
                                    Top Left
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="position[]" type="checkbox" value="BOTTOMLEFT" id="bottomLeft">
                                <label class="form-check-label" for="bottomLeft">
                                    Bottom Left
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="position[]" type="checkbox" value="TOPRIGHT" id="topRight">
                                <label class="form-check-label" for="topRight">
                                    Top Right
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="position[]" type="checkbox" value="BOTTOMRIGHT" id="bottomRight">
                                <label class="form-check-label" for="bottomRight">
                                    Bottom Right
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="multiple-photo-upload text-center">
                                
                                <div class="upload-photo-multiple d-inline-block">
                                    <div>
                                        <img src="/img/upload-arrow.png">
                                        <span>Upload File</span>
                                    </div>
                                    
                                    <input type="file" name="file" id="formFile">
                                </div>
                                <p>Ads Size should be <br>
                                    250 X 422px</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="page_id" id="page_id" value="">
                    <input type="submit" value="Update" class="btn blue-btn">
                    <button type="button" class="btn red-btn" data-bs-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

        <script type="text/javascript">
    $(document).on('click', '.add-ads', function() {
      var id = $(this).data('id');
      $('#page_id').val(id);
                                    
    });
    </script>
    @endsection
