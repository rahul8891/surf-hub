$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

	/*$('#login').click(function (event) {		
		var email = $('#email').val();
		var password = $('#password').val();
		if(email && password){
			spinner.show();
		}
	});*/	
	
	/************** spiner code ****************************/
	var stopSpiner = "{{ $spiner}}";
	// var spinner = $('#loader');
	var spinner = $('.loaderWrap');

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
	$("#exampleInputFile").change(function () {
		readURL(this);
	});

	function readURL(input) {
		var url = input.value;
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
			$('#imageError').hide();
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#category-img-tag').attr('src', e.target.result);
				$('#category-img-tag').attr('width', '80px');
			}
			$('#remove-img').show();
			reader.readAsDataURL(input.files[0]);
		} else {
			$("#exampleInputFile").val('');
			$('#category-img-tag').attr('src', '/img/image-file.png');
			$('#category-img-tag').attr('width', 'auto'); 
			$('#remove-img').hide();
            $('#imageError').show();  
                 
			
		}
	}

	/**
	 * Reset Image
	 */
	$("#remove-img").click(function () {
		$("#exampleInputFile").val('');
		$('#category-img-tag').attr('src','');
		$('#category-img-tag').attr('src', 'img/image-file.png');
		$('#category-img-tag').attr('width', 'auto');
		$('#remove-img').hide();
	});


	/************************************************************
	 *              Admin Update user status
	 ***********************************************************/
	$('.changeStatus').on('switchChange.bootstrapSwitch', function (e, data) {
		var currentStatus = data;
		var userId = $(this).data("id");
		spinner.show();
		$.ajax({
			type: "POST",
			url: 'updateUserStatus',
			data: {
				user_id: userId,
				status: currentStatus,
				_token: csrf_token
			},
			dataType: 'json',
			success: function (jsonResponse) {
				if (jsonResponse.status == 'success') {
					spinner.hide();
					document.getElementById('error').innerHTML = jsonResponse.message;
					document.getElementById("error").className = "alert alert-success";
				} else {
					spinner.hide();
					document.getElementById('error').innerHTML = jsonResponse.message;
					document.getElementById("error").className = "alert alert-danger";
				}
				setInterval(myTimerUserMessage, 4000);
			}
		});
	});




	/*Page submit 
	*/

	$.validator.addMethod("pwcheck", function (value) {
		return /[\@\#\$\%\^\&\*\(\)\_\+\!]/.test(value) && /[a-z]/.test(value) && /[0-9]/.test(value) && /[A-Z]/.test(value)
	});

	$("form[name='register']").validate({
		rules: {
				 
		  first_name:{
			required: true,
			minlength: 3
		  },
		  last_name:{
			required: true,
			minlength: 3
		  },
		  user_name:{
			required: true,
			minlength: 5
		  },
		  email: {
			required: true,
			email: true
		  },
		  phone: {			
			required: true,
			minlength:10,
            maxlength:15
		  },
		  country_id:{
			required: true,
		  },
		  language:{
			required: true,
		  },	
		  account_type:{
			required: true,
		  },
		  local_beach_break_id:{
			required: true,
		  },
		   password : {
			minlength: 8,
			required: true,
			pwcheck: true
			},
			password_confirmation : {			
				minlength: 8,
				required: true,
				pwcheck: true,
				equalTo : "#password"
			},

		  terms:{
			required: true,
		  }
		  
		},
	   errorPlacement: function(error, element) {
			if ( element.is(":radio") ) {
				//alert('oj');
				error.insertAfter( element.parent().parent());
			}
			else { // This is the default behavior of the script for all fields
				error.insertAfter( element );
			}
		},
		messages: {				
		  first_name: {
			required: "Please enter your first name",
			minlength: "Your password must be at least 3 characters long."
		  },

		  last_name: {
			required: "Please enter your last name",
			minlength: "Your password must be at least 3 characters long."
		  },

		  user_name: {
			required: "Please enter your user name",
			minlength: "Your password must be at least 5 characters long."
		  },

		  email: {
			required: "Please enter your email",
			email: "Please enter valid email address"
		  },

		  phone: {
			required: "Please enter your phone number",
			minlength: "Your phone must be minimun 10 number long.",
			maxlength: "Your phone must be maximum 15 number long."
		  },

		  country_id:{
			required: "Please select your country",
		  },

		  language:{
			required: "Please select your language",
		  },
		  account_type:{
			required: "Please select your account type",
		  },

		  local_beach_break_id:{
			required: "Please select beach break",
		  },
		  password:{
			// The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character.
			required: "Please enter your password",
			pwcheck:"The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
		  },
		  password_confirmation:{
			// The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character.
			required: "Please enter your confirmation password",
			pwcheck:"The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character."
		  },

		  terms:{
			required: "Please select terms and conditions",
		  }
		 
		},
		submitHandler: function(form) {
		  form.submit();
		}
	  });
});

/**
 * remove message after time set hit
 */
function myTimerUserMessage() {
	document.getElementById('error').innerHTML = '';
	document.getElementById("error").className = '';
}