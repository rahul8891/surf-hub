$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');    
    /**
     * resetForm Form  validator on close 
     */
    $(".close").click(function (e) {
      var validator = $( "#postForm" ).validate();
      validator.resetForm();      
    });

    var base_url = window.location.origin;


    /**************************************************************************************
     *               Manage Image
     *************************************************************************************/    
    var dataImage = new Array();     

    $("#input_multifileSelect").change(function () {
      readImageURL(this);
    });

    function readImageURL(input) {
      var newFileList = Array.from(input.files);
      $.each(newFileList, function(index, img ) {
        var ext = img.name.substring(img.name.lastIndexOf(".") + 1).toLowerCase();
        if (img && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
          $("#imageError").hide();
          var f = newFileList[index]
          dataImage.push(input.files[index]);
          // dataImage[index] = newFileList[index];
          reader = new FileReader();
            reader.onload = (function (e) {
              var file = e.target;
                $("<span class=\"pip\">" +
                "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\" data-index=\""+index+"\"><img src=\""+base_url+"\/img/close.png\" id=\"remove\" style=\"margin: -4px;position: absolute;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                "</span>").insertAfter("#filesInfo");
                $(".remove").click(function(){                
                  var indexRemoved = $(this).data('index');
                  dataImage.splice(indexRemoved,1); 
                  $(this).parent(".pip").remove();
                                
                });
                  /*return function (evt) {
                  var div = document.createElement('div');
                  div.className = 'pip';
                  div.innerHTML = '<img style="width: 50px;" src="' + evt.target.result + '" /><span id="remove-img" class="removeImg"><img src="http://127.0.0.1:8000/img/close.png" id="remove" data-index="'+index+'" style="margin: -13px;position: absolute;top: 187px;cursor: pointer;" width="14px" alt=""></span>';                    
                  document.getElementById('filesInfo').appendChild(div);
                  $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                  });
              };*/
          });
          reader.readAsDataURL(f);
        }else{
           // REMOVE IMAGE INDEX IF NOT IMAGE 
           newFileList.splice(index);
        }
        if(newFileList.length == 0){
          $("#imageError").show();
        }

      });
      
    /*  newFileList = Array.from(input.files);
      $.each(newFileList, function(index, img ) {     
      var ext = img.name.substring(img.name.lastIndexOf(".") + 1).toLowerCase();
        if (img && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
          $("#imageError").hide();
          dataImage[index] = img;
          reader = new FileReader();
            reader.onload = (function (tFile) {
                return function (evt) {
                    var div = document.createElement('div');
                    div.innerHTML = '<img style="width: 50px;" src="' + evt.target.result + '" /><span id="remove-img" class="removeImg"><img src="http://127.0.0.1:8000/img/close.png" id="img-remove" data-index="'+index+'" style="margin: -13px;position: absolute;top: 187px;cursor: pointer;" width="14px" alt=""></span>';                    
                    document.getElementById('filesInfo').appendChild(div);
                };
            }(img));
            reader.readAsDataURL(img);
        }else{
          // REMOVE IMAGE INDEX IF NOT IMAGE 
          newFileList.splice(index);
        }     
        if(newFileList.length == 0){
          $("#imageError").show();
          $('#imagebase64Multi').val('');
        }
        $('#imagebase64Multi').val(newFileList);
      });  */    
    }     

    /*************************************************************************************/ 




    /**
     * Validate post form befor submit
     */
    $("form[name='postForm']").validate({			
      rules: {
        post_type: {
          required: true,        
        },
  
        post_text: {
          required: false,         
        },
  
        surf_date: {
          required: false,        
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

        console.log(dataImage);
        
        var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function(){
          return $(this).val();
        }).get();

        var result = {};
        
        $.each($('form').serializeArray(), function() {
            result[this.name] = this.value;
        });

        result['optional'] = myCheckboxes;       
        $.ajax({
          type: "POST",
          url: "/create-post",
          data: {				
             formData: result,
            _token: csrf_token
          },
          dataType: "json",
          success: function (jsonResponse) {
            postResult(jsonResponse);
           // console.log(jsonResponse);
          }
        })
      }
    });

    function postResult (jsonResponse) {
      if($.isEmptyObject(jsonResponse.error)){
          $('.alert-block').css('display','block').append('<strong>'+jsonResponse.success+'</strong>');
      }else{     
        $.each( jsonResponse.error, function( key, value ) {        
          $(document).find('[name='+key+']').after('<lable class="text-strong textdanger error">' +value+ '</lable>');
        });
      }
    }

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