$(document).ready(function () {
  var csrf_token = $('meta[name="csrf-token"]').attr('content');

  /**
   * resetForm Form  validator on close     
   * remove image preview on close (pip)
   */

  $("#file_button").click(function(){
    $("input[name='files[]']").trigger("click");
  });

  $("#video_button").click(function(){
    $("input[name='videos[]']").trigger("click");
  });

  $("input[name='files[]']").on("change", function() {
    if (parseInt($("input[name='files[]']").get(0).files.length) > 10) {
        alert("You can select only 10 images");
        $(this).val('');
      }
  });

  $("input[name='videos[]']").on("change", function() {
    if (parseInt($("input[name='videos[]']").get(0).files.length) > 10) {
        alert("You can select only 10 videos");
        $(this).val('');
      }
  });


  $(".close").click(function (e) {
    var validator = $("#postForm").validate();
    validator.resetForm();
    $('.pip').remove();
  });

  // get application base url
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
    $.each(newFileList, function (index, img) {
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
            "<br/><span class=\"remove\" data-index=\"" + index + "\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: -7px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
            "</span>").insertAfter("#filesInfo");
          $(".remove").click(function () {
            var indexRemoved = $(this).data('index');
            dataImage.splice(indexRemoved, 1);
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
      } else {
        // REMOVE IMAGE INDEX IF NOT IMAGE 
        newFileList.splice(index);
      }
      if (newFileList.length == 0) {
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
        required: false
      },

      board_type: {
        required: true
      },

      surfer: {
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

      surfer: {
        required: "Please select surfer"
      }

    },
    submitHandler: function (form, e) {
      spinner.show();  
      form.submit();     
      // Manage Form Data        
      // let formData = new FormData(form);
      e.preventDefault();

      // var d = $('#files')[0].files[0]

      var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function () {
        return $(this).val();
      }).get();

      var files = new Array();
      files = $('input[name="files[]"]').map(function(){
        return $(this).val();
      }).get();

      console.log(files);

      var result = {};
      
      var files = {};

      // Updated part
      /*$.each(jQuery('#files')[0].files, function(i, file) {
        data.append('file-'+i, file);
      });*/

      $.each($('form').serializeArray(), function () {
        result[this.name] = this.value;
      });

      var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function () {
        return $(this).val();
      }).get();

     // console.log(dataImage);
      result['optional'] = myCheckboxes;

      $.each(dataImage, function(i, file) {
        result['file-'+i, file]
       // files[i] = file;
       // data.append('file-'+i, file);
      });
      console.log(result);

      // result.push({'files':dataImage});

      $.ajax({
        type: "POST",
        url: "/create-post",
        enctype: 'multipart/form-data',
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

  function postResult(jsonResponse) {
    if ($.isEmptyObject(jsonResponse.error)) {
      $('.alert-block').css('display', 'block').append('<strong>' + jsonResponse.success + '</strong>');
    } else {
      $.each(jsonResponse.error, function (key, value) {
        $(document).find('[name=' + key + ']').after('<lable class="text-strong textdanger error">' + value + '</lable>');
      });
    }
  }

  /**
   * Manage radio button
   */
  $('input[type=radio]').on('change', function () {
    switch ($(this).val()) {
      case 'Me':
        $("#othersSurfer").hide();
        $("#other_surfer").val("");
        break;
      case 'Others':
        $("#othersSurfer").show();
        $("#other_surfer").val("");
        break;
      case 'Unknown':
        $("#othersSurfer").hide();
        $("#other_surfer").val("");
        break;
      default:
        $("#othersSurfer").hide();
        $("#other_surfer").val("");
    }
  });


});