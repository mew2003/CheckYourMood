<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="/CheckYourMood/codeCYM/CSS/editprofile.css" rel="stylesheet"/>
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
        <div class="row">
            <form class="main" method="post">
                <?php
                    if(isset($_POST['envoyer'])) {
                        $envoyer = $_POST['envoyer'];
                    } else {
                        $envoyer = "";
                    }
                    if(isset($_POST['email']) && !empty($_POST['email'])) {
                        $email = $_POST['email'];
                    } else {
                        $email = "";
                    }
                    if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {
                        $pseudo = $_POST['pseudo'];
                    } else {
                        $pseudo = "";
                    }
                    if(!empty($envoyer) && empty($email)) {
                        echo '<input class="form-control enRouge" type="text" name="email" placeholder="Votre email ne peut pas être vide"></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="email" placeholder="Email" value='.$email.'></input>';
                    }
                    if(!empty($envoyer) && empty($pseudo)) {
                        echo '<input class="form-control enRouge" type="text" name="pseudo" placeholder="Votre pseudo ne peut pas être vide"></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="pseudo" placeholder="Pseudo" value='.$pseudo.'></input>';
                    }
                    echo '<input class="button" name="envoyer" type="submit" value="Confirmer"></input>';
                    if(!empty($envoyer) && !empty($email) && !empty($pseudo)) {
                        echo '<p class="enVert">Vos informations ont bien été modifiées</p>';
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