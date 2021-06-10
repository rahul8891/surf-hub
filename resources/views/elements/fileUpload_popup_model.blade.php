<script src="https://code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" type="text/javascript"></script>    
<div class="modal fade" id="imageUploadModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px;">
                <div class="title">Upload Images</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div id="dropzone">
                    <form class="dropzone" id="imageUploads" enctype="multipart/form-data">
                        @csrf
                        <div class="dz-message">
                            Upload Files here <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="videoUploadModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px;">
                <div class="title">Upload Videos</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div id="dropzone">
                    <form class="dropzone" id="videoUploads" enctype="multipart/form-data">
                        @csrf
                        <div class="dz-message">
                            Upload Files here <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    
    $('#imageUploads').dropzone({
        paramName: 'photos',
        url: '{{ route("uploadFiles") }}',
        dictDefaultMessage: "Drag your images",
        acceptedFiles: ".png, .jpg, .jpeg",
        clickable: true,
        enqueueForUpload: true,
        maxFilesize: 100,
        uploadMultiple: true,
        addRemoveLinks: false,
        success: function (file, response) {
            $(".uploadImageFiles").append('<input type="hidden" id="" name="files[]" value="'+response.success+'" />');
        },
        error: function (file, response) {
            console.log("something goes wrong");
        }
    });
    
    $('#videoUploads').dropzone({
        paramName: 'videos',
        url: '{{ route("uploadFiles") }}',
        dictDefaultMessage: "Drag your videos",
        clickable: true,
        acceptedFiles: ".mp4, .wmv, .mkv, .gif, .mpeg4, .mov",
        enqueueForUpload: true,
        maxFilesize: 1000,
        uploadMultiple: true,
        addRemoveLinks: false,
        success: function (file, response) {
            $(".uploadVideoFiles").append('<input type="hidden" id="" name="videos[]" value="'+response.success+'" />');
        },
        error: function (file, response) {
            console.log("something goes wrong");
        }
    });
</script>