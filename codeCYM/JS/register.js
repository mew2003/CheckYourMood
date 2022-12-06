let register = document.querySelectorAll('.left');
let connection = document.querySelectorAll('.right');
let shifterElements = document.querySelectorAll('.shifter');
let valuesSE = [];
let registerTab = [];
let connectionTab = [];


register.forEach((element) => {
    registerTab.push(element);
});

connection.forEach((element) => {
    connectionTab.push(element);
});

registerTab.forEach((elementRegister) => {
    connectionTab.forEach((elementConnection) => {
        elementRegister.addEventListener('click', function() {
            if (!(elementRegister.className.match('selection'))) {
                registerTab[0].classList.add('selection');
                registerTab[1].classList.add('selection');
                connectionTab[0].classList.remove('selection');
                connectionTab[1].classList.remove('selection');
                shifterElements.forEach((element) => {
                    element.value = valuesSE[0];
                    valuesSE.shift();
                    element.classList.remove('display-none');
                });
            }
        });

        elementConnection.addEventListener('click', function() {
            if (!(elementConnection.className.match('selection'))) {
                registerTab[0].classList.remove('selection');
                registerTab[1].classList.remove('selection');
                connectionTab[0].classList.add('selection');
                connectionTab[1].classList.add('selection');
                shifterElements.forEach((element) => {
                    valuesSE.push(element.value);
                    element.value = '';
                    element.classList.add('display-none');
                });
            }
        });
    });
});

// if (registerTab[0].classList.match('Selection')) {
//     document.cookie() = 'selection=register';
// } else {
//     document.cookie() = 'selection=test';
// }


let checkbox = document.getElementById('check');
checkbox.addEventListener('click', function() {
    if (checkbox.checked) {
        document.getElementById('pass').type='text';
        document.getElementById('pass1').type='text';
    } else {
        document.getElementById('pass').type='password';
        document.getElementById('pass1').type='password';
    }
});


// var xhttp = new XMLHttpRequest();
// xhttp.open("POST", "/CheckYourMood/codeCYM/views/register.php", true); 
// xhttp.setRequestHeader("Content-Type", "application/json");
// xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//      // Response
//      var response = this.responseText;
//    }
// };
// var data = {name:'yogesh',salary: 35000,email: 'yogesh@makitweb.com'};
// xhttp.send(JSON.stringify(data));

