document.addEventListener('DOMContentLoaded', function() {
    var userBalance = document.getElementById('addbalance');

    userBalance.addEventListener('click', function() {
        var userId = this.getAttribute('data-userid');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_balance.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if(this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var response = JSON.parse(this.responseText);
                if(response.success) {
                    // Update balance on the page
                    document.getElementById('userBalance').textContent = response.newBalance + ' SwinCoin';
                } else {
                    alert('Error: Could not update balance.');
                }
            }
        }
        
        xhr.send('user_id=' + encodeURIComponent(userId));
    });
});