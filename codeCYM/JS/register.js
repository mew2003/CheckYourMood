let register = document.querySelectorAll('.left');
let connection = document.querySelectorAll('.right');
let shifterElements = document.querySelectorAll('.shifter');
let login = document.getElementById('login');
let valuesSE = [];
let registerTab = [];
let connectionTab = [];
let loginError = document.getElementById('loginError');
let registerError = document.getElementById('registerError');
let action = document.getElementById('action');


register.forEach((element) => {
    registerTab.push(element);
});

connection.forEach((element) => {
    connectionTab.push(element);
});

$(".left").on('click', function() { (registerSelected()) });
$(".right").on('click', function() { (loginSelected()) });


if (loginError.className.match('error')) {
    loginSelected();
} else if (registerError.className.match('error')) {
    registerSelected();
}

let checkbox = document.getElementById('check');
checkbox.addEventListener('click', function() {
    if (checkbox.checked) {
        document.getElementById('password').type='text';
        document.getElementById('confirmPassword').type='text';
    } else {
        document.getElementById('password').type='password';
        document.getElementById('confirmPassword').type='password';
    }
});


/**
 * Permet de changer le mode de connexion à inscription
 */
function registerSelected() {
    registerTab.forEach((elementRegister) => {
        /* Vérifie pour chaque div 'register' (celle pour la version pc, tablettes et celle pour la version téléphone)
           si la div a la classe 'selection' si c'est le cas ne fait rien */
        if (!(elementRegister.className.match('selection'))) {
            /* sinon ajoute la classe 'selection' à la div 'register' et la retire à la div 'connection' */
            $(".left").addClass('selection');
            $(".right").removeClass('selection');
            /* change la valeur de 'action' pour que le bouton valider du formulaire appel la bonne fonction du controller */
            action.value = "register";
            /* change la valeur de 'login' pour que l'utilisateur ne puisse pas se connecter depuis l'inscription */
            login.value = 0;
            /* remet toutes les valeurs déjà saisie dans les champs et réaffiche les champs qui n'étaient pas affiché 
               en leur enlevant la classe 'display-none' */
            shifterElements.forEach((element) => {
                if (valuesSE[0] != null) {
                    element.value = valuesSE[0];
                    valuesSE.shift();
                }
                element.classList.remove('display-none');
                element.setAttribute('required', true);
            });
        }
    });
}

/**
 * Permet de changer le mode de inscription à connexion
 */
function loginSelected() {
    connectionTab.forEach((elementConnection) => {
        /* Vérifie pour chaque div 'register' (celle pour la version pc, tablettes et celle pour la version téléphone)
           si la div a la classe 'selection' si c'est le cas ne fait rien */
        if (!(elementConnection.className.match('selection'))) {
            /* sinon ajoute la classe 'selection' à la div 'connection' et la retire à la div 'register' */
            $(".left").removeClass('selection');
            $(".right").addClass('selection');
            /* change la valeur de 'action' pour que le bouton valider du formulaire appel la bonne fonction du controller */
            action.value = "login";
            /* change la valeur de 'login' pour que l'utilisateur puisse se connecter */
            login.value = 1;
            /* met toutes les valeurs déjà saisie dans un tableau et met des valeurs null dans les champs
               ajoute aussi la classe 'display-none' aux champs qui ne sont pas nécessaire à la connexion */
            shifterElements.forEach((element) => {
                valuesSE.push(element.value);
                element.value = '';
                element.classList.add('display-none');
                element.setAttribute('required', false);
            });
        }
    });
}


$("#username").on('blur', function() { (champValide($("#username"), "")) });
$("#email").on('blur', function() { (champValide($("#email"), "")) });
$("#birthDate").on('blur', function() { 
    if (!champValide($("#birthDate"), "")) {
        $("#birthDate").attr('hidden', true);
        $("#falseBirthDate").attr('hidden', false);
        $("#falseBirthDate").addClass('input-error');
    } else {
        $("#falseBirthDate").attr('required', false);
    }
});
$("#gender").on('blur', function() { (champValide($("#gender"), "Choisissez votre genre")) });
$("#password").on('blur', function() { (champValide($("#password"), "")) });
$("#confirmPassword").on('blur', function() { (champValide($("#confirmPassword"), "")) });


function champValide(champ, value) {
    if (champ.val() == value) {
      // Le champ est vide, donc il est invalide
      champ.addClass('input-error');
      return false;
    } else {
      // Le champ n'est pas vide, donc il est valide
      champ.removeClass('input-error');
      return true;
    }
}

$("#falseBirthDate").on('focus', function() { birthDate()});

function birthDate() {
    $("#falseBirthDate").attr('hidden', true);
    $("#birthDate").attr('hidden', false);
    $("#birthDate").focus();
}