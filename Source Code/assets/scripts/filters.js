//Filter the cards
function filterSelection(club) {
	var cards, i;
	cards = document.getElementsByClassName("filterDiv");
	if (club === 'all') {
		club = '';
	}
	for (i = 0; i < cards.length; i++) {
		removeClass(cards[i], "show");
		if (cards[i].className.indexOf(club) > -1) addClass(cards[i], "show");
	}
}

function addClass(element, name) {
  var arr1 = element.className.split(" ");
  if (arr1.indexOf(name) == -1) {
    element.className += " " + name;
  }
}

function removeClass(element, name) {
  var arr1 = element.className.split(" ");
  var arr2 = name.split(" ");
  for (var i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1); 
    }
  }
  element.className = arr1.join(" ");
}

//Display all cards
document.addEventListener('DOMContentLoaded', function(){
  var btnContainer = document.getElementById("myButtonsContainer");
  var btns = btnContainer.getElementsByClassName("btn");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function(){
      var current = btnContainer.getElementsByClassName("active");
      if(current.length > 0) {
        current[0].className = current[0].className.replace(" active", "");
      }
      this.className += " active";
    });
  }
  
  filterSelection('all');
});

//Close the modal
function closeModal() {
	document.getElementById("searchModal").style.display = 'none';
}

// Close the modal by clicking outside of it
window.onclick = function(event) {
	var modal = document.getElementById("searchModal");
	if (event.target == modal) {
		closeModal();
	}
}
