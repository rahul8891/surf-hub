@extends('layouts.admin.admin_layout')
@section('content')
<style>
    .loadingWrap {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 20em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
.loadingWrap:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loadingWrap:not(:required) {
  /* hide "loadingWrap..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loadingWrap:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
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
                                <div>
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
                                        
                                        <div
                                            class="d-inline-block d-lg-inline-block dropdown filter ms-2 my-lg-0 my-3 searchByFilter">
                                            <form class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <div class="row">
                                                    <label for="serachBy" class="col-sm-4 col-form-label">Search
                                                        by</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control mb-0" id="serachBy">
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="dropdown-menu" style="width: 400px;">
                                                <form class="filterWrap" action="{{route('beachBreakListIndex')}}" aria-labelledby="dropdownMenuButton2" name="searchFilter">
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
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">

                                    <thead>
                                        <tr>
                                            <th>#</th>
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
                                            <td>{{ ($beach_break->currentpage()-1) * $beach_break->perpage() + $key + 1  }}</td>
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