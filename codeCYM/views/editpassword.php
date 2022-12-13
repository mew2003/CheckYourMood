<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="/CheckYourMood/codeCYM/CSS/editpassword.css" rel="stylesheet"/>
    <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    <script src="/CheckYourMood/codeCYM/JS/accounts.js" defer></script>
    <title>Modification du mot de passe</title>
</head>
<body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <div class="container">
        <div class="row">
            <form class="main" method="post">
                <?php
                    if($update) {
                        if($testOldPasswords == false) {
                            echo '<input class="form-control enRouge" type=password id="oldPassword" name="oldPassword" placeholder="Vous devez mettre votre ancien mot de passe"></input>';
                        } else {
                            echo '<input class="form-control" type=password id="oldPassword" name="oldPassword" placeholder="Ancien mot de passe"></input>';
                        }
                        if($testNewPasswords == false && $testOldPasswordsNotSameAsNew == false) {
                            echo '<input class="form-control enRouge" type=password id="newPassword" name="newPassword" placeholder="Mettez un nouveau mot de passe"></input>';
                            echo '<input class="form-control enRouge" type=password id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre nouveau mot de passe"></input>';
                        } else {
                            echo '<input class="form-control" type=password id="newPassword" name="newPassword" placeholder="Nouveau mot de passe"></input>';
                            echo '<input class="form-control" type=password id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe"></input>';
                        }
                    } else {
                        echo '<input class="form-control" type=password id="oldPassword" name="oldPassword" placeholder="Ancien mot de passe"></input>';
                        echo '<input class="form-control" type=password id="newPassword" name="newPassword" placeholder="Nouveau mot de passe"></input>';
                        echo '<input class="form-control" type=password id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe"></input>';
                    }
                    echo '<input class="button" name="envoyer" type="submit" value="Confirmer"></input>';
                    echo '<p class="enVert">'.$message.'</p>';
                ?>
            </form>
        </div>
        <div clas="row">
            <form method="get" action="#">
                <input type="submit" class="button" value="Retour">
                <input hidden name="action" value="index">
                <input hidden name='controller' value='accounts'>
            </form>
        </div>
    </div>
</body>
</html>