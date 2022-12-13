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
                    // Erreur si le mail est vide 
                    if(!empty($envoyer) && empty($email)) {
                        echo '<input class="form-control enRouge" type="text" name="email" placeholder="Votre email ne peut pas être vide"></input>';
                    } else if ($mailChanged) {
                        echo '<input class="form-control" type="text" name="email" placeholder="Email" value='.$email.'></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="email" placeholder="Email" value='.$defaultEmail.'></input>';
                    }
                    if(!empty($envoyer) && empty($pseudo)) {
                        echo '<input class="form-control enRouge" type="text" name="pseudo" placeholder="Votre pseudo ne peut pas être vide"></input>';
                    } else if($usernameChanged) {
                        echo '<input class="form-control" type="text" name="pseudo" placeholder="Pseudo" value='.$pseudo.'></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="pseudo" placeholder="Pseudo" value='.$defaultPseudo.'></input>';
                    }
                    if(!empty($envoyer) && empty($dateOfBirth)) {
                        echo '<input class="form-control enRouge" type="date" name="dateOfBirth" placeholder="Votre date de naissance doit respecter le format suivant : AAAA/MM/JJ"></input>';
                    } else if($birthDateChanged) {
                        echo '<input class="form-control" type="date" name="dateOfBirth" placeholder="Pseudo" value='.$dateOfBirth.'></input>';
                    } else {
                        echo '<input class="form-control" type="date" name="dateOfBirth" placeholder="Pseudo" value='.$defaultDateOfBirth.'></input>';
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