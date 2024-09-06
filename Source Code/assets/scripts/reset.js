$(document).ready(function() {
	//Handle the submission of the reset password form
    $('#resetpassForm').on('submit', function(e) {
        e.preventDefault();

        var resetpassForm = {
            userName3: $("#userName3").val(),
			email3: $("#email3").val(),
            userPassword3: $("#userPassword3").val(),
        };

        $.ajax({
            type: 'POST',
            url: 'resetpassword_api.php',
            data: resetpassForm,
            dataType: 'json',
            encode: true
        })
        .done(function(response) {
            if(response.status === 'success') {
                $('#response').html('<div class="alert alert-success"><p class="alert-content">' + response.message + '</p></div>');
				setTimeout(function() {
                    window.location.href = "account.php";
                }, 3000);
            } else {
                $('#response').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        })
        .fail(function (xhr, status, error) {
            alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText);
        });
    });
});