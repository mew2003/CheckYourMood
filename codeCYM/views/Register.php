<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CheckYourMood/codeCYM/CSS/Register.css">
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

        $allSet = true;
        $connectionSet = true;

        // if HttpHelper::getParam('username') {}

        if (isset($_POST['username']) && $_POST['username'] != "") {
            $username = htmlspecialchars($_POST['username']);
        } else {
            $username = "";
            $allSet = false;
            $connectionSet = false;
        }
        if (isset($_POST['email']) && $_POST['email'] != "") {
            $email = htmlspecialchars($_POST['email']);
            $connectionSet = false;
        } else {
            $email = "";
            $allSet = false;
        }
        if (isset($_POST['birth-date']) && $_POST['birth-date'] != "") {
            $birthDate = htmlspecialchars($_POST['birth-date']);
            $connectionSet = false;
        } else {
            $birthDate = "";
            $allSet = false;
        }
        if (isset($_POST['gender']) && $_POST['gender'] != "Choisissez votre genre") {
            $gender = htmlspecialchars($_POST['gender']);
            $connectionSet = false;
        } else {
            $gender = "Choisissez votre genre";
            $allSet = false;
        }
        if (isset($_POST['password']) && $_POST['password'] != "") {
            $password = htmlspecialchars($_POST['password']);
        } else {
            $password = "";
            $allSet = false;
            $connectionSet = false;
        }
        if (isset($_POST['confirm-password']) && $_POST['confirm-password'] != "") {
            $confirmPassword = htmlspecialchars($_POST['confirm-password']);
            $connectionSet = false;
        } else {
            $confirmPassword = "";
            $allSet = false;
        }

        
        $ok = true;
        while($row = $verifList->fetch()) {
            if ($username == $row->User_Name) {
                echo 'UserName déja utilisé';
                $ok = false;
            } else if ($email == $row->User_Email) {
                echo 'Email déja utilisé';
                $ok = false;
            }
        }
        
        if ($allSet && $ok) {
            echo "données inserées";
            
        } else if ($connectionSet) {
            echo "connection réussie";
        }

    ?>
    <div class="container">
        <div class="Main">
            <div class="Register-block">
                <div class="main-top">
                    <div class="left selection">S'inscrire</div>
                    <div class="right">Se connecter</div>
                </div>
                <form action="#" method="post" class="main-mid">
                    <input type="text" placeholder="Nom d'utilisateur" class="input-text" name="username" value=<?php echo '"'.$username.'"'?>>
                    <input type="text" placeholder="Email" class="input-text shifter" name="email" value=<?php echo '"'.$email.'"'?>>
                    <input type="date" placeholder="Date de naissance (JJ/MM/AAAA)" class="input-text shifter" name="birth-date" value=<?php echo '"'.$birthDate.'"'?>>
                    <select class="select-size input-text shifter" name="gender">
                        <option hidden>Choisissez votre genre</option>
                        <?php 
                            foreach($genderList as $i) {
                                if ($gender == $i) {
                                    echo '<option selected>'.$i.'</option>';
                                } else {
                                    echo '<option>'.$i.'</option>';
                                }
                            }
					    ?>
                    </select>
                    <input type="password" id="pass" placeholder="Mot de passe" class="input-text" name="password" value=<?php echo '"'.$password.'"'?>>
                    <input type="password" id="pass1" placeholder="Confirmer le mot de passe" class="input-text shifter" name="confirm-password" value=<?php echo '"'.$confirmPassword.'"'?>>
                    <div class="checkbox">
                        <input id="check" type="checkbox" name="check"> Afficher le Mot de passe
                    </div>
                    <input type="submit" class="input-button" name="send">
                </form>
            </div>
        </div>
        <div class="bot">
            <div class="left selection">S'inscrire</div>
            <div class="right">Se connecter</div>
        </div>
    </div>
</body>
</html> 