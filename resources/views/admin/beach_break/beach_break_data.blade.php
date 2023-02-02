<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <img alt="" src="{{ asset("/img/close.png")}}">
            </button>
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
                                    <input type="text" value="{{$beach_break[0]['beach_name']}}" class="form-control mb-0" name="beach_name" id="beach_name" onkeyup="beachRules(this.value)">
                                </div>
                                <div class="align-items-center d-flex mb-4">
                                    <label class="form-label me-3 w-150">Break Name</label>
                                    <input type="text" class="form-control mb-0" name="break_name" id="break_name" value="{{$beach_break[0]['break_name']}}" onkeyup="breakRules(this.value)">
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
                                    src="https://maps.google.com/maps?q={{$beach_break[0]['latitude']}}, {{$beach_break[0]['longitude']}}&hl=us&z=14&amp;output=embed"
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
<script>
    $(document).ready(function () {

        var beach_name = $('#beach_name').val();
        if(beach_name !== '') {
        beachRules(beach_name);
        }
        var break_name = $('#break_name').val();
        if(break_name !== '') {
        breakRules(break_name);
        }

        $("form[name='beachBreakUpdate']").validate({
            rules: {
                beach_name: {
                    required: true,
                },
                break_name: {
                    required: true,
                },
                city_region: {
                    required: true,
                },
                state: {
                    required: true,
                },
                country: {
                    required: true
                },
                latitude: {
                    required: true
                },
                longitude: {
                    required: true
                }
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio")) {
                    error.insertAfter(element.parent().parent());
                } else {
                    // This is the default behavior of the script for all fields
                    error.insertAfter(element);
                }
            },
            messages: {
                beach_name: {
                    required: "Please enter beach name"
                },
                break_name: {
                    required: "Please enter break name"
                },
                city_region: {
                    required: "Please enter city"
                },
                state: {
                    required: "Please enter state"
                },
                country: {
                    required: "Please enter country"
                },
                latitude: {
                    required: "Please enter latitude"
                },
                longitude: {
                    required: "Please enter longitude"
                }
            },
            submitHandler: function (form, e) {
                form.submit();

            }
        });

    });
    function beachRules(beach) {
        
        if (beach !== '') {
            $('#break_name').rules('remove', 'required');
        } else {
            $('#break_name').rules('add', {
                required: true,
                messages: {
                    required: "Please enter break name"
                }
            });
        }

    }
    function breakRules(break_val) {
        if (break_val !== '') {
            $('#beach_name').rules('remove', 'required');
        } else {
            $('#beach_name').rules('add', {
                required: true,
                messages: {
                    required: "Please enter beach name"
                }
            });
        }

    }
</script>