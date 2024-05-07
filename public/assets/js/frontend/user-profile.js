$(document).ready(function() {
    $('#name,#contact,.picture,#email, select').addClass('read-only');
    $("#name,#contact,.picture,#email, select").prop("readonly", true);
});
$('#edit').click(function() {
    $('#name,#contact,#image, .picture , select').removeClass('read-only');
    $("#name,#contact,#image, .picture , select").prop("readonly", false);
    $(this).parent().addClass('d-none');
    $('#btn-row').removeClass('d-none');
});
$('#cancel-btn').click(function() {
    $('#name,#contact,#image, .picture , select').addClass('read-only');
    $("#name,#contact,#image, .picture , select").prop("readonly", true);
    $('#action-row').removeClass('d-none');
    $('#btn-row').addClass('d-none');
});
$('#delete').click(function() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $('#accountDeleteModal').modal('show');
        }
    });
});
/*image preview*/
$('#image').change(function() {
    let reader = new FileReader();

    reader.onload = (e) => {
        $('#demo').attr('src', e.target.result);
        $('#imgIcon').remove();
    }

    reader.readAsDataURL(this.files[0]);

});
/* csrf token*/
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
/** ajax call for make token for confirmation */
/** verification code send to the mail */
$('.send-btn').click(function () {
   var email = $('#verifyEmail').val();
    $.ajax({
        type: "post",
        url: Confirm,
        data: {
            userEmail: email,
        },
        success: function (response) {
           if (response.error) {
              $('#verifyEmailError').text(response.error);
              $('#verifyEmailError').removeClass('text-success');
              $('#verifyEmailError').addClass('text-danger');
           }
           if (response.success) {
            $('#verifyEmailError').text(response.success);
            $('#verifyEmailError').removeClass('text-danger');
            $('#verifyEmailError').addClass('text-success');
            $('#verificationRow').removeClass('d-none');
         }
        }
    });
});
/** check code is provided one or not */
$('.verify-btn').click(function () {
    var code = $('#verificationCode').val();
    $.ajax({
        type: "post",
        url: ConfirmCode,
        data: {
            verificationCode: code,
        },
        success: function (response) {
            if (response.error) {
                $('#verificationCodeError').text(response.error);
                $('#verificationCodeError').removeClass('text-success');
                $('#verificationCodeError').addClass('text-danger');
             }
             if (response.success) {
              $('#verificationCodeError').text(response.success);
              $('#verificationCodeError').removeClass('text-danger');
              $('#verificationCodeError').addClass('text-success');
              $('#confirmationRow').removeClass('d-none');
           }
        }
    });
});
/** final confirmation */
$('.confirm-btn').click(function () {
     var confirmText =  $('#confirmText').val();
     $.ajax({
        type: "post",
        url: FinalConfirm,
        data: {
            confirmText : confirmText,
        },
        success: function () {
            location.replace(home);
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your account has been deleted.",
                showConfirmButton: false,
                timer: 1500
              });
        }
     });
});
