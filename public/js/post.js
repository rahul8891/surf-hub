$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');    
    /**
     * resetForm Form  validator on close 
     */
    $(".close").click(function (e) {
      var validator = $( "#postForm" ).validate();
      validator.resetForm();      
    });


    /**
     * Validate post form befor submit
     */
    $("form[name='postForm']").validate({			
      rules: {

        post_type: {
          required: true,        
        },
  
        post_text: {
          required: true,         
        },
  
        surf_date: {
          required: true,        
        },
  
        wave_size: {
          required: true,         
        },

        country_id: {
          required: true
        },
        
        local_beach_break: {
          required: true
        },

        state_id: {
          required: true
        },
  
        board_type: {
          required: true
        },
        
        surfer:{
          required:true
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
        post_type: {
          required: "Please select post type"        
        },
  
        post_text: {
          required: "Please enter post text"        
        },
  
        surf_date: {
          required: "Please select surf date"
        },
  
        wave_size: {
          required: "Please select wave size"         
        },

        country_id: {
          required: "Please select your country"
        },
        
        local_beach_break: {
          required: "Please enter beach break"
        },

        state_id: {
          required: "Please select state"
        },
  
        board_type: {
          required: "Please select board type"
        },
        
        surfer:{
          required: "Please select surfer"
        }
       
      },
      submitHandler: function (form) {       
        //spinner.show();

        // Manage Form Data
        var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function(){
          return $(this).val();
        }).get();

        var result = [];
        
        $.each($('form').serializeArray(), function() {
            result[this.name] = this.value;
        });

        result['optional_info'] = myCheckboxes;
        console.log( result);

      }
    });

    /*$("#postForm").submit(function(event){
        event.preventDefault();
        
        // manage optional info check box array
        var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function(){
            return $(this).val();
          }).get();
        
        // Manage Form Data
        var result = [];
        $.each($('form').serializeArray(), function() {
            result[this.name] = this.value;
        });
        result['optional_info'] = myCheckboxes;

        console.log( result);
        
    });*/

    /**
     * Manage radio button
     */
     $('input[type=radio]').on('change', function() {
        switch ($(this).val()) {
          case 'me':
            $("#otherSsurfer").hide();
            $("#other_surfer").val("");
            break;
          case 'other':
            $("#otherSsurfer").show();
            $("#other_surfer").val("");
            break;
        case 'unknown':
            $("#otherSsurfer").hide();
            $("#other_surfer").val("");
            break;
        default:
            $("#otherSsurfer").hide();
            $("#other_surfer").val("");
        }
      });

       
});