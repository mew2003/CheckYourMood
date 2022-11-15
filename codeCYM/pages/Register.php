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
    <div class="container">
        <div class="Main">
            <div class="Register-block">
                <div class="main-top">
                    <button class="left selection" id="register">S'enregistrer</button>
                    <button class="right" id="connect">Se connecter</button>
                </div>
                <form action="#" method="post" class="main-mid">
                    <input type="text" placeholder="Nom d'utilisateur" class="input-text" name="username">
                    <input type="text" placeholder="Email" class="input-text shifter-mail" name="email">
                    <input type="text" placeholder="Mot de passe" class="input-text" name="password">
                    <input type="text" placeholder="Confirmer le mot de passe" class="input-text shifter-confirm" name="confirm-password">
                    <input type="submit" class="input-button" name="send">
                </form>
            </div>
        </div>
        <div class="bot">
            <div class="left-bot selection">S'enregistrer</div>
            <div class="right-bot">Se connecter</div>
        </div>
    </div>
</body>
</html>