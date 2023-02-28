@extends('layouts.admin.admin_layout')
@section('content')
<style>
    
    </style>
<div class="justify-content-center loadingWrap d-none">
                    
</div>
<section class="home-section">
            <div class="container">
                <div class="home-row">
                    <div class="middle-content w-100">
                        <div class="table-strip-wrap">
                            <div class="strip-table-header">
                                <h2>Beach/Breaks</h2>
                                
                                    
                            </div>
                            <div class="table-responsive">
                                <div class="dropdown d-inline-block map-details">
                                        <div class="btn greyBorder-btn ms-0 " >
                                            <input type="file" name="beach_break_excel" id="beach_break_excel">
                                            <span>IMPORT EXCEL</span> 
                                        </div>
<!--                                        <button class="btn greyBorder-btn ms-0 ">
                                            <input type="file" name="beach_break_excel" id="beach_break_excel">IMPORT EXCEL
                                        </button>-->
                                        <button class="btn greyBorder-btn ms-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">MANUALLY ADD</button>
                                        <div class="dropdown-menu ">
                                            <div class="map-header">
                                                <h5>Manually Add</h5>
                                            </div>
                                            <form class="filterWrap" action="{{route('beachBreakStore')}}" name="beachBreakStore" method="POST">
                                            @csrf
                                                <div class="map-body">
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">Beach Name</label>
                                                            <input type="text" class="form-control mb-0" name="beach_name" required="required">
                                                        </div>
                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">Break Name</label>
                                                            <input type="text" class="form-control mb-0" name="break_name" required="required">
                                                        </div>
                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">City/Region</label>
                                                            <input type="text" class="form-control mb-0" name="city_region" required="required">
                                                        </div>
                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">State</label>
                                                            <input type="text" class="form-control mb-0" name="state" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">Country</label>
                                                            <input type="text" class="form-control mb-0" name="country" required="required">
                                                        </div>

                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">Latitude</label>
                                                            <input type="text" class="form-control mb-0" name="latitude" required="required">
                                                        </div>
                                                        <div class="align-items-center d-flex mb-4">
                                                            <label class="form-label me-3 w-150">Longitude</label>
                                                            <input type="text" class="form-control mb-0" name="longitude" required="required">
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-10 ms-auto ps-0">
                                                        <iframe
                                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7562068.0941798575!2d-24.222649315868658!3d22.262223951848174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b5bf5683236db%3A0x5865a017e6166526!2sSurf%20Hub%20Cabo%20Verde!5e0!3m2!1sen!2sin!4v1667312190058!5m2!1sen!2sin"
                                                            height="200" style="border:0;width: 100%;"
                                                            allowfullscreen="" loadingWrap="lazy"
                                                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                        <button type="submit" class="btn blue-btn">Add Beach/Breaks</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        
                                        <!-- <div class="d-inline-block d-lg-inline-block dropdown filter ms-2 my-lg-0 my-3 searchByFilter">
                                            <form class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="row">
                                                    <label for="serachBy" class="col-sm-4 col-form-label" id="serachBy">Search by</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control mb-0" id="serachBy">
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="dropdown-menu" style="width: 400px;">
                                                <form class="filterWrap" action="{{ route('beachBreakListIndex') }}" aria-labelledby="dropdownMenuButton2" name="searchFilter">
                                                <div class="filter-header">
                                                    <h5>Search by</h5>
                                                    <a href="#">Clear</a>
                                                </div>
                                                <div class="filter-body">
                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">Beach Name</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">Break Name</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">City/Region</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">State</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">Country</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>

                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">Latitude</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>
                                                    <div class="align-items-center d-flex mb-4">
                                                        <label class="form-label me-3 w-150">Longitude</label>
                                                        <input type="text" class="form-control mb-0">
                                                    </div>


                                                    <div class="text-center">
                                                        <button type="submit" class="btn blue-btn w-150">Search</button>
                                                    </div>
                                                </div> 
                                                </form>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <table class="table table-striped" id="beachBreak">
                                    <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Beach Name</th>
                                            <th>Break Name</th>
                                            <th>City/Region</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach($beach_break as $key => $value)
                                        <tr>
                                            
                                            <td>{{ $key + 1  }}</td>
                                            <td>{{ $value->beach_name }}</td>
                                            <td>{{ $value->break_name }}</td>
                                            <td>{{ $value->city_region }}</td>
                                            <td>{{ $value->country }}</td>
                                            <td>{{ $value->state }}</td>
                                            <td>{{ $value->latitude }}</td>
                                            <td>{{ $value->longitude }}</td>
                                            <td>
                                                
                                                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$value->latitude ?? ''}}" data-long="{{$value->longitude ?? ''}}" data-id="" class="locationMap">
                                                View Map</a>
                                                |
                                                <a data-id="{{ $value->id }}" class="beachbreakmodal">Edit</a>
                                            </td>
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
@include('elements/location_popup_model')    
@include('admin/beach_break/edit_beach_break_modal')
<script type="text/javascript">
    
</script>
@endsection