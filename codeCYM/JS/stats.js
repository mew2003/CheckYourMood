$("#startDate").on('focus', function() { toDate($("#startDate")) });
$("#endDate").on('focus', function() { toDate($("#endDate")) });


$("#startDate").on('blur', function() { 
    if (!champValide($("#startDate"), "")) {
        // si le champ est vide le remet en type 'text'
        $("#startDate").attr('type', 'text');
    }
 });
$("#endDate").on('blur', function() { 
    if (!champValide($("#endDate"), "")) {
        // si le champ est vide le remet en type 'text'
        $("#endDate").attr('type', 'text');
    } 
});

/**
 * Transforme le champ 'Date de naissance' en champ de type date
 */
function toDate(date) {
    date.attr('type', 'date');
}

/**
 * Vérifie si un champ contient une certaine valeur, 
 * sert plus spécifiquement à vérifier si un champ est vide ou si il contient sa valeur par défaut
 * @param {*} champ  le champ à vérifier
 * @param {*} value  la valeur par défaut à vérifier (vide si il n'y a pas de valeur particulière par défaut)
 * @returns true si le champ est rempli, sinon false si il est vide ou qu'il a une valeur par défaut
 */
function champValide(champ, value) {
    if (champ.val() == value) {
      // Le champ est vide, donc il est invalide, il passe en rouge
      champ.addClass('input-error');
      return false;
    } else {
      // Le champ n'est pas vide, donc il est valide, il reste/repasse en vert et renvoi
      champ.removeClass('input-error');
      return true;
    }
}




