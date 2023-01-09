<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="/CheckYourMood/codeCYM/CSS/deleteaccount.css" rel="stylesheet"/>
    <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    <title>Modification du profil</title>
</head>
<body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <div class="container">
        <div class="row main">
            <h1 class="enRouge" style="text-align: center">Suppression du compte terminée</h1>
            <div class="d-flex flex-row align-items-center justify-content-center">
                <form method="get" action="#">
                    <input type="submit" class="button" value="Retour à l'accueil">
                    <input hidden name="action" value="index">
                    <input hidden name='controller' value='home'>
                </form>
            </div>
        </div>
        <div clas="row">

        </div>
    </div>
</body>
</html>