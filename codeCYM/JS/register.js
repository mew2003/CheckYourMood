let register = document.querySelectorAll('.left');
let connection = document.querySelectorAll('.right');
let shifterElements = document.querySelectorAll('.shifter');
let login = document.getElementById('login');
let valuesSE = [];
let registerTab = [];
let connectionTab = [];
let errorMessages = ["Les deux mots de passe ne sont pas identique", "Ce nom d'utilisateur ou cette adresse mail est déjà utilisé"];


register.forEach((element) => {
    registerTab.push(element);
});

connection.forEach((element) => {
    connectionTab.push(element);
});

$(".left").on('click', function() { (registerSelected()) });
$(".right").on('click', function() { (loginSelected()) });

errorMessages.forEach((element) => {
    if (element == $(".error").attr('id')) {
        $(".left").on('click', function() { (registerSelected()) });
    }
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



function registerSelected() {
    registerTab.forEach((elementRegister) => {
        if (!(elementRegister.className.match('selection'))) {
            $(".left").addClass('selection');
            $(".right").removeClass('selection');
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
}


function loginSelected() {
    connectionTab.forEach((elementConnection) => {
        if (!(elementConnection.className.match('selection'))) {
            $(".left").removeClass('selection');
            $(".right").addClass('selection');
            login.value = 1;
            shifterElements.forEach((element) => {
                valuesSE.push(element.value);
                element.value = '';
                element.classList.add('display-none');
            });
        }
    });
}

