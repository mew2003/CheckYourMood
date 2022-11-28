let register = document.querySelector('.left');
let connection = document.querySelector('.right');
let shifterElements = document.querySelectorAll('.shifter');
let register_phone = document.querySelector('.left-bot')
let connection_phone = document.querySelector('.right-bot')

// SE correspond à la variable shifterElements
let valuesSE = [];

register.addEventListener('click', function() {
    register.classList.add('selection');
    connection.classList.remove('selection');
    shifterElements.forEach((element) => {
        element.value = valuesSE[0];
        valuesSE.shift();
        element.classList.remove('display-none');
    });
})

connection.addEventListener('click', function() {
    register.classList.remove('selection');
    connection.classList.add('selection');
    shifterElements.forEach((element) => {
        valuesSE.push(element.value);
        element.value = '';
        element.classList.add('display-none');
    });
})

register_phone.addEventListener('click', function() {
    register_phone.classList.add('selection');
    connection_phone.classList.remove('selection');
    shifterElements.forEach((element) => {
        element.value = valuesSE[0];
        valuesSE.shift();
        element.classList.remove('display-none');
    });
})

connection_phone.addEventListener('click', function() {
    register_phone.classList.remove('selection');
    connection_phone.classList.add('selection');
    shifterElements.forEach((element) => {
        valuesSE.push(element.value);
        element.value = '';
        element.classList.add('display-none');
    });
})

let checkbox = document.getElementById('check');
checkbox.addEventListener('click', function() {
    if (checkbox.checked) {
        document.getElementById('pass').type='text';
        document.getElementById('pass1').type='text';
    } else {
        document.getElementById('pass').type='password';
        document.getElementById('pass1').type='password';
    }
})