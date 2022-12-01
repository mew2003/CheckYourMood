<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/Account.css" rel="stylesheet"/>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
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
                while($row = $resultats->fetch()) {
                    $mail = $row->User_Email;
                    $username = $row->User_Name;
                    $password = $row->User_Password;

                }
                echo '<div class="col-md-6 col-sm-8 col-xs-12 d-grid gap-3">';
                    echo "<h1>Profil</h1>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                        echo "<h2>Email :</h2>";
                        echo "<h4>".$mail."</h4>";
                    echo "</div>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                        echo "<h2>Nom d'utilisateur :</h2>";
                        echo "<h4>".$username."</h4>";
                    echo "</div>";
                    echo '<div class="form-control d-flex flex-row align-items-center gap-2">';
                        echo "<h2>Mot de passe : </h2>";
                        echo "<h4>***********</h4>";
                    echo "</div>";
                echo "</div>"; 
            ?>
                <div class="col-md-6 col-sm-4 d-flex justify-content-md-end justify-content-sm-end justify-content-center align-items-start">
                    <div class="row col-xs-hidden flex-md-row flex-sm-column justify-content-between justify-content-sm-center justify-content-between" style="padding: 10px;">
                        <input class="button col-md-6 col-sm-12" type="button" value="Modifier le mot de passe"/>
                        <input class="button col-md-6 col-sm-12" type="button" value="Modifier le profil"/>
                    </div>
                </div>
            </div>
            <input class="buttonD" type="button" value="Désinscription"/>
        </div>
    </body>
    </html>