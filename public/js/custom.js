$(document).ready(function () {

    /************** spiner code ****************************/
    var stopSpiner = "{{ $spiner}}";
    var spinner = $('#loader');

    $('#next').click(function (event) {
        spinner.show();
    });

    /**
    hide spiner
    */
    if (stopSpiner) {
    spinner.hide();
    }
    /************** end spiner code ****************************/
    
    $("#category-img-tag").addClass("notDisplayed");
    $("#exampleInputFile").change(function(){
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#category-img-tag").removeClass("notDisplayed");
                $('#category-img-tag').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

});


