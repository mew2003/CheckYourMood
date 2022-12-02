<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="/CheckYourMood/codeCYM/CSS/editpassword.css" rel="stylesheet"/>
    <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
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
                    if(isset($_POST['envoyer'])) {
                        $envoyer = $_POST['envoyer'];
                    } else {
                        $envoyer = "";
                    }
                    if(isset($_POST['oldPassword']) && !empty($_POST['oldPassword'])) {
                        $oldPassword = $_POST['oldPassword'];
                    } else {
                        $oldPassword = "";
                    }
                    if(isset($_POST['newPassword']) && !empty($_POST['newPassword'])) {
                        $newPassword = $_POST['newPassword'];
                    } else {
                        $newPassword = "";
                    }
                    if(isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])) {
                        $confirmPassword = $_POST['confirmPassword'];
                    } else {
                        $confirmPassword = "";
                    }
                    $testOldPasswords = !empty($oldPassword) && strcmp($password, $oldPassword) == 0;
                    $testNewPasswords = !empty($newPassword) && !empty($confirmPassword) && strcmp($newPassword, $confirmPassword) == 0;
                    if(!empty($envoyer) && empty($oldPassword) || !empty($envoyer) && $testOldPasswords == false) {
                        echo '<input class="form-control enRouge" type="text" name="oldPassword" placeholder="Veuillez mettre votre ancien mot de passe" value='.$oldPassword.'></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="oldPassword" placeholder="Ancien mot de passe"></input>';
                    }
                    if(!empty($envoyer) && empty($newPassword)) {
                        echo '<input class="form-control enRouge" type="text" name="newPassword" placeholder="Votre nouveau mot de passe ne peut pas être vide"></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="newPassword" placeholder="Nouveau mot de passe"></input>';
                    }
                    if(!empty($envoyer) && empty($confirmPassword) || !empty($envoyer) && $testNewPasswords == false) {
                        echo '<input class="form-control enRouge" type="text" name="confirmPassword" placeholder="Veuillez confirmer votre nouveau mot de passe"></input>';    
                    } else {
                        echo '<input class="form-control" type="text" name="confirmPassword" placeholder="Confirmez votre mot de passe"></input>';
                    }
                    echo '<input class="button" name="envoyer" type="submit" value="Confirmer"></input>';
                    if(!empty($envoyer) && $envoyer = "Confirmer" && $testOldPasswords && $testNewPasswords) {
                        echo '<p class="enVert">Votre mot de passe a bien été modifié</p>';
                    }
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