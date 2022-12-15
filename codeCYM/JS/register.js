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
        document.getElementById('pass').type='text';
        document.getElementById('pass1').type='text';
    } else {
        document.getElementById('pass').type='password';
        document.getElementById('pass1').type='password';
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
            /* sinon ajoute la classe 'selection' à la div et la retire à la div 'connection' */
            $(".left").addClass('selection');
            $(".right").removeClass('selection');
            /* change la valeur de 'action' pour que le bouton valider du formulaire appel la bonne fonction du controller */
            action.value = "register";
            /* change la valeur de 'login' pour que l'utilisateur ne puisse pas se connecter depuis l'inscription */
            login.value = 0;
            /* remet toutes les valeurs déjà saisie dans les champs et réaffiche les champs qui n'étaient pas affiché 
               en leur enlevant la classe 'display-none' */
            console.log(registerTab[0].className.match('selection'));
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

/**
 * Permet de changer le mode de inscription à connexion
 */
function loginSelected() {
    connectionTab.forEach((elementConnection) => {
        /* Vérifie pour chaque div 'register' (celle pour la version pc, tablettes et celle pour la version téléphone)
           si la div a la classe 'selection' si c'est le cas ne fait rien */
        if (!(elementConnection.className.match('selection'))) {
            $(".left").removeClass('selection');
            $(".right").addClass('selection');
            action.value = "login";
            login.value = 1;
            console.log(registerTab[0].className.match('selection'));
            shifterElements.forEach((element) => {
                valuesSE.push(element.value);
                element.value = '';
                element.classList.add('display-none');
            });
        }
    });
}

