jQuery(document).ready(function () {
    var csrf_token = jQuery('meta[name="csrf-token"]').attr("content");

    /*jQuery('#login').click(function (event) {
     var email = jQuery('#email').val();
     var password = jQuery('#password').val();
     if(email && password){
     spinner.show();
     }
     });*/
    /************** country and phone field onload register ****************************/

    jQuery('#register .country option:selected').prop("selected", false);
    jQuery('#register .phone').val('');




    /************** spiner code ****************************/
    var stopSpiner = "{{ $spiner}}";

    // var spinner = jQuery('#loader');

    var spinner = jQuery(".loaderWrap");

    jQuery("#next").click(function (event) {
        spinner.show();
    });

    // jQuery("#next1").click(function (event) {
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
    jQuery(".country").change(function (e) {
        var phone_code = jQuery('option:selected', this).data("phone");
        if (phone_code != '') {
            jQuery(".phone").val(phone_code);
            // set phone code to phone input
        } else {
            jQuery(".phone").val('');
            // remove phone code to phone input
        }
    });




    /**************************************************************************************
     *                     set image preview after selection and crop befor update
     ***************************************************************************************/
    jQuery("#exampleInputFile").change(function () {
        readURL(this);
    });
    jQuery("form[name='register-surfer'] #exampleInputFile").change(function () {
        readURL(this);
    });
    jQuery("form[name='register-resort'] #exampleInputFile").change(function () {
        readURL(this);
    });
    jQuery("form[name='register-advertiser'] #exampleInputFile").change(function () {
        readURL(this);
    });


    var $image_crop;
    $image_crop = jQuery('#image').croppie({
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
            jQuery("#imageError").hide();
            var reader = new FileReader();
            reader.onload = function (e) {
                $image_crop.croppie('bind', {
                    url: e.target.result
                }).then(function (blob) {
                    // console.log(blob);
                });
            };
            reader.readAsDataURL(input.files[0]);
            jQuery('#myModal').modal('show');
            jQuery("#remove-img").show();
            jQuery("form[name='register-surfer'] #remove-img").show();
            jQuery("form[name='register-resort'] #remove-img").show();
            jQuery("form[name='register-advertiser'] #remove-img").show();
        } else {
            jQuery('#imagebase64').val("");
            jQuery("form[name='register-surfer'] #imagebase64").val("");
            jQuery("form[name='register-resort'] #imagebase64").val("");
            jQuery("form[name='register-advertiser'] #imagebase64").val("");
            jQuery("#exampleInputFile").val("");
            jQuery("form[name='register-surfer'] #exampleInputFile").val("");
            jQuery("form[name='register-resort'] #exampleInputFile").val("");
            jQuery("form[name='register-advertiser'] #exampleInputFile").val("");

            jQuery("#category-img-tag").attr("src", "/img/image-file.png");
            jQuery("#category-img-tag").attr("width", "auto");


            jQuery("form[name='register-surfer'] #category-img-tag").attr("src", "/img/image-file.png");
            jQuery("form[name='register-surfer'] #category-img-tag").attr("width", "auto");

            jQuery("form[name='register-resort'] #category-img-tag").attr("src", "/img/image-file.png");
            jQuery("form[name='register-resort'] #category-img-tag").attr("width", "auto");

            jQuery("form[name='register-advertiser'] #category-img-tag").attr("src", "/img/image-file.png");
            jQuery("form[name='register-advertiser'] #category-img-tag").attr("width", "auto");

            jQuery("#remove-img").hide();
            jQuery("#imageError").show();
            jQuery("form[name='register-surfer'] #remove-img").hide();
            jQuery("form[name='register-resort'] #remove-img").hide();
            jQuery("form[name='register-advertiser'] #remove-img").hide();
            jQuery("form[name='register-surfer'] #imageError").show();
            jQuery("form[name='register-resort'] #imageError").show();
            jQuery("form[name='register-advertiser'] #imageError").show();
        }
    }

    jQuery('.crop_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            jQuery('#imagebase64').val(response);
            jQuery("form[name='register-surfer'] #imagebase64").val(response);
            jQuery("form[name='register-resort'] #imagebase64").val(response);
            jQuery("form[name='register-advertiser'] #imagebase64").val(response);
            jQuery("#category-img-tag").attr("src", response);
            jQuery("#category-img-tag").attr("width", "100%");

            jQuery("form[name='register-surfer'] #category-img-tag").attr("src", response);
            jQuery("form[name='register-surfer'] #category-img-tag").attr("width", "100%");

            jQuery("form[name='register-resort'] #category-img-tag").attr("src", response);
            jQuery("form[name='register-resort'] #category-img-tag").attr("width", "100%");

            jQuery("form[name='register-advertiser'] #category-img-tag").attr("src", response);
            jQuery("form[name='register-advertiser'] #category-img-tag").attr("width", "100%");

            jQuery('#myModal').modal('hide');
        })
    });

    /**
     * Model Cancle
     */
    jQuery(".close").click(function () {
        jQuery('#imagebase64').val("");
        jQuery("form[name='register-surfer'] #imagebase64").val("");
        jQuery("form[name='register-resort'] #imagebase64").val("");
        jQuery("form[name='register-advertiser'] #imagebase64").val("");
        jQuery("#exampleInputFile").val("");
        jQuery("form[name='register-surfer'] #exampleInputFile").val("");
        jQuery("form[name='register-resort'] #exampleInputFile").val("");
        jQuery("form[name='register-advertiser'] #exampleInputFile").val("");
        jQuery("#category-img-tag").attr("src", "");
        jQuery("#category-img-tag").attr("src", "img/image-file.png");
        jQuery("#category-img-tag").attr("width", "auto");
        jQuery("#remove-img").hide();
    });

    /**
     * Reset Image
     */
    jQuery("#remove-img").click(function () {
        jQuery('#imagebase64').val("");
        jQuery("#exampleInputFile").val("");
        jQuery("#category-img-tag").attr("src", "");
        jQuery("#category-img-tag").attr("src", "img/image-file.png");
        jQuery("#category-img-tag").attr("width", "auto");
        jQuery("#remove-img").hide();
    });

    /**************************************************************************************
     *                    Profile Image
     ***************************************************************************************/
    jQuery("#exampleInputProfileFile").change(function () {
        readProfileURL(this);
    });

    jQuery("#myButton").click(function () {
        jQuery('#exampleInputProfileFile').click();
    });

    function readProfileURL(input) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
        if (
                input.files &&
                input.files[0] &&
                (ext == "png" || ext == "jpeg" || ext == "jpg")
                ) {
            jQuery("#imageError").hide();
            var reader = new FileReader();
            reader.onload = function (e) {
                $image_crop.croppie('bind', {
                    url: e.target.result
                }).then(function (blob) {
                    // console.log(blob);
                });
            };
            reader.readAsDataURL(input.files[0]);
            jQuery('#myModal').modal('show');
        } else {
            jQuery("#imageError").show();
        }
    }

    /**
     * Update user profile using ajax
     */
    jQuery('.crop_profile_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            var id = jQuery("#user-id").data("userid");//jQuery(this).data("userid");
            console.log(id);
            jQuery('#imagebase64').val(response);
            jQuery("#category-img-tag").attr("src", response);
            jQuery("#category-img-tag").attr("width", "auto");
            jQuery('#myModal').modal('hide');
            spinner.show();
            jQuery.ajax({
                type: "POST",
                url: "/updateProfile",
                data: {
                    image: response,
                    userId: id,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    if (jsonResponse.status == "success") {
                        spinner.hide();
                        jQuery("#head").load(location.href + " #head>*", "");
                        document.getElementById("error").innerHTML = jsonResponse.message;
                        document.getElementById("error").className = "alert alert-success";
                    } else {
                        spinner.hide();
                        jQuery("#head").load(location.href + " #head>*", "");
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

    jQuery.validator.addMethod("pwcheck", function (value) {
        return (
                /[\@\#\$\%\^\&\*\(\)\_\+\!]/.test(value) &&
                /[a-z]/.test(value) &&
                /[0-9]/.test(value) &&
                /[A-Z]/.test(value)
                );
    });
    // no space allow in text box
    jQuery.validator.addMethod(
            "noSpace",
            function (value, element) {
                return value == "" || value.trim().length != 0;
            },
            "No space please and don't leave it empty"
            );

    // valid email format
    jQuery.validator.addMethod(
            "validEmailFormat",
            function (email) {
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                return testEmail.test(email);
            },
            "Please enter valid email with valid format"
            );
    // NO SPACE ALLOW IN USER NAME
    jQuery.validator.addMethod(
            "spaceNotAllow",
            function (value) {
                var regexp = /^([A-z0-9!@#$%^&*().,<>{}[\]<>?_=+\-|;:\'\"\/])*[^\s]\1*$/;
                return regexp.test(value);
            },
            "No space are allowed"
            );

    // only number allowed
    jQuery.validator.addMethod(
            "numericOnly",
            function (value) {
                // return /^[0-9]*$/.test(value);
                return /^[0-9 +-]+$/.test(value);
                // return this.optional(element) || value == value.match(/^[\d+ ]*$/);
            },
            "Please only enter numeric values (0-9) and +-"
            );

    jQuery.validator.addMethod(
            "localBeachBreak",
            function (value) {
                return value != "";
            },
            "Please enter beack break"
            );

    jQuery.validator.addMethod(
            "newPwdCurrentPws",
            function (value) {
                if (value != jQuery('#current_password').val()) {
                    return value;
                }
            },
            "New password can not be same as current password"
            );

    jQuery("form[name='register']").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            last_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            user_name: {
                required: true,
                minlength: 5,
                noSpace: true,
                spaceNotAllow: true,
                remote: {
                    url: 'checkUsername',
                    type: "post",
                    data: {
                        _token: csrf_token
                    }
                }
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

            local_beach_break_id: {
                required: true
            },

            password: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true
            },

            password_confirmation: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true,
                equalTo: "#password"
            },

            local_beach_break: {
                localBeachBreak: true
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
                error.insertAfter(element);
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
                minlength: "Your user name must be at least 5 characters long.",
                remote: "User name already in use."
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

            local_beach_break_id: {
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

    jQuery("form[name='register-resort']").validate({
        rules: {
            resort_name: {
                required: true,
            },
            resort_type: {
                required: true,
            },
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            last_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            user_name: {
                required: true,
                minlength: 5,
                noSpace: true,
                spaceNotAllow: true,
                remote: {
                    url: 'checkUsername',
                    type: "post",
                    data: {
                        _token: csrf_token
                    }
                }
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
            local_beach_break_id: {
                required: true
            },

            password: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true
            },

            password_confirmation: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true,
                equalTo: "#password1"
            },

            local_beach_break: {
                localBeachBreak: true
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
                error.insertAfter(element);
            }
        },
        messages: {
            resort_name: {
                required: "Please enter resort name"
            },
            resort_type: {
                required: "Please select resort type"
            },
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
                minlength: "Your user name must be at least 5 characters long.",
                remote: "User name already in use."
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

            local_beach_break_id: {
                required: "Please enter beach"
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
            var input = document.getElementById('formFile');
            if (input.files.length > 4) {
                jQuery('.resort_pics_error').text('Please select only 5 pics');
                return false;
            } else {
                jQuery('.resort_pics_error').text('');
            }
            form.submit();
        }
    });



    jQuery("form[name='register-advertiser']").validate({
        rules: {
            company_name: {
                required: true,
            },
            industry: {
                required: true,
            },
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            last_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
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

            paypal: {
                required: true
            },

            password: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true
            },

            password_confirmation: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true,
                equalTo: "#password3"
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
                error.insertAfter(element);
            }
        },
        messages: {
            company_name: {
                required: "Please enter company name"
            },
            industry: {
                required: "Please select industry"
            },
            first_name: {
                required: "Please enter your first name",
                minlength: "Your first name must be at least 3 characters long."
            },

            last_name: {
                required: "Please enter your last name",
                minlength: "Your last name must be at least 3 characters long."
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

            paypal: {
                required: "Please enter your paypal ID"
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

    jQuery("form[name='register-surfer']").validate({
        rules: {
            gender: {
                required: true,
            },
            dob: {
                required: true,
            },
            profile_photo_name: {
                required: true
            },
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            last_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true,
                spaceNotAllow: true
            },

            user_name: {
                required: true,
                minlength: 5,
                noSpace: true,
                spaceNotAllow: true,
                remote: {
                    url: 'checkUsername',
                    type: "post",
                    data: {
                        _token: csrf_token
                    }
                }
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

            local_beach_break_id: {
                required: true
            },

            password: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true
            },

            password_confirmation: {
                minlength: 8,
                required: true,
                pwcheck: true,
                spaceNotAllow: true,
                equalTo: "#password2"
            },

            local_beach_break: {
                localBeachBreak: true
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
                error.insertAfter(element);
            }
        },
        messages: {
            gender: {
                required: "Please select your gender",
            },
            dob: {
                required: "Please enter your dob",
            },
            profile_photo_name: {
                required: "Please upload your picture",
            },
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
                minlength: "Your user name must be at least 5 characters long.",
                remote: "User name already in use."
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

            local_beach_break_id: {
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


//    jQuery('#formFile').change(function(){
//   //get the input and the file list
//   var input = document.getElementById('formFile');
//   if(input.files.length>4){
//       jQuery('.validation').css('display','block');
//   }else{
//       jQuery('.validation').css('display','none');
//   }
//});

    // Login Validation
    jQuery("form[name='login']").validate({
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
    jQuery("form[name='forgot_password']").validate({
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
    jQuery("form[name='reset_password']").validate({
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
    jQuery("form[name='update_password']").validate({
        rules: {
            current_password: {
                required: true
            },

            password: {
                minlength: 8,
                required: true,
                pwcheck: true,
                newPwdCurrentPws: true
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
    jQuery("form[name='update_profile']").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
                noSpace: true
            },

            last_name: {
                required: true,
                minlength: 3,
                maxlength: 15,
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

    jQuery('form input[type=text]').focus(function () {
        // get selected input error container
        jQuery(this).siblings(".text-danger").hide();
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
        return function () {
            var context = this, args = arguments;
            var later = function () {
                timeout = null;
                if (!immediate)
                    func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow)
                func.apply(context, args);
        };
    };

    // ajax form field data for post
    jQuery('.search-box').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 2) {
            jQuery.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#country_list').html(jsonResponse);
                }
            })

        } else {
            jQuery('#local_beach_break_id').val('');
            jQuery('#country_list').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    jQuery('#searchFollower').keyup(debounce(function () {
        // the following function will be executed every half second
        var user_id = jQuery('#user_id').val();
        var keyword = jQuery('#searchFollower').val();
//        if (jQuery(this).val().length > 2) {
        jQuery.ajax({
            type: "GET",
            url: "/searchFollwers/" + user_id,
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            jQuery('#local_beach_break_id').val('');
//            jQuery('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
    jQuery('#searchFollowing').keyup(debounce(function () {
        // the following function will be executed every half second
        var keyword = jQuery('#searchFollowing').val();
        var user_id = jQuery('#user_id').val();
//        if (jQuery(this).val().length > 2) {
        jQuery.ajax({
            type: "GET",
            url: "/searchFollowing/" + user_id,
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            jQuery('#local_beach_break_id').val('');
//            jQuery('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
    jQuery('#searchFollowRequest').keyup(debounce(function () {
        // the following function will be executed every half second
        var keyword = jQuery('#searchFollowRequest').val();
//        if (jQuery(this).val().length > 2) {
        jQuery.ajax({
            type: "GET",
            url: "/searchFollowRequest",
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            jQuery('#local_beach_break_id').val('');
//            jQuery('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    jQuery('.search-box4').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 2) {
            jQuery.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#country_list4').html(jsonResponse);
                }
            })

        } else {
            jQuery('#local_beach_break_id_resort').val('');
            jQuery('#country_list4').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    jQuery('.search-box3').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 2) {
            jQuery.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#country_list3').html(jsonResponse);
                }
            })

        } else {
            jQuery('#local_beach_break_id_surfer').val('');
            jQuery('#country_list3').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    jQuery('.ad-search-box').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 2) {
            jQuery.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#beach_list').html(jsonResponse);
                }
            })

        } else {
            jQuery('#local_beach_id').val('');
            jQuery('#beach_list').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)


    jQuery(document).on('click', '#beach_list li', function () {
        var value = jQuery(this).text();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#beach_list').html("");
        jQuery('.ad-search-box').val(value);
        jQuery('#local_beach_id').val(dataId);
        jQuery('#beach_list').html("");
    });
    jQuery(document).on('click', '.search1 li', function () {
        var value = jQuery(this).text();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#country_list').html("");
        jQuery('.search-box').val(value);
        jQuery('#local_beach_break_id').val(dataId);
        getBreak(dataId);
        jQuery('#country_list').html("");
    });

    jQuery(document).on('click', '.search4 li', function () {
        var value = jQuery(this).text();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#country_list4').html("");
        jQuery('.search-box4').val(value);
        jQuery('#local_beach_break_id_resort').val(dataId);
        getBreak(dataId);
        jQuery('#country_list4').html("");
    });

    jQuery(document).on('click', '.search3 li', function () {
        var value = jQuery(this).text();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#country_list3').html("");
        jQuery('.search-box3').val(value);
        jQuery('#local_beach_break_id_surfer').val(dataId);
        getBreak(dataId);
        jQuery('#country_list3').html("");
    });

    jQuery(document).on('click', '.previewAds', function () {
//        alert('ggg');
        var form = jQuery('#storeAdvert').val();
        jQuery('#preview').val("1");
        form.submit();
    });


    function getBreak(beachValue) {
//        var beachValue = jQuery(this).val();
        if (beachValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getBreak',
                data: {
                    beach_id: beachValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#break_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#break_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            if (value.break_name != '') {
                                jQuery("#break_id").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                                jQuery("#break_id").rules("add", {required: true, messages: {required: "Break is required"}});

                            } else {
                                jQuery("#break_id").rules("remove");
                            }
                        });
                    } else {
                        jQuery("#break_id").empty();
                    }
                }
            });
        } else {
            jQuery("#state_id").empty();
        }
    }

//     jQuery("#beach_filter").change(function (e) {
// //    if (jQuery('#beach_filter').is(":selected")) {
//         jQuery('#break_filter').find('option').remove();
//         jQuery("#break_filter").append('<option value=""> -- Break --</option>');
//         var beachValue = jQuery(this).val();
//         jQuery.ajax({
//             type: "GET",
//             url: '/getBreak',
//             data: {
//                 beach_id: beachValue,
//                 _token: csrf_token
//             },
//             dataType: "json",
//             success: function (jsonResponse) {
//                 //console.log(jsonResponse);
//                 if (jsonResponse.status == 'success') {
//                     var myJsonData = jsonResponse.data;

//                     jQuery.each(myJsonData, function (key, value) {
//                         if (value.break_name != '') {
//                             jQuery("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
// //                            jQuery("#break_filter").append('<div class="cstm-check pos-rel break_rem'+beachValue+'"><input type="checkbox" id="break_' + value.id + '" name="filter_break_' + value.id + '" value="' + value.id + '" /><label for="break_' + value.id + '" class="width-138">' + value.break_name + '</label></div>');
//                         }
//                     });
//                 } else {
// //                    jQuery("#break_id").empty();
//                 }
//             }
//         });

// //        }
// //        alert("checked Score: " + jQuery(this).val());
// //    else {
// //        var beachValue = jQuery(this).val();
// ////        jQuery("#break_filter").remove();
// //    }
//     });

    /**
     * Get beach name typed by user and fetch data according to that
     */
    jQuery('#beach_filtername').on('keyup', function() {
        var beachValue = jQuery(this).val();
        //if ( beachValue.length > 3 ) {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: '/getBeachName',
                data: {
                    beach_name: beachValue,
                },
                dataType: "json",
                success: function (jsonResponse) {
                    // console.log(jsonResponse);

                    if (jsonResponse.status == 'success') {
                        var myJsonData = jsonResponse.data;
                        jQuery('#filter_beach_data').html(myJsonData);
                    }
                }
            });
        //}
    });

    /**
     * Replace first input by selecting beach name by user on list
     */
    jQuery(document).on('click', '.search2.beachlist li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#other_surfer_list').html("");
        jQuery('.other_beach').val(value);
        jQuery('#beach_id').val(dataId);
        jQuery('#filter_beach_data').html("");

        /** get all Break on the basis of Beach selected by user **/
        jQuery('#break_filter').find('option').remove();
        jQuery("#break_filter").append('<option value=""> -- Break --</option>');
        var beachValue = dataId;
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: '/getBreak',
            data: {
                beach_id: beachValue,
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == 'success') {
                    var myJsonData = jsonResponse.data;
                    jQuery.each(myJsonData, function (key, value) {
                        if (value.break_name != '') {
                            jQuery("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                        }
                    });
                }
            }
        });
    });

    /** Reset all form fields after submit manually **/
    jQuery('.filter-header #close').on('click', function() {
        jQuery("input[type=text]"). val("");
        jQuery("input[type=date]").val("");
        jQuery("#filter_country_id").find('option').attr('selected', false);
        jQuery("#break_filter").find('option').attr('selected', false);
        jQuery("#wave_size").find('option').attr('selected', false);
        jQuery("#board_type").find('option').attr('selected', false);
        jQuery('input[type=checkbox]').prop('checked', false);
    });


    jQuery("#board_type").change(function (e) {
//    if (jQuery('#beach_filter').is(":selected")) {
//        jQuery('#break_filter').find('option').remove();
//        jQuery("#break_filter").append('<option value=""> -- Break --</option>');
        var board_type = jQuery(this).val();
        if (board_type !== '') {
            jQuery.ajax({
                type: "GET",
                url: '/get-additional-board-info',
                data: {
                    board_type: board_type,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
//                if (jsonResponse.status == 'success') {
                    var myJsonData = jsonResponse.data;

                    jQuery('#additional_optional_info').removeClass('d-none');
                    jQuery('#additional_optional_info').html(jsonResponse);
//                } else {
//                    jQuery('#additional_optional_info').addClass('d-none');
//                }
                }
            });

        } else {
            jQuery('#additional_optional_info').addClass('d-none');
//        jQuery("#break_filter").remove();
        }
    });

    // ajax form field data for filter
    jQuery('.search-box2').keyup(debounce(function () {
        // the following function will be executed every half second

        if (jQuery(this).val().length > 2) {

            jQuery.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#country_list2').html(jsonResponse);
                }
            })

        } else {
            jQuery('#local_beach_break_id2').val('');
            jQuery('#country_list2').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    jQuery(document).on('click', '.searchTwo li', function () {
        var value = jQuery(this).text();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#country_list2').html("");
        jQuery('.search-box2').val(value);
        jQuery('#local_beach_break_id2').val(dataId);
        jQuery('#country_list2').html("");
    });




    jQuery('.other_surfer').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 1) {
            jQuery.ajax({
                type: "GET",
                url: "/getUsers",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    jQuery('#other_surfer_list').html(jsonResponse);
                }
            })
        } else {
            jQuery('#surfer_id').val('');
            jQuery('#other_surfer_list').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    jQuery(document).on('click', '.search2 li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#other_surfer_list').html("");
        jQuery('.other_surfer').val(value);
        jQuery('#surfer_id').val(dataId);
        jQuery('#other_surfer_list').html("");
    });

    jQuery(document).on('click', '#filter_other_surfer_data li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");

        jQuery('.filter_other_surfer').val(value);
        jQuery('#surfer_id_filter').val(dataId);
        jQuery('#filter_other_surfer_data').html("");
    });

    jQuery(document).on('click', '#filter_username_data li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");

        jQuery('.filter_username').val(value);
        jQuery('#username_id_filter').val(dataId);
        jQuery('#filter_username_data').html("");
    });


    jQuery('.filter_other_surfer').keyup(debounce(function () {
        // the following function will be executed every half second
        var userType = jQuery('#filter_user_type').val();

        if (jQuery(this).val().length > 1) {
            jQuery.ajax({
                type: "GET",
                url: "/getFilterUsers",
                data: {
                    user_type: userType,
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    jQuery('#filter_other_surfer_data').html(jsonResponse);
                }
            });
        } else {
            jQuery('#surfer_id_filter').val('');
            jQuery('#filter_other_surfer_data').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    jQuery('.filter_username').keyup(debounce(function () {
        // the following function will be executed every half second
        var userType = jQuery('#filter_user_type').val();

        if (jQuery(this).val().length > 1) {
            jQuery.ajax({
                type: "POST",
                url: "/getFilterUsernames",
                data: {
                    user_type: userType,
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    jQuery('#filter_username_data').html(jsonResponse);
                }
            });
        } else {
            jQuery('#username_id_filter').val('');
            jQuery('#filter_username_data').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)



    jQuery('.tag_user').keyup(debounce(function () {
        // the following function will be executed every half second

        var post_id = jQuery(this).attr('data-post_id');
        if (jQuery(this).val().length > 1) {
            jQuery.ajax({
                type: "GET",
                url: "/getTagUsers",
                data: {
                    post_id: post_id,
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#tag_user_list' + post_id).html(jsonResponse);
                }
            })
        } else {
            jQuery('#user_id').val('');
            jQuery('#tag_user_list' + post_id).html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)


    jQuery(document).on('click', '.tagSearch li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");
        var postId = jQuery(this).attr("data-post_id");
        //ajax call to insert data in tag table and also set notification
        jQuery.ajax({
            type: "POST",
            url: "/setTagUsers",
            data: {
                post_id: postId,
                user_id: dataId,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {

                if (jsonResponse.status == 'success') {
                    jQuery('#rowId' + dataId).hide();
                    //jQuery('#tag_user_list'+postId).html("");
                    jQuery('.tag_user').val(value);
                    jQuery('#user_id').val(dataId);
                    //jQuery('#tag_user_list'+postId).html("");
                    jQuery(".scrollWrap").empty();
                    jQuery('.scrollWrap').html(jsonResponse.responsData);
                } else {
                    alert(jsonResponse.message);
                }
                jQuery('#tag_user_list' + post_id).html(jsonResponse);
            }
        })
    });


    var other = jQuery('input[name="other_surfer"]').val();
    if (other == 'Me') {
        jQuery('input[name="other_surfer"]').val('');
    } else if (other == 'Unknown') {
        jQuery('input[name="other_surfer"]').val('');
    } else {
        jQuery("#othersSurfer").show();
        jQuery('input[name="surfer"][value="Others"]').prop("checked", true);
    }



    /**
     * State Baded on the selection on country
     */

    jQuery(document).on('change', '#country_id, #edit_country_id', function (e) {
        var currentcountryValue = jQuery(this).val();
        if (currentcountryValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getState',
                data: {
                    country_id: currentcountryValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            jQuery("#state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        jQuery("#state_id").empty();
                    }
                }
            });
        } else {
            jQuery("#state_id").empty();
        }
    });

    jQuery(document).on('change', '#search_country_id', function (e) {
        var currentcountryValue = jQuery(this).val();
        if (currentcountryValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getState',
                data: {
                    country_id: currentcountryValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#search_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#search_state_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            jQuery("#search_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        jQuery("#search_state_id").empty();
                    }
                }
            });
        } else {
            jQuery("#search_state_id").empty();
        }
    });



    /**
     * Filter State Baded on the selection on filter country
     */

    jQuery(document).on('change', '#filter_country_id, #edit_country_id', function (e) {
        var currentcountryValue = jQuery(this).val();
        if (currentcountryValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getState',
                data: {
                    country_id: currentcountryValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#filter_state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#filter_state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            jQuery("#filter_state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        jQuery("#filter_state_id").empty();
                    }
                }
            });
        } else {
            jQuery("#filter_state_id").empty();
        }
    });

    jQuery(document).on('click', '.unfollow', function () {
        var dataId = jQuery(this).attr("data-id");
        jQuery.ajax({
            type: "POST",
            url: "unfollow",
            data: {
                id: dataId,
                status: 'UNFOLLOW',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        jQuery('#allFollower').hide();
                        jQuery('#followRequestCount').show();
                    }
                    document.getElementById("error").innerHTML = jsonResponse.message;
                    document.getElementById("error").className = "alert alert-success";
                } else {
                    spinner.hide();
                    document.getElementById("error").innerHTML =
                            jsonResponse.message;
                    document.getElementById("error").className =
                            "alert alert-danger";
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    jQuery(document).on('click', '.accept , .accept-follow', function () {
        var $this = jQuery(this);
        var dataId = jQuery(this).attr("data-id");
        jQuery.ajax({
            type: "POST",
            url: "accept",
            data: {
                id: dataId,
                follower_request_status: '0',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        $this.parent('div').hide();
                        jQuery('.followCount').hide();
                    } else {
                        jQuery('.followCount').text(jsonResponse.count);
                    }
                    document.getElementById("error").innerHTML = jsonResponse.message;
                    document.getElementById("error").className = "alert alert-success";
                } else {
                    spinner.hide();
                    document.getElementById("error").innerHTML = jsonResponse.message;
                    document.getElementById("error").className = "alert alert-danger";
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    jQuery(document).on('click', '.reject', function () {
        var $this = jQuery(this);
        var dataId = jQuery(this).attr("data-id");
        jQuery.ajax({
            type: "POST",
            url: "reject",
            data: {
                id: dataId,
                status: 'BLOCK',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        $this.parent('div').hide();
                        jQuery('.followCount').hide();
                    } else {
                        jQuery('.followCount').text(jsonResponse.count);
                    }
                    document.getElementById("error").innerHTML = jsonResponse.message;
                    document.getElementById("error").className = "alert alert-success";
                } else {
                    spinner.hide();
                    document.getElementById("error").innerHTML = jsonResponse.message;
                    document.getElementById("error").className = "alert alert-danger";
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    jQuery(document).on('click', '.remove', function () {
        var dataId = jQuery(this).attr("data-id");
        jQuery.ajax({
            type: "POST",
            url: "remove",
            data: {
                id: dataId,
                is_deleted: '1',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        jQuery('#allFollower').hide();
                        jQuery('#followRequestCount').show();
                    }
                    document.getElementById("error").innerHTML =
                            jsonResponse.message;
                    document.getElementById("error").className =
                            "alert alert-success";
                } else {
                    spinner.hide();
                    document.getElementById("error").innerHTML =
                            jsonResponse.message;
                    document.getElementById("error").className =
                            "alert alert-danger";
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    jQuery(document).on('click', '.followPost', function () {
        var $this = jQuery(this);
        var dataId = jQuery(this).data("id");
        var postId = jQuery(this).attr("data-post_id");

        spinner.show();
        jQuery.ajax({
            type: "POST",
            url: "/follow",
            data: {
                followed_user_id: dataId,
                post_id: postId,
                sataus: 'FOLLOW',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    $this.addClass('clicked');
                    $this.removeClass('followPost');
                    // $this.text('REQUEST SEND');
                    $this.text('Request Sent');

                    spinner.hide();
                } else {
                    spinner.hide();
                    alert(jsonResponse.message);
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    jQuery(document).on('click', '#navbarDropdown', function () {
        jQuery.ajax({
            type: "POST",
            url: "updateNotificationCountStatus",
            data: {
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    jQuery('.followCountHead').hide();
                }
            }
        });
    });

    function updateNotificationCount(id) { alert('aaa');
        $.ajax({
            type: "POST",
            url: "updateNotificationCount",
            data: {
                _token: csrf_token,
                'id': id
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    $('.followCountHead').hide();
                }
            }
        });

        return false;
    }


    jQuery('.commentOnPost').keyup(function () {
        var postId = jQuery(this).attr('id');
        if (jQuery(this).val().length > 0) {
            jQuery("#submitPost" + postId).show();
        } else {
            jQuery("#submitPost" + postId).hide();
        }
    });



    jQuery(function () {
        jQuery('[data-toggle="tooltip"]').tooltip()
    });
    jQuery(function () {
        jQuery('[data-toggle="modal"]').tooltip()
    });

});

//To select country name
function selectCountry(val) {
    jQuery("#search-box").val(val);
    jQuery("#suggesstion-box").hide();
}
/**
 * remove message after time set hit
 */
function myTimerUserMessage() {
    document.getElementById("error").innerHTML = " ";
    document.getElementById("error").className = " ";
}

/* Beach Break Location Popup */
function initializeMap(id, lat, long) {
    var map;
    var geocoder;
    var latlng = new google.maps.LatLng(lat, long);
    var myOptions =
            {
                zoom: 14,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
                },
                scrollwheel: false,
                navigationControl: false,
                scaleControl: false,
                disableDoubleClickZoom: true,
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP,
                },
            };

    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    new google.maps.Marker({
        position: latlng,
        map: map
    });

}

//show map on modal
jQuery(document).on('click shown.bs.modal', '.locationMap', function () {
    var id = jQuery(this).attr("data-id");
    var lat = jQuery(this).attr("data-lat");
    var long = jQuery(this).attr("data-long");
    initializeMap(id, lat, long);
});

jQuery('#test-other').click(function () {
    if (jQuery('#test-other').prop('checked')) {
        jQuery('#othersFilterSurfer').removeClass('d-none');
    } else {
        jQuery('#othersFilterSurfer').addClass('d-none');
    }
});

(function ($) {
    var CheckboxDropdown = function (el) {
        var _this = this;
        this.isOpen = false;
        this.areAllChecked = false;
        this.$el = jQuery(el);
        this.$label = this.$el.find(".dropdown-label");
        this.$option = this.$el.find(".dropdown-list");
        this.$checkAll = this.$el.find('[data-toggle="check-all"]').first();
        this.$inputs = this.$el.find('[type="checkbox"]');
        this.$option.css({"transform": "scale(1, 0)", "position": "absolute"});
        this.onCheckBox();

        this.$label.on("click", function (e) {
            e.preventDefault();
            _this.toggleOpen();
        });

        this.$checkAll.on("click", function (e) {
            e.preventDefault();
            _this.onCheckAll();
        });

        this.$inputs.on("change", function (e) {
            _this.onCheckBox();
        });
    };

    CheckboxDropdown.prototype.onCheckBox = function () {
        this.updateStatus();
    };

    CheckboxDropdown.prototype.updateStatus = function () {
        var checked = this.$el.find(":checked");

        this.areAllChecked = false;
        this.$checkAll.html("Check All");

        if (checked.length <= 0) {
            this.$label.html("Select Options");
        } else if (checked.length === 1) {
            this.$label.html(checked.parent("label").text());
        } else if (checked.length === this.$inputs.length) {
            this.$label.html("All Selected");
            this.areAllChecked = true;
            this.$checkAll.html("Uncheck All");
        } else {
            this.$label.html(checked.length + " Selected");
        }
    };

    CheckboxDropdown.prototype.onCheckAll = function (checkAll) {
        if (!this.areAllChecked || checkAll) {
            this.areAllChecked = true;
            this.$checkAll.html("Uncheck All");
            this.$inputs.prop("checked", true);
        } else {
            this.areAllChecked = false;
            this.$checkAll.html("Check All");
            this.$inputs.prop("checked", false);
        }

        this.updateStatus();
    };

    CheckboxDropdown.prototype.toggleOpen = function (forceOpen) {
        var _this = this;

        if (!this.isOpen || forceOpen) {
            this.isOpen = true;
            this.$el.addClass("on");
            this.$option.css({transform: "", "position": "relative"});
            jQuery(document).on("click", function (e) {
                if (!jQuery(e.target).closest("[data-control]").length) {
                    _this.toggleOpen();
                }
            });
        } else {
            this.isOpen = false;
            this.$option.css({"transform": "scale(1, 0)", "position": "absolute"});
            this.$el.removeClass("on");
            jQuery(document).off("click");
        }
    };

    var checkboxesDropdowns = document.querySelectorAll(
            '[data-control="checkbox-dropdown"]'
            );
    for (var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
        new CheckboxDropdown(checkboxesDropdowns[i]);
    }
})(jQuery);
