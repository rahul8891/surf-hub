<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit</h5>
        </div>
        <div class="modal-body">
            <div class="map-details">
                <form class="filterWrap" action="{{route('beachBreakUpdate')}}" name="beachBreakUpdate" method="POST">
                    @csrf
                    <div class="map-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">Beach Name</label>
                                    <input type="text" value="{{$beach_break[0]['beach_name']}}" class="form-control mb-0" name="beach_name" required="required">
                                </div>
                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">Break Name</label>
                                    <input type="text" class="form-control mb-0" name="break_name" required="required" value="{{$beach_break[0]['break_name']}}">
                                </div>
                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">City/Region</label>
                                    <input type="text" class="form-control mb-0" name="city_region" required="required" value="{{$beach_break[0]['city_region']}}">
                                </div>
                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">State</label>
                                    <input type="text" class="form-control mb-0" name="state" required="required" value="{{$beach_break[0]['state']}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">Country</label>
                                    <input type="text" class="form-control mb-0" name="country" required="required" value="{{$beach_break[0]['country']}}">
                                </div>

                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">Latitude</label>
                                    <input type="text" class="form-control mb-0" name="latitude" required="required" value="{{$beach_break[0]['latitude']}}">
                                </div>
                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">Longitude</label>
                                    <input type="text" class="form-control mb-0" name="longitude" required="required" value="{{$beach_break[0]['longitude']}}">
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10 ms-auto ps-0">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7562068.0941798575!2d-24.222649315868658!3d22.262223951848174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b5bf5683236db%3A0x5865a017e6166526!2sSurf%20Hub%20Cabo%20Verde!5e0!3m2!1sen!2sin!4v1667312190058!5m2!1sen!2sin"
                                    height="200" style="border:0;width: 100%;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <input type="hidden" name="beach_break_id" value="{{$id}}" >
                                <button type="submit" class="btn blue-btn rounded-0">Update</button>
                                <a href="{{route('deleteBeachBreak', Crypt::encrypt($id))}}"  onclick="return confirm('Do you really want to delete this Beach/Break?')" class="btn red-btn rounded-0">Delete</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>