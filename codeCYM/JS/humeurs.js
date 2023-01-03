function refreshTime() {
    const timeDisplay = document.getElementById("time");
    const dateString = new Date().toLocaleTimeString();
    timeDisplay.textContent = dateString;
}
setInterval(refreshTime, 1000);

function getSmiley(element) {
    var saisie = (element.value || element.options[element.selectedIndex].value); 
    switch ((""+saisie).toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "")) {
        case 'admiration': smiley = "😊"; break;
        case 'adoration': smiley = "🤤"; break;
        case 'appreciation esthetique': smiley = "🖼️"; break;
        case 'amusement': smiley = "🥳"; break;
        case 'colere': smiley = "😠"; break;
        case 'anxiete': smiley = "😰"; break;
        case 'emerveillement': smiley = "🤩"; break;
        case 'malaise (embarrassement)': smiley = "😖"; break;
        case 'ennui': smiley = "🥱"; break;
        case 'calme (serenite)': smiley = "😐"; break;
        case 'confusion': smiley = "😕"; break;
        case 'envie (craving)': smiley = "🥵"; break;
        case 'degout': smiley = "🤢"; break;
        case 'douleur empathique': smiley = "💔"; break;
        case 'interet etonne, intrigue': smiley = "🤔"; break;
        case 'excitation (montee d’adrenaline)': smiley = "🤪"; break;
        case 'peur': smiley = "😨"; break;
        case 'horreur': smiley = "😱"; break;
        case 'interet': smiley = "🧐"; break;
        case 'joie': smiley = "😄"; break;
        case 'nostalgie': smiley = "🎆"; break;
        case 'soulagement': smiley = "😌"; break;
        case 'romance': smiley = "🌹"; break;
        case 'tristesse': smiley = "😥"; break;
        case 'satisfaction': smiley = "👍"; break;
        case 'desir sexuel': smiley = "😏"; break;
        case 'surprise': smiley = "🙀"; break;
        default:
            smiley = "🚫";
    }
    var test = document.getElementById('smiley')

    test.value = smiley;
}