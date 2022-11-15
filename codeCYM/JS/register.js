let register = document.querySelector('.left');
let connection = document.querySelector('.right');
let confirm_password = document.querySelector('.shifter-confirm');
let mail = document.querySelector('.shifter-mail');
let register_phone = document.querySelector('.left-bot')
let connection_phone = document.querySelector('.right-bot')

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

register_phone.addEventListener('click', function() {
    register_phone.classList.add('selection');
    connection_phone.classList.remove('selection');
    confirm_password.classList.remove('display-none');
    mail.classList.remove('display-none');
})

connection_phone.addEventListener('click', function() {
    register_phone.classList.remove('selection');
    connection_phone.classList.add('selection');
    confirm_password.classList.add('display-none');
    mail.classList.add('display-none');
})