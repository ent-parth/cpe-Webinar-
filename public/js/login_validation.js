var FormValidation = function () {
    // Login Validation
    var __loginValidation = function () {
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }
        // Initialize
        $('#login-form').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            // Different components require proper error label placement
            errorPlacement: function (error, element) {
                if (element.parents().hasClass('form-check')) {
                    error.appendTo(element.parents('.form-check').parent());
                } else if (element.attr("name") == "template_text") {
                    error.insertAfter(element.parent("div"));
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email."
                },
                password: {
                    required: "Please enter password."
                }
            },
            submitHandler: function (form) {
                // do other things for a valid form
                $('.custom-loader').css('display', 'block');
                form.submit();
            }
        });
    };
    // Forgot Password Validation
    var __forgotPasswordValidation = function () {
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }
        // Initialize
        $('#forgot-password-form').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            // Different components require proper error label placement
            errorPlacement: function (error, element) {
                if (element.parents().hasClass('form-check')) {
                    error.appendTo(element.parents('.form-check').parent());
                } else if (element.attr("name") == "template_text") {
                    error.insertAfter(element.parent("div"));
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/forgot-password/check-email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    }
                }
            },
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email does not exist in our records."
                }
            },
            submitHandler: function (form) {
                $('.custom-loader').css('display', 'block');
                $('#forgot-password-form').submit();
            },
        });
    };

    // Reset Password Validation
    var __resetPasswordValidation = function () {
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }
        // Initialize
        $('#reset-password-form').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            // Different components require proper error label placement
            errorPlacement: function (error, element) {
                if (element.parents().hasClass('form-check')) {
                    error.appendTo(element.parents('.form-check').parent());
                } else if (element.attr("name") == "template_text") {
                    error.insertAfter(element.parent("div"));
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/reset/check-email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    }
                },
                password: {
                    required: true,
                    customPassword: true,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email does not exist in our records."
                },
                password: {
                    required: "Please enter password.",
                    customPassword: "Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.",
                },
                password_confirmation: {
                    required: "Please enter confirm password.",
                    equalTo: "Password and confirm password do not match."
                }
            },
            submitHandler: function (form) {
                $('.custom-loader').css('display', 'block');
                $('#reset-password-form').submit();
            },
        });
    };

    return {
        init: function () {
            __loginValidation();
            __forgotPasswordValidation();
            __resetPasswordValidation();
        }
    }
}();

jQuery(document).ready(function () {
    FormValidation.init();

    jQuery.validator.addMethod("customPassword", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value);
    }, 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.');
    $(".icon-eye").click(function () {
        if ($(this).attr('id') == "confirm-password") {
            var inputPassword = 'confirm_password';
        } else {
            var inputPassword = 'password';
        }
        if ($("#" + inputPassword).attr('type') == 'password') {
            $("#" + inputPassword).attr('type', 'text')
        } else if ($("#" + inputPassword).attr('type') == 'text') {
            $("#" + inputPassword).attr('type', 'password')
        }
    });
});