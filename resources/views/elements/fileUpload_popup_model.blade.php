<div class="modal fade" id="imageUploadModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px;">
                <div class="title">Upload Images</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div id="dropzoneImage">
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
                <div id="dropzoneVideo">
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