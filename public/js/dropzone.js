jQuery(document).ready(function() {
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

        
    
});