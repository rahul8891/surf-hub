$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
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
    
    /**********************************************************
     * set image preview after selection
     * ********************************************************/
    // $("#category-img-tag").addClass("notDisplayed");
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


    /************************************************************
     *              Update user status
     ***********************************************************/
    $('.changeStatus').on('switchChange.bootstrapSwitch',function (e,data) {
        var currentStatus = data;
        var userId = $(this).data("id");      
        spinner.show();
        $.ajax({
            type: "POST",
            url: 'updateUserStatus',
            data: {user_id : userId, status: currentStatus, _token: csrf_token},
            dataType: 'json',
            success: function(jsonResponse) {            
              if(jsonResponse.status =='success')
              {            
               spinner.hide();  
                document.getElementById('error').innerHTML = jsonResponse.message;
                document.getElementById("error").className = "alert alert-success";
              }else{
                spinner.hide();
                document.getElementById('error').innerHTML = jsonResponse.message; 
                document.getElementById("error").className = "alert alert-danger"; 
              }
              setInterval(myTimerUserMessage, 4000); 
            }
          });       
    });    



});

/**
 * remove message after time set hit
 */
function myTimerUserMessage() {
    document.getElementById('error').innerHTML = ''; 
    document.getElementById("error").className = ''; 
 }

