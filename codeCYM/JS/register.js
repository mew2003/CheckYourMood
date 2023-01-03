let register = document.querySelectorAll('.left');
let connection = document.querySelectorAll('.right');
let shifterElements = document.querySelectorAll('.shifter');
let login = document.getElementById('login');
let error = document.querySelector('error');
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
                login.value = 0;
                shifterElements.forEach((element) => {
                    if (valuesSE[0] != null) {
                        element.value = valuesSE[0];
                        valuesSE.shift();
                    }
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
                login.value = 1;
                shifterElements.forEach((element) => {
                    valuesSE.push(element.value);
                    element.value = '';
                    element.classList.add('display-none');
                });
            }
        });
    });
});


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


