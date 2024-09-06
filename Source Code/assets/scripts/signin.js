$(document).ready(function() { 
	//Handle the submission of the signin form
    $('#signinForm').on('submit', function(e) {
        e.preventDefault();

        var signinFormData = {
            userName2: $("#userName2").val(),
            userPassword2: $("#userPassword2").val(),
        };

        $.ajax({
            type: 'POST',
            url: 'authentication_api.php',
            data: signinFormData,
            dataType: 'json',
            encode: true,
        })
        .done(function(response) {
            if(response.status === 'success') {
                $('#response').html('<div class="alert alert-success"><p class="alert-content">' + response.message + '</p></div>');
				// Redirect after 3 seconds
                setTimeout(function() {
                    window.location.href = "user.php";
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