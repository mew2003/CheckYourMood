<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Register.css">
    <script src="../JS/header-component.js" defer></script>
    <script src="../JS/burger-menu.js" defer></script>
    <script src="../JS/register.js" defer></script>
    <title>Enregistrement</title>
</head>
<body>
    <?php
        $host='localhost';	    // Serveur de BD
        $db='CYM';		        // Nom de la BD
        $user='root';		    // User 
        $pass='root';		    // Mot de passe
        $charset='utf8mb4';	    // charset utilisé
        
        // Constitution variable DSN
        $dsn="mysql:host=$host;dbname=$db;charset=$charset";

        // Réglage des options
		$options=[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES=>false];

        try {
            $pdo=new PDO($dsn,$user,$pass,$options);
        }catch(PDOException $e){
            //Il y a eu une erreur
            echo "<h1>Erreur BD ".$e->getMessage();
        }
    ?>
    <header-component></header-component>
    <?php
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password'])
            && trim($_POST['username']) != "" && trim($_POST['email']) != "" && trim($_POST['password']) != ""
            && trim($_POST['confirm-password']) != "") {
            
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $confirm_password = htmlspecialchars($_POST['confirm-password']);

            $verifUserName = ($pdo->query('SELECT User_Name FROM user'));
            $verifUserEmail = ($pdo->query('SELECT User_Email FROM user'));
            $ok = true;
            while($row = $verifUserName->fetch()) {
                if ($username == $row['User_Name']) {
                    echo 'UserName déja utilisé';
                    $ok = false;
                }
            }
            while($row = $verifUserEmail->fetch()) {
                if ($email == $row['User_Email']) {
                    echo 'Email déja utilisé';
                    $ok = false;
                }
            }
            if ($password == $confirm_password && $ok == true) {
                $stmt = $pdo->prepare('INSERT INTO user (User_Name,User_Email,User_Password) VALUES (:username,:email,:pswd)');
                $stmt->execute(array('username'=>$username,'email'=>$email,'pswd'=>$password));
                echo "ça tue";
            }
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
                    <input type="text" placeholder="Nom d'utilisateur" class="input-text" name="username">
                    <input type="text" placeholder="Email" class="input-text shifter" name="email">
                    <input type="text" placeholder="Date de naissance (JJ/MM/AAAA)" class="input-text shifter" name="birth-date">
                    <select class="select-size input-text shifter" name="gender">
                        <option hidden>Choisissez votre genre</option>
                        <option>Homme</option>
                        <option>Femme</option>
                        <option>Chaise</option>
                        <option>hélicoptère</option>
                        <option>caillou</option>
                    </select>
                    <input type="password" id="pass" placeholder="Mot de passe" class="input-text" name="password">
                    <input type="password" id="pass1" placeholder="Confirmer le mot de passe" class="input-text shifter" name="confirm-password">
                    <div class="checkbox">
                        <input id="check" type="checkbox" name="check"> Afficher le Mot de passe
                    </div>
                    <input type="submit" class="input-button" name="send">
                </form>
            </div>
        </div>
        <div class="bot">
            <div class="left selection">S'enregistrer</div>
            <div class="right">Se connecter</div>
        </div>
    </div>
</body>
</html>

