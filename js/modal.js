var btn = document.getElementById("myBtn");
btn.onclick = function() {modal.style.display = "block";}

// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// SECOND MODAL

var btn2 = document.getElementById("myBtn2");
btn2.onclick = function() {modal2.style.display = "block";}

var modal2 = document.getElementById('myModal2');

var span2 = document.getElementsByClassName("close2")[0];

span2.onclick = function() {
    modal2.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}
