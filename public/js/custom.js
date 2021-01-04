$(document).ready(function () {
	var csrf_token = $('meta[name="csrf-token"]').attr("content");

	/*$('#login').click(function (event) {		
		var email = $('#email').val();
		var password = $('#password').val();
		if(email && password){
			spinner.show();
		}
	});*/
	/************** country and phone field onload register ****************************/

	$('#register .country option:selected').prop("selected", false);
	$('#register .phone').val('');

	/************** spiner code ****************************/
    var stopSpiner = "{{ $spiner}}";
    
    // var spinner = $('#loader');
    
	var spinner = $(".loaderWrap");

	$("#next").click(function (event) {
		spinner.show();
	});

	// $("#next1").click(function (event) {
	// 	spinner.show();
	// });

	/**
	hide spiner
	*/
	if (stopSpiner) {
		spinner.hide();
	}
	/************** end spiner code ****************************/

	/** Phone Code  */
	$(".country").change(function (e) {
		var phone_code = $('option:selected', this).data("phone");
		if (phone_code != '') {
			$(".phone").val(phone_code);
			// set phone code to phone input
		} else {
			$(".phone").val('');
			// remove phone code to phone input
		}
	});




	/**************************************************************************************
	 *                     set image preview after selection and crop befor update
	 ***************************************************************************************/
	$("#exampleInputFile").change(function () {
		readURL(this);
    });
    
    var $image_crop;
    $image_crop = $('#image').croppie({
        enableExif: true,
        enableOrientation: true,
		viewport: {
			width: 200,
			height: 200,
			type: 'square'
		},
		boundary: {
			width: 300,
			height: 300
		}
    });
    
	function readURL(input) {
     
		var url = input.value;
		var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
		if (
			input.files &&
			input.files[0] &&
			(ext == "png" || ext == "jpeg" || ext == "jpg")
		) {
			$("#imageError").hide();
            var reader = new FileReader();          
			reader.onload = function (e) {                  
				$image_crop.croppie('bind', {
					url: e.target.result
				}).then(function (blob) {
                   // console.log(blob);               
				 });			
			};
            reader.readAsDataURL(input.files[0]);     
		    $('#myModal').modal('show');
			$("#remove-img").show();
		} else {
			$('#imagebase64').val("");
			$("#exampleInputFile").val("");
			$("#category-img-tag").attr("src", "/img/image-file.png");
			$("#category-img-tag").attr("width", "auto");
			$("#remove-img").hide();
			$("#imageError").show();
		}
    }
       
	$('.crop_image').click(function (event) {
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (response) {
            $('#imagebase64').val(response);
			$("#category-img-tag").attr("src", response);
			$("#category-img-tag").attr("width", "90px");
			$('#myModal').modal('hide');
		})
	});
  
	/**
	 * Model Cancle 
	 */
	$(".close").click(function () {
		$('#imagebase64').val("");
		$("#exampleInputFile").val("");
		$("#category-img-tag").attr("src", "");
		$("#category-img-tag").attr("src", "img/image-file.png");
		$("#category-img-tag").attr("width", "auto");
		$("#remove-img").hide();
	});

	/**
	 * Reset Image
	 */
	$("#remove-img").click(function () {
		$('#imagebase64').val("");
		$("#exampleInputFile").val("");
		$("#category-img-tag").attr("src", "");
		$("#category-img-tag").attr("src", "img/image-file.png");
		$("#category-img-tag").attr("width", "auto");
		$("#remove-img").hide();
	});

	/**************************************************************************************
	 *                    Profile Image
	 ***************************************************************************************/
	$("#exampleInputProfileFile").change(function () {
		readProfileURL(this);
	});
	
	$("#myButton").click(function() {
		$('#exampleInputProfileFile').click();
	});

	function readProfileURL(input) {
		var url = input.value;
		var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
		if (
			input.files &&
			input.files[0] &&
			(ext == "png" || ext == "jpeg" || ext == "jpg")
		) {
			$("#imageError").hide();
            var reader = new FileReader();          
			reader.onload = function (e) {                  
				$image_crop.croppie('bind', {
					url: e.target.result
				}).then(function (blob) {
                   // console.log(blob);               
				 });			
			};
            reader.readAsDataURL(input.files[0]);     
		    $('#myModal').modal('show');
		} else {			
			$("#imageError").show();
		}
    }

	/**
	 * Update user profile using ajax
	 */
	$('.crop_profile_image').click(function (event) {
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (response) {
			var id = $("#user-id").data("userid");//$(this).data("userid");
			console.log(id);
            $('#imagebase64').val(response);
			$("#category-img-tag").attr("src", response);
			$("#category-img-tag").attr("width", "auto");
			$('#myModal').modal('hide');
			spinner.show();
			$.ajax({
				type: "POST",
				url: "/updateProfile",
				data: {				
					image: response,
					userId:id,
					_token: csrf_token
				},
				dataType: "json",
				success: function (jsonResponse) {
					if (jsonResponse.status == "success") {
						spinner.hide();
						$("#head").load(location.href+" #head>*","");
						document.getElementById("error").innerHTML = jsonResponse.message;
						document.getElementById("error").className ="alert alert-success";
					} else {
						spinner.hide();
						$("#head").load(location.href+" #head>*","");
						document.getElementById("error").innerHTML = jsonResponse.message;
						document.getElementById("error").className = "alert alert-danger";
					}
					setInterval(myTimerUserMessage, 4000);
				}
			});
		})
	});

	/*******************************************************************************************************
	 * 									Register Page validation submit
	 *
	 ********************************************************************************************************/

	$.validator.addMethod("pwcheck", function (value) {
		return (
			/[\@\#\$\%\^\&\*\(\)\_\+\!]/.test(value) &&
			/[a-z]/.test(value) &&
			/[0-9]/.test(value) &&
			/[A-Z]/.test(value)
		);
	});
	// no space allow in text box
	$.validator.addMethod(
		"noSpace",
		function (value, element) {
			return value == "" || value.trim().length != 0;
		},
		"No space please and don't leave it empty"
	);

	// valid email format
	$.validator.addMethod(
		"validEmailFormat",
		function (email) {
			var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
			return testEmail.test(email);
		},
		"Please enter valid email with valid format"
	);
	// NO SPACE ALLOW IN USER NAME
	$.validator.addMethod(
		"spaceNotAllow",
		function (value) {
			var regexp = /^([A-z0-9!@#$%^&*().,<>{}[\]<>?_=+\-|;:\'\"\/])*[^\s]\1*$/;
			return regexp.test(value);
		},
		"No space are allowed in user name"
	);

	// only number allowed
	$.validator.addMethod(
		"numericOnly",
		function (value) {
			// return /^[0-9]*$/.test(value);
			 return /^[0-9 +-]+$/.test(value);
			// return this.optional(element) || value == value.match(/^[\d+ ]*$/);
		},
		"Please only enter numeric values (0-9) and +-"
	);

	$("form[name='register']").validate({
		rules: {
			first_name: {
				required: true,
				minlength: 3,
				noSpace: true
			},

			last_name: {
				required: false,
				minlength: 3,
				noSpace: true
			},

			user_name: {
				required: true,
				minlength: 5,
				noSpace: true,
				spaceNotAllow: true
			},

			email: {
				required: true,
				email: true,
				validEmailFormat: true
			},

			phone: {
				noSpace: true,
				required: true,
				minlength: 8,
				maxlength: 15,
				spaceNotAllow: true,
				numericOnly: true
			},

			country_id: {
				required: true
			},

			language: {
				required: true
			},
			account_type: {
				required: true
			},

			local_beach_break: {
				required: true
			},

			password: {
				minlength: 8,
				required: true,
				pwcheck: true
			},

			password_confirmation: {
				minlength: 8,
				required: true,
				pwcheck: true,
				equalTo: "#password"
			},

			terms: {
				required: true
			}
		},
		errorPlacement: function (error, element) {
			if (element.is(":radio")) {			
				error.insertAfter(element.parent().parent());
			} else {
				// This is the default behavior of the script for all fields
				error.insertAfter(element.parent());
			}
		},
		messages: {
			first_name: {
				required: "Please enter your first name",
				minlength: "Your first name must be at least 3 characters long."
			},

			last_name: {
				required: "Please enter your last name",
				minlength: "Your last name must be at least 3 characters long."
			},

			user_name: {
				required: "Please enter your user name",
				minlength: "Your user name must be at least 5 characters long."
			},

			email: {
				required: "Please enter your email",
				email: "Please enter valid email address"
			},

			phone: {
				required: "Please enter your phone number",
				minlength: "Your phone must be minimun 8 number long.",
				maxlength: "Your phone must be maximum 15 number long."
			},

			country_id: {
				required: "Please select your country"
			},

			language: {
				required: "Please select your language"
			},

			account_type: {
				required: "Please select your account type"
			},

			local_beach_break: {
				required: "Please enter beach break"
			},

			password: {
				required: "Please enter your password",
				pwcheck: "The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
			},

			password_confirmation: {
				required: "Please enter your confirmation password",
				pwcheck: "The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
			},

			terms: {
				required: "Please select terms and conditions"
			}
		},
		submitHandler: function (form) {
			form.submit();
		}
	});

	// Login Validation
	$("form[name='login']").validate({
		rules: {
			email: {
				required: true
			},
			password: {
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
			email: {
				required: "Please enter your email / username"
			},
			password: {
				required: "Please enter your password"
			}
		},
		submitHandler: function (form) {
			form.submit();
			spinner.show();
		}
	});

	// forgot password
	$("form[name='forgot_password']").validate({
		rules: {
			email: {
				required: true,
				validEmailFormat: true
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
			email: {
				required: "Please enter valid email "
			}
		},
		submitHandler: function (form) {
			form.submit();
			spinner.show();
		}
	});

	// reset password
	$("form[name='reset_password']").validate({
		rules: {
			email: {
				required: true,
				validEmailFormat: true
			},
			password: {
				minlength: 8,
				required: true,
				pwcheck: true
			},
			password_confirmation: {
				minlength: 8,
				required: true,
				pwcheck: true,
				equalTo: "#password"
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
			email: {
				required: "Please enter valid email "
			},
			password: {
				required: "Please enter your password",
				pwcheck: "The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
			},
			password_confirmation: {
				required: "Please enter your confirm password",
				pwcheck: "The confirm password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
			}
		},
		submitHandler: function (form) {
			form.submit();
			spinner.show();
		}
	});

	// reset password
	$("form[name='update_password']").validate({
		rules: {
			current_password: {
				required: true
			},

			password: {
				minlength: 8,
				required: true,
				pwcheck: true
			},

			password_confirmation: {
				minlength: 8,
				required: true,
				pwcheck: true,
				equalTo: "#password"
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
			current_password: {
				required: "Please enter your current password "
			},
			password: {
				required: "Please enter your new password",
				pwcheck: "The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
			},
			password_confirmation: {
				required: "Please enter your confirm password",
				pwcheck: "The confirm password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
			}
		},
		submitHandler: function (form) {
			form.submit();
			spinner.show();
		}
	});

    // update profile
	$("form[name='update_profile']").validate({			
		rules: {
			first_name: {
				required: true,
				minlength: 3,
				noSpace: true
			},

			last_name: {
				required: true,
				minlength: 3,
				noSpace: true
			},

			user_name: {
				required: true,
				minlength: 5,
				noSpace: true,
				spaceNotAllow: true
			},

			email: {
				required: true,
				email: true,
				validEmailFormat: true
			},

			phone: {
				// noSpace: true,
				required: true,
				minlength: 8,
				maxlength: 15,
				// spaceNotAllow: true,
				numericOnly: true
			},

			country_id: {
				required: true
			},

			language: {
				required: true
			},

			account_type: {
				required: true
			},

			local_beach_break: {
				required: true
			}
		},
		errorPlacement: function (error, element) {
			if (element.is(":radio")) {
				error.insertAfter(element.parent().parent());
			} else {
				// This is the default behavior of the script for all fields
				error.insertAfter(element.parent());
			}
		},
		messages: {
			first_name: {
				required: "Please enter your first name",
				minlength: "Your first name must be at least 3 characters long."
			},

			last_name: {
				required: "Please enter your last name",
				minlength: "Your last name must be at least 3 characters long."
			},

			user_name: {
				required: "Please enter your user name",
				minlength: "Your user name must be at least 5 characters long."
			},

			email: {
				required: "Please enter your email",
				email: "Please enter valid email address"
			},

			phone: {
				required: "Please enter your phone number",
				minlength: "Your phone must be minimun 8 number long.",
				maxlength: "Your phone must be maximum 15 number long."
			},

			country_id: {
				required: "Please select your country"
			},

			language: {
				required: "Please select your language"
			},

			account_type: {
				required: "Please select your account type"
			},

			local_beach_break: {
				required: "Please enter beach break"
			}
		},
		submitHandler: function (form) {
			form.submit();
			spinner.show();
		}
	});

	$('form input[type=text]').focus(function () {
		// get selected input error container
		$(this).siblings(".text-danger").hide();		
	});

	/**
	* Execute a function given a delay time
	* 
	* @param {type} func
	* @param {type} wait
	* @param {type} immediate
	* @returns {Function}
	*/
	var debounce = function (func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
					timeout = null;
					if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};
	
	
	$('.search-box').keyup(debounce(function(){
		// the following function will be executed every half second	
	
		if($(this).val().length > 2){
		
			$.ajax({
				type: "GET",
				url: "/getBeachBreach",
				data: {				
					searchTerm: $(this).val(),
					_token: csrf_token
				},
				dataType: "json",
				success: function (jsonResponse) {
				
					$('#country_list').html(jsonResponse);
				}
			})
			
		}else{
			$('#local_beach_break_id').val('');
			$('#country_list').html("");
		}

   },100)); // Milliseconds in which the ajax call should be executed (500 = half second)
	
 
	 $(document).on('click', '.search1 li', function(){
		 var value = $(this).text();
		 var dataId = $(this).attr("data-id");
		 $('#country_list').html("");
		 $('.search-box').val(value);
		 $('#local_beach_break_id').val(dataId);
		 $('#country_list').html("");
	 });



	
	$('.other_surfer').keyup(debounce(function(){
		// the following function will be executed every half second	
	
		if($(this).val().length > 1){
			$.ajax({
				type: "GET",
				url: "/getUsers",
				data: {				
					searchTerm: $(this).val(),
					_token: csrf_token
				},
				dataType: "json",
				success: function (jsonResponse) {
				
					$('#other_surfer_list').html(jsonResponse);
				}
			})
		}else{
			$('#surfer_id').val('');
			$('#other_surfer_list').html("");
		}

   },100)); // Milliseconds in which the ajax call should be executed (100 = half second)


        $(document).on('click','.search2 li', function(){
		var value = $(this).text();
		var dataId = $(this).attr("data-id");
		$('#other_surfer_list').html("");
		$('.other_surfer').val(value);
		$('#surfer_id').val(dataId);
		$('#other_surfer_list').html("");
		$('input[name="surfer"]').val(value);
	});

	
		var other=$('input[name="other_surfer"]').val();
		if(other=='Me'){
			$('input[name="other_surfer"]').val('');
		}
		else if(other=='Unknown'){
			$('input[name="other_surfer"]').val('');
		}
		else {
			$("#othersSurfer").show();
			$('input[name="surfer"][value="Others"]').prop("checked", true);
		}



	/**
	 * State Baded on the selection on country
	 */

	$(document).on('change', '#country_id', function (e) {    
        var currentcountryValue = $(this).val();
        if (currentcountryValue != 0) {
           $.ajax({
              type: "GET",
              url:'/getState',
              data: {
				 country_id: currentcountryValue,
                 _token: csrf_token
              },
              dataType: "json",
              success: function (jsonResponse) {
                 //console.log(jsonResponse);
                 if (jsonResponse.status == 'success') {
                    $("#state_id").empty();
                    var myJsonData = jsonResponse.data;
                    $("#state_id").append('<option value="">--Select--</option>');
                    $.each(myJsonData, function (key, value) {
                       $("#state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                 } else {
                    $("#state_id").empty();
                 }
              }
           });
        } else {
           $("#state_id").empty();          
        }
	 });
	 

	
});

//To select country name
function selectCountry(val) {
	$("#search-box").val(val);
	$("#suggesstion-box").hide();
	}
/**
 * remove message after time set hit
 */
function myTimerUserMessage() {
	document.getElementById("error").innerHTML = "";
	document.getElementById("error").className = "";
}