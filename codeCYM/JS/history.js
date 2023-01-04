function myFunction(i) {  
    let myPopup = "myPopup" + i;
    var popup = document.getElementById(myPopup);
    popup.classList.toggle("show");
    var input = document.getElementById(i);
    input.value = "0";
}
function myFunctionRemove(i) {  
    let myPopup = "myPopup" + i;
    var popup = document.getElementById(myPopup);
    popup.classList.remove("show");
}