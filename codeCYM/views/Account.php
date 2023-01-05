<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/Account.css" rel="stylesheet"/>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
        <script src="/CheckYourMood/codeCYM/JS/accounts.js" defer></script>
        <title>Account</title>
    </head>
    <body>
        <?php
            spl_autoload_extensions(".php");
            spl_autoload_register();
        ?>
        <header-component></header-component>
        <div class="main-container">
            <div class="row main">  
            <?php
                echo '<div class="col-md-6 col-sm-8 col-xs-12 d-grid gap-3">';
                    echo "<h1>Profil</h1>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2 centrer">';
                            echo "<h2>Email :</h2>";
                            echo "<h2>".$mail."</h2>";
                    echo "</div>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                        echo "<h2>Nom d'utilisateur :</h2>";
                        echo "<h2>".$username."</h2>";
                    echo "</div>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                        echo "<h2>Mot de passe : </h2>";
                        echo "<h2>***********</h2>";
                    echo "</div>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                        echo "<h2>Date de naissance :</h2>";
                        echo "<h2>".$birthDate."</h2>";
                    echo "</div>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                    echo "<h2>Genre :</h2>";
                    echo "<h2>$gender</h2>";
                echo "</div>";
            echo "</div>"; 
            ?>
                <div class="col-md-6 col-sm-4 d-flex justify-content-md-end justify-content-sm-end justify-content-center align-items-start">
                    <div class="row col-xs-hidden flex-md-row flex-sm-column justify-content-between justify-content-sm-center justify-content-between" style="padding: 10px;">
                    <form method="get" action="#">
                        <input hidden name="action" value="editPassword">
                        <input hidden name="controller" value="accounts">
                        <input class="form-control button" type="submit" value="Modifier le mot de passe"/></input>
                    </form>
                    <form method="get" action="#">
                        <input hidden name="action" value="editProfile">
                        <input hidden name="controller" value="accounts">
                        <input class="form-control button" type="submit" value="Modifier le profil"/>
                    </form>
                    </div>
                </div>
            </div>
            <div class="d-flex d-row row justify-content-evenly gap-2">
                <form method="get" action="#" class='col-md-3 col-sm-3 col-xs-4'>
                    <input hidden name="action" value="deleteAccount">
                    <input hidden name="controller" value="accounts">
                    <input class="buttonD" type="submit" value="Supprimer le compte"/>
                </form>
                <form method="get" action="#" class='col-md-3 col-sm-3 col-xs-4'>
                    <input hidden name="action" value="disconnect">
                    <input hidden name="controller" value="accounts">
                    <input class="buttonD" type="submit" value="Déconnexion"/>
            </form>
            </div>
        </div>
    </body>
    </html>