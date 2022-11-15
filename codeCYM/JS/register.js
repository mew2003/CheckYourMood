let register = document.querySelector('.left');
let connection = document.querySelector('.right');
let confirm_password = document.querySelector('.shifter-confirm');
let mail = document.querySelector('.shifter-mail');

register.addEventListener('click', function() {
    register.classList.add('selection');
    connection.classList.remove('selection');
    confirm_password.classList.remove('display-none');
    mail.classList.remove('display-none');
})

connection.addEventListener('click', function() {
    register.classList.remove('selection');
    connection.classList.add('selection');
    confirm_password.classList.add('display-none');
    mail.classList.add('display-none');
})