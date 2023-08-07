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
    $("form[name='register-surfer'] #exampleInputFile").change(function () {
        readURL(this);
    });
    $("form[name='register-resort'] #exampleInputFile").change(function () {
        readURL(this);
    });
    $("form[name='register-advertiser'] #exampleInputFile").change(function () {
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
            $("form[name='register-surfer'] #remove-img").show();
            $("form[name='register-resort'] #remove-img").show();
            $("form[name='register-advertiser'] #remove-img").show();
        } else {
            $('#imagebase64').val("");
            $("form[name='register-surfer'] #imagebase64").val("");
            $("form[name='register-resort'] #imagebase64").val("");
            $("form[name='register-advertiser'] #imagebase64").val("");
            $("#exampleInputFile").val("");
            $("form[name='register-surfer'] #exampleInputFile").val("");
            $("form[name='register-resort'] #exampleInputFile").val("");
            $("form[name='register-advertiser'] #exampleInputFile").val("");

            $("#category-img-tag").attr("src", "/img/image-file.png");
            $("#category-img-tag").attr("width", "auto");


            $("form[name='register-surfer'] #category-img-tag").attr("src", "/img/image-file.png");
            $("form[name='register-surfer'] #category-img-tag").attr("width", "auto");

            $("form[name='register-resort'] #category-img-tag").attr("src", "/img/image-file.png");
            $("form[name='register-resort'] #category-img-tag").attr("width", "auto");

            $("form[name='register-advertiser'] #category-img-tag").attr("src", "/img/image-file.png");
            $("form[name='register-advertiser'] #category-img-tag").attr("width", "auto");

            $("#remove-img").hide();
            $("#imageError").show();
            $("form[name='register-surfer'] #remove-img").hide();
            $("form[name='register-resort'] #remove-img").hide();
            $("form[name='register-advertiser'] #remove-img").hide();
            $("form[name='register-surfer'] #imageError").show();
            $("form[name='register-resort'] #imageError").show();
            $("form[name='register-advertiser'] #imageError").show();
        }
    }

    $('.crop_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $('#imagebase64').val(response);
            $("form[name='register-surfer'] #imagebase64").val(response);
            $("form[name='register-resort'] #imagebase64").val(response);
            $("form[name='register-advertiser'] #imagebase64").val(response);
            $("#category-img-tag").attr("src", response);
            $("#category-img-tag").attr("width", "100%");

            $("form[name='register-surfer'] #category-img-tag").attr("src", response);
            $("form[name='register-surfer'] #category-img-tag").attr("width", "100%");

            $("form[name='register-resort'] #category-img-tag").attr("src", response);
            $("form[name='register-resort'] #category-img-tag").attr("width", "100%");

            $("form[name='register-advertiser'] #category-img-tag").attr("src", response);
            $("form[name='register-advertiser'] #category-img-tag").attr("width", "100%");

            $('#myModal').modal('hide');
        })
    });

    /**
     * Model Cancle
     */
    $(".close").click(function () {
        $('#imagebase64').val("");
        $("form[name='register-surfer'] #imagebase64").val("");
        $("form[name='register-resort'] #imagebase64").val("");
        $("form[name='register-advertiser'] #imagebase64").val("");
        $("#exampleInputFile").val("");
        $("form[name='register-surfer'] #exampleInputFile").val("");
        $("form[name='register-resort'] #exampleInputFile").val("");
        $("form[name='register-advertiser'] #exampleInputFile").val("");
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

    $("#myButton").click(function () {
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
                    userId: id,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    if (jsonResponse.status == "success") {
                        spinner.hide();
                        $("#head").load(location.href + " #head>*", "");
                        document.getElementById("error").innerHTML = jsonResponse.message;
                        document.getElementById("error").className = "alert alert-success";
                    } else {
                        spinner.hide();
                        $("#head").load(location.href + " #head>*", "");
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
            "No space are allowed"
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

    $.validator.addMethod(
            "localBeachBreak",
            function (value) {
                return value != "";
            },
            "Please enter beack break"
            );

    $.validator.addMethod(
            "newPwdCurrentPws",
            function (value) {
                if (value != $('#current_password').val()) {
                    return value;
                }
            },
            "New password can not be same as current password"
            );

    $("form[name='register']").validate({
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

    $("form[name='register-resort']").validate({
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
                $('.resort_pics_error').text('Please select only 5 pics');
                return false;
            } else {
                $('.resort_pics_error').text('');
            }
            form.submit();
        }
    });



    $("form[name='register-advertiser']").validate({
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

    $("form[name='register-surfer']").validate({
        rules: {
            gender: {
                required: true,
            },
            dob: {
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


//    $('#formFile').change(function(){
//   //get the input and the file list
//   var input = document.getElementById('formFile');
//   if(input.files.length>4){
//       $('.validation').css('display','block');
//   }else{
//       $('.validation').css('display','none');
//   }
//});

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
    $("form[name='update_profile']").validate({
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
    $('.search-box').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 2) {
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

        } else {
            $('#local_beach_break_id').val('');
            $('#country_list').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    $('#searchFollower').keyup(debounce(function () {
        // the following function will be executed every half second
        var user_id = $('#user_id').val();
        var keyword = $('#searchFollower').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/searchFollwers/" + user_id,
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            $('#local_beach_break_id').val('');
//            $('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
    $('#searchFollowing').keyup(debounce(function () {
        // the following function will be executed every half second
        var keyword = $('#searchFollowing').val();
        var user_id = $('#user_id').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/searchFollowing/" + user_id,
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            $('#local_beach_break_id').val('');
//            $('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
    $('#searchFollowRequest').keyup(debounce(function () {
        // the following function will be executed every half second
        var keyword = $('#searchFollowRequest').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/searchFollowRequest",
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            $('#local_beach_break_id').val('');
//            $('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    $('.search-box4').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 2) {
            $.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#country_list4').html(jsonResponse);
                }
            })

        } else {
            $('#local_beach_break_id_resort').val('');
            $('#country_list4').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    $('.search-box3').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 2) {
            $.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#country_list3').html(jsonResponse);
                }
            })

        } else {
            $('#local_beach_break_id_surfer').val('');
            $('#country_list3').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    $('.ad-search-box').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 2) {
            $.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#beach_list').html(jsonResponse);
                }
            })

        } else {
            $('#local_beach_id').val('');
            $('#beach_list').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)


    $(document).on('click', '#beach_list li', function () {
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#beach_list').html("");
        $('.ad-search-box').val(value);
        $('#local_beach_id').val(dataId);
        $('#beach_list').html("");
    });
    $(document).on('click', '.search1 li', function () {
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#country_list').html("");
        $('.search-box').val(value);
        $('#local_beach_break_id').val(dataId);
        getBreak(dataId);
        $('#country_list').html("");
    });

    $(document).on('click', '.search4 li', function () {
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#country_list4').html("");
        $('.search-box4').val(value);
        $('#local_beach_break_id_resort').val(dataId);
        getBreak(dataId);
        $('#country_list4').html("");
    });

    $(document).on('click', '.search3 li', function () {
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#country_list3').html("");
        $('.search-box3').val(value);
        $('#local_beach_break_id_surfer').val(dataId);
        getBreak(dataId);
        $('#country_list3').html("");
    });

    $(document).on('click', '.previewAds', function () {
//        alert('ggg');
        var form = $('#storeAdvert').val();
        $('#preview').val("1");
        form.submit();
    });


    function getBreak(beachValue) {
//        var beachValue = $(this).val();
        if (beachValue != 0) {
            $.ajax({
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
                        $("#break_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#break_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            if (value.break_name != '') {
                                $("#break_id").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                                $("#break_id").rules("add", {required: true, messages: {required: "Break is required"}});

                            } else {
                                $("#break_id").rules("remove");
                            }
                        });
                    } else {
                        $("#break_id").empty();
                    }
                }
            });
        } else {
            $("#state_id").empty();
        }
    }

    $("#beach_filter").change(function (e) {
//    if ($('#beach_filter').is(":selected")) {
        $('#break_filter').find('option').remove();
        $("#break_filter").append('<option value=""> -- Break --</option>');
        var beachValue = $(this).val();
        $.ajax({
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
                    var myJsonData = jsonResponse.data;

                    $.each(myJsonData, function (key, value) {
                        if (value.break_name != '') {
                            $("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
//                            $("#break_filter").append('<div class="cstm-check pos-rel break_rem'+beachValue+'"><input type="checkbox" id="break_' + value.id + '" name="filter_break_' + value.id + '" value="' + value.id + '" /><label for="break_' + value.id + '" class="width-138">' + value.break_name + '</label></div>');
                        }
                    });
                } else {
//                    $("#break_id").empty();
                }
            }
        });

//        }
//        alert("checked Score: " + $(this).val());
//    else {
//        var beachValue = $(this).val();
////        $("#break_filter").remove();
//    }
    });


    $("#board_type").change(function (e) {
//    if ($('#beach_filter').is(":selected")) {
//        $('#break_filter').find('option').remove();
//        $("#break_filter").append('<option value=""> -- Break --</option>');
        var board_type = $(this).val();
        if (board_type !== '') {
            $.ajax({
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

                    $('#additional_optional_info').removeClass('d-none');
                    $('#additional_optional_info').html(jsonResponse);
//                } else {
//                    $('#additional_optional_info').addClass('d-none');
//                }
                }
            });

        } else {
            $('#additional_optional_info').addClass('d-none');
//        $("#break_filter").remove();
        }
    });

    // ajax form field data for filter
    $('.search-box2').keyup(debounce(function () {
        // the following function will be executed every half second

        if ($(this).val().length > 2) {

            $.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#country_list2').html(jsonResponse);
                }
            })

        } else {
            $('#local_beach_break_id2').val('');
            $('#country_list2').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    $(document).on('click', '.searchTwo li', function () {
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#country_list2').html("");
        $('.search-box2').val(value);
        $('#local_beach_break_id2').val(dataId);
        $('#country_list2').html("");
    });




    $('.other_surfer').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 1) {
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
        } else {
            $('#surfer_id').val('');
            $('#other_surfer_list').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    $(document).on('click', '.search2 li', function () {
        var value = $(this).text().trim();
        var dataId = $(this).attr("data-id");
        $('#other_surfer_list').html("");
        $('.other_surfer').val(value);
        $('#surfer_id').val(dataId);
        $('#other_surfer_list').html("");
    });

    $(document).on('click', '#filter_other_surfer_data li', function () {
        var value = $(this).text().trim();
        var dataId = $(this).attr("data-id");

        $('.filter_other_surfer').val(value);
        $('#surfer_id_filter').val(dataId);
        $('#filter_other_surfer_data').html("");
    });

    $(document).on('click', '#filter_username_data li', function () {
        var value = $(this).text().trim();

        $('.filter_username').val(value);
        $('#filter_username_data').html("");
    });


    $('.filter_other_surfer').keyup(debounce(function () {
        // the following function will be executed every half second
        var userType = $('#filter_user_type').val();

        if ($(this).val().length > 1) {
            $.ajax({
                type: "GET",
                url: "/getFilterUsers",
                data: {
                    user_type: userType,
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    $('#filter_other_surfer_data').html(jsonResponse);
                }
            });
        } else {
            $('#surfer_id_filter').val('');
            $('#filter_other_surfer_data').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    $('.filter_username').keyup(debounce(function () {
        // the following function will be executed every half second
        var userType = $('#filter_user_type').val();

        if ($(this).val().length > 1) {
            $.ajax({
                type: "GET",
                url: "/getFilterUsers",
                data: {
                    user_type: userType,
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    $('#filter_username_data').html(jsonResponse);
                }
            });
        } else {
            $('#filter_username_data').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)



    $('.tag_user').keyup(debounce(function () {
        // the following function will be executed every half second

        var post_id = $(this).attr('data-post_id');
        if ($(this).val().length > 1) {
            $.ajax({
                type: "GET",
                url: "/getTagUsers",
                data: {
                    post_id: post_id,
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#tag_user_list' + post_id).html(jsonResponse);
                }
            })
        } else {
            $('#user_id').val('');
            $('#tag_user_list' + post_id).html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)


    $(document).on('click', '.tagSearch li', function () {
        var value = $(this).text().trim();
        var dataId = $(this).attr("data-id");
        var postId = $(this).attr("data-post_id");
        //ajax call to insert data in tag table and also set notification
        $.ajax({
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
                    $('#rowId' + dataId).hide();
                    //$('#tag_user_list'+postId).html("");
                    $('.tag_user').val(value);
                    $('#user_id').val(dataId);
                    //$('#tag_user_list'+postId).html("");
                    $(".scrollWrap").empty();
                    $('.scrollWrap').html(jsonResponse.responsData);
                } else {
                    alert(jsonResponse.message);
                }
                $('#tag_user_list' + post_id).html(jsonResponse);
            }
        })
    });


    var other = $('input[name="other_surfer"]').val();
    if (other == 'Me') {
        $('input[name="other_surfer"]').val('');
    } else if (other == 'Unknown') {
        $('input[name="other_surfer"]').val('');
    } else {
        $("#othersSurfer").show();
        $('input[name="surfer"][value="Others"]').prop("checked", true);
    }



    /**
     * State Baded on the selection on country
     */

    $(document).on('change', '#country_id, #edit_country_id', function (e) {
        var currentcountryValue = $(this).val();
        if (currentcountryValue != 0) {
            $.ajax({
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
                        $("#state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            $("#state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
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

    $(document).on('change', '#search_country_id', function (e) {
        var currentcountryValue = $(this).val();
        if (currentcountryValue != 0) {
            $.ajax({
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
                        $("#search_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#search_state_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            $("#search_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        $("#search_state_id").empty();
                    }
                }
            });
        } else {
            $("#search_state_id").empty();
        }
    });



    /**
     * Filter State Baded on the selection on filter country
     */

    $(document).on('change', '#filter_country_id, #edit_country_id', function (e) {
        var currentcountryValue = $(this).val();
        if (currentcountryValue != 0) {
            $.ajax({
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
                        $("#filter_state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#filter_state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            $("#filter_state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        $("#filter_state_id").empty();
                    }
                }
            });
        } else {
            $("#filter_state_id").empty();
        }
    });

    $(document).on('click', '.unfollow', function () {
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "unfollow",
            data: {
                id: dataId,
                status: 'UNFOLLOW',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        $('#allFollower').hide();
                        $('#followRequestCount').show();
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

    $(document).on('click', '.accept , .accept-follow', function () {
        var $this = $(this);
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "accept",
            data: {
                id: dataId,
                follower_request_status: '0',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        $this.parent('div').hide();
                        $('.followCount').hide();
                    } else {
                        $('.followCount').text(jsonResponse.count);
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

    $(document).on('click', '.reject', function () {
        var $this = $(this);
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "reject",
            data: {
                id: dataId,
                status: 'BLOCK',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        $this.parent('div').hide();
                        $('.followCount').hide();
                    } else {
                        $('.followCount').text(jsonResponse.count);
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

    $(document).on('click', '.remove', function () {
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "remove",
            data: {
                id: dataId,
                is_deleted: '1',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('#row-id' + dataId).hide();
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    if (jsonResponse.count == 0) {
                        $('#allFollower').hide();
                        $('#followRequestCount').show();
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

    $(document).on('click', '.followPost', function () {
        var $this = $(this);
        var dataId = $(this).data("id");
        var postId = $(this).attr("data-post_id");

        spinner.show();
        $.ajax({
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

                    spinner.hide();
                } else {
                    spinner.hide();
                    alert(jsonResponse.message);
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    $(document).on('click', '#navbarDropdown', function () {
        $.ajax({
            type: "POST",
            url: "updateNotificationCountStatus",
            data: {
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    $('.followCountHead').hide();
                }
            }
        });
    });

    $('.commentOnPost').keyup(function () {
        var postId = $(this).attr('id');
        if ($(this).val().length > 0) {
            $("#submitPost" + postId).show();
        } else {
            $("#submitPost" + postId).hide();
        }
    });

    //Auto play videos when view in scroll
    function isInView(el) {
        var rect = el.getBoundingClientRect();// absolute position of video element
        return !(rect.top > $(window).height() || rect.bottom < 0);// visible?
    }

    $(document).on("scroll", function () {
        $("video").each(function () {
            if (isInView($(this)[0])) {// visible?
                if ($(this)[0].paused)
                    $(this)[0].play();// play if not playing
            } else {
                if (!$(this)[0].paused)
                    $(this)[0].pause();// pause if not paused
            }
        });
    });
    //End auto play

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $(function () {
        $('[data-toggle="modal"]').tooltip()
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
$(document).on('click shown.bs.modal', '.locationMap', function () {
    var id = $(this).attr("data-id");
    var lat = $(this).attr("data-lat");
    var long = $(this).attr("data-long");
    initializeMap(id, lat, long);
});

$('#test-other').click(function () {
    if ($('#test-other').prop('checked')) {
        $('#othersFilterSurfer').removeClass('d-none');
    } else {
        $('#othersFilterSurfer').addClass('d-none');
    }
});

(function ($) {
    var CheckboxDropdown = function (el) {
        var _this = this;
        this.isOpen = false;
        this.areAllChecked = false;
        this.$el = $(el);
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
            $(document).on("click", function (e) {
                if (!$(e.target).closest("[data-control]").length) {
                    _this.toggleOpen();
                }
            });
        } else {
            this.isOpen = false;
            this.$option.css({"transform": "scale(1, 0)", "position": "absolute"});
            this.$el.removeClass("on");
            $(document).off("click");
        }
    };

    var checkboxesDropdowns = document.querySelectorAll(
            '[data-control="checkbox-dropdown"]'
            );
    for (var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
        new CheckboxDropdown(checkboxesDropdowns[i]);
    }
})(jQuery);
