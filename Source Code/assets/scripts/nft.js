$(document).ready(function() {
    $('#createForm').on('submit', function(e) {
		e.preventDefault();
		
        var insertFormData = {
            image_url: $("#image_url").val(), 
			player_name: $("#player_name").val(),
			club: $("#club").val(),
			position: $("#position").val(),
			age: $("#age").val(),
			country: $("#country").val(),
			price: $("#price").val(),
        };

        $.ajax({
            type: 'POST',
            url: 'insert_nft.php',
			data: insertFormData,
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