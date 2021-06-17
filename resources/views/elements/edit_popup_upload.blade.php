<div class="modal fade" id="editImageModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px;">
                <div class="title">Upload Images</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div id="dropzone-editImage">
                    <form class="dropzone" id="editImageUploads" enctype="multipart/form-data">
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

<div class="modal fade" id="editVideoModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px;">
                <div class="title">Upload Videos</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div id="dropzone-editVideo">
                    <form class="dropzone" id="editVideoUploads" enctype="multipart/form-data">
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