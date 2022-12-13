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
                    $genderList = array("Homme", "Femme", "Autre"); // liste des genres disponibles
                    if($update) {
                        // Erreur si le mail est vide 
                        if(empty($email)) {
                            echo '<input class="form-control enRouge" type="email" name="email" placeholder="Votre email ne peut pas être vide"></input>';
                        } else {
                            echo '<input class="form-control input-text" type="email" name="email" placeholder="Email" value='.$email.'></input>';
                        }
                        // Erreur si le pseudo est vide
                        if(empty($username)) {
                            echo '<input class="form-control enRouge" type="text" name="username" placeholder="Votre pseudo ne peut pas être vide"></input>';
                        } else {
                            echo '<input class="form-control input-text" type="text" name="username" placeholder="Pseudo" value='.$username.'></input>';
                        }
                        echo '<input class="form-control input-text" type="date" name="birthDate" placeholder="Pseudo" value='.$birthDate.'></input>';
                    } else {
                        // affichage des infos de l'utilisateur courant dans les champs
                        echo '<input class="form-control input-text" type="email" name="email" placeholder="Email" value='.$defaultEmail.'></input>';
                        echo '<input class="form-control input-text" type="text" name="username" placeholder="Pseudo" value='.$defaultUsername.'></input>';
                        echo '<input class="form-control input-text" type="date" name="birthDate" placeholder="Pseudo" value='.$defaultBirthDate.'></input>';
                    }
                    echo "<select class='input-text' name='genderList'>";
                    foreach($genderList as $i) {
                        if($genderChanged) {
                            if ($gender == $i) {
                                echo '<option selected>'.$i.'</option>';
                            } else {
                                echo '<option>'.$i.'</option>';
                            }
                        } else {
                            if ($defaultGender == $i) {
                                echo '<option selected>'.$i.'</option>';
                            } else {
                                echo '<option>'.$i.'</option>';
                            }
                        }
                    }
                    echo "</select>";
                    echo '<input class="button" name="envoyer" type="submit" value="Confirmer"></input>';
                    echo $message;
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