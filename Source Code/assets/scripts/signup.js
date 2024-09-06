$(document).ready(function() {
    //Handle the submission of the signup form
    $('#signupForm').on('submit', function(e) {
        //Prevent the default form submission
		e.preventDefault();
		
		//Gather data from the form
        var signupFormData = {
            userName: $("#userName").val(), 
			email: $("#email").val(),
			userPassword: $("#userPassword").val(),
        };

        //AJAX call for the signup form
        $.ajax({
            type: 'POST',
            url: 'registration_api.php',
			data: signupFormData,
			dataType: 'json',
			encode: true,
        })
        .done(function(response) {
            if(response.status === 'success') {
                $('#response').html('<div class="alert alert-success"><p class="alert-content">' + response.message + '</p></div>');
            } else {
                $('#response').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        })
        .fail(function (xhr, status, error) {
            alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText);
        });
    });	
});