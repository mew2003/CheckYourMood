function myFunction(i) {
    let myPopup = "myPopup" + i;
    var popup = document.getElementById(myPopup);
    popup.classList.toggle("show");
}