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

});

/**
 * remove message after time set hit
 */
function myTimerUserMessage() {
	document.getElementById('error').innerHTML = '';
	document.getElementById("error").className = '';
}