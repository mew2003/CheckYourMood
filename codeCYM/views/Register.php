<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CheckYourMood/codeCYM/CSS/Register.css">
    <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <script src="/CheckYourMood/codeCYM/third-party/JQuery/jquery-3.6.1.js"></script>
    <script src="/CheckYourMood/codeCYM/JS/burger-menu.js" defer></script>
    <script src="/CheckYourMood/codeCYM/JS/register.js" defer></script>
    <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    <title>Enregistrement</title>
</head>
<body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <?php
        $genderList = array("Homme", "Femme", "Autre");

        if (isset($loginError) && $loginError != "") {
            echo "<div id='loginError' class='error'>".$loginError."</div>";
        } else {
            echo "<div id='loginError'></div>";
        }
        if (isset($registerError) && $registerError != "") {
            echo "<div id='registerError' class='error'>".$registerError."</div>";
        } else {
            echo "<div id='registerError'></div>";
        }

    ?>
    
    <div class="container">
        <div class="Main">
            <div class="Register-block">
                <div class="main-top">
                    <div class="left" id="test">S'inscrire</div>
                    <div class="right selection">Se connecter</div>
                </div>
                <form action="#" method="get" class="main-mid">
                    <input hidden id="action" name="action" value="login">
                    <input hidden name="controller" value="register">
                    <input type="text" placeholder="Nom d'utilisateur" class="input-text" name="username" value=<?php if (isset($username)) echo '"'.$username.'"'?>>
                    <input type="text" placeholder="Email" class="input-text shifter  display-none" name="email" value=<?php if (isset($email)) echo '"'.$email.'"'?>>
                    <input type="date" placeholder="Date de naissance (JJ/MM/AAAA)" class="input-text shifter display-none" name="birth-date" value=<?php if (isset($birthDate)) echo '"'.$birthDate.'"'?>>
                    <select class="select-size input-text shifter display-none" name="gender">
                        <option hidden>Choisissez votre genre</option>
                        <?php 
                            foreach($genderList as $i) {
                                if (isset($gender)) {
                                    if ($gender == $i) {
                                        echo '<option selected>'.$i.'</option>';
                                    } else {
                                        echo '<option>'.$i.'</option>';
                                    }
                                } else {
                                    echo '<option>'.$i.'</option>';
                                }
                            }
					    ?>
                    </select>
                    <input type="password" id="pass" placeholder="Mot de passe" class="input-text" name="password" value=<?php if (isset($password)) echo '"'.$password.'"'?>>
                    <input type="password" id="pass1" placeholder="Confirmer le mot de passe" class="input-text shifter display-none" name="confirm-password" value=<?php if (isset($confirmPassword)) echo '"'.$confirmPassword.'"'?>>
                    <div class="checkbox">
                        <input id="check" type="checkbox" name="check"> Afficher le Mot de passe
                    </div>
                    <input type="text" id="login" name="login" value="1" hidden>
                    <input type="submit" class="input-button" name="send">
                </form>
            </div>
        </div>
        <div class="bot">
            <div class="left">S'inscrire</div>
            <div class="right selection">Se connecter</div>
        </div>
    </div>
</body>
</html> 