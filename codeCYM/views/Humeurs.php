<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humeurs</title>
    <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/CheckYourMood/codeCYM/CSS/humeurs.css">
    <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/fontawesome-free-6.2.0-web/css/all.css">
    <script src="/CheckYourMood/codeCYM/third-party/JQuery/jquery-3.6.1.js"></script>
    <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    <script src="/CheckYourMood/codeCYM/JS/humeurs.js"></script>
</head>
<body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <div class="container">
        <div class="d-flex d-row justify-content-center">
            <span id="time"></span>
        </div>
        <div class="msgHumeur-block">
        <?php
            if(isset($msgHumeur)) {
                if($msgHumeur == "Votre humeur a bien été ajouté.") {
                    echo "<p class='enVert'>".$msgHumeur."</p>";
                } else {
                    echo "<p class='enRouge'>".$msgHumeur."</p>";
                }
                $_SESSION['msgHumeur'] = null;
            }
        ?>
        </div>
        <form class="humeurs-container" action="#" method="get">
            <input hidden name="action" value="setHumeur">
            <input hidden name="controller" value="humeurs">
            <div class="row border-form">
                <div class="col col-md-8 col-9">
                    <input class="humeurs-liste" list="humeurs-liste" name="humeur" oninput="getSmiley(this)" placeholder="Saisissez votre humeur (ex. Joie)">
                    <datalist id="humeurs-liste">
                        <?php
                            foreach ($listeHumeurs as $i) {
								echo "<option value='".$i."'></option>";
							}
                        ?>
                    </datalist>
                </div>
                <div class="col col-md-2 col-3 smiley-zone">
                    <input name="smiley" id="smiley" readonly placeholder="❔">
                </div>
                <div class="col col-md-2 col-12 envoyer-zone">
                    <button class="bouton-envoyer"><i class="fa-solid fa-location-arrow"></i></button>
                </div>
                <div class="col col-12 description-zone">
                    <textarea name="description" placeholder="Décrivez un contexte actuel (ex. Je viens de remporter l'euro million !)"></textarea>
                </div>
            </div>
        </form>
    </div>
</body>
</html>