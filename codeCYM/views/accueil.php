<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/CSS/menu.css">
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css">
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
        <title>Menu</title>
    </head>
    <body>
        <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
        ?>
        <header-component></header-component>  
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <br><br><br><br><br>
                    <h1>Check Your Mood</h1>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-2">
                </div>
                <div class="col-md-4 col-sm-8">
                    Check Your Mood est une application vous permettant
                    à tout moment indiquer vos émotions à différents
                    moments de la journée, consulter ces dernières
                    pour suivre l’évolution de votre humeur.
                    Les émotions se basent sur
                    <a class="liensTravaux" href="https://www.pnas.org/doi/10.1073/pnas.1702247114" target="_blank">
                        l’étude de Alan S. Cowenet Dacher Keltner</a>, répertoriant un total de 27 émotions.
                </div>
                <div class="col-md-4 col-sm-2">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 col-md-3">
                </div>
                <div class="col-sm-10 col-md-6 texteInscription">
                    Pour commencer à enregistrer vos émotions 
                    <a class="liensTravaux" href="../pages/Register.php">inscrivez-vous</a> ou 
                    <a class="liensTravaux" href="../pages/Register.php">connectez-vous</a>
                </div>
                <div class="col-sm-1 col-md-3">
                </div>
            </div>
        </div>
    </body>
</html>