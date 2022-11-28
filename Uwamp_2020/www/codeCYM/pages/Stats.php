<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="../third-party/bootstrap\css\bootstrap.css" rel="stylesheet"/>
        <link href="..\CSS\stats.css" rel="stylesheet"/>
        <title>test php et database</title>
        <script src="../JS/header-component.js" defer></script>
    </head>
    <body>
    <?php 
        $host='localhost';	// Serveur de BD
        $db='CYM';		// Nom de la BD
        $user='root';		// User 
        $pass='root';		// Mot de passe
        $charset='utf8mb4';	// charset utilisé
        
        // Constitution variable DSN
        $dsn="mysql:host=$host;dbname=$db;charset=$charset";
        
        // Réglage des options
        $options=[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES=>false];
        try{	
            $pdo=new PDO($dsn,$user,$pass,$options);		
            $requete = "SELECT CODE_User, Humeur_Libelle, Humeur_Emoji, Humeur_Time, Humeur_Description FROM Humeur";
            $resultats=$pdo->query($requete);  												
            $resultats->setFetchMode(PDO::FETCH_OBJ);
            
            echo "<header-component></header-component>";
            echo "<h1>Historique des humeurs</h1>";
            echo "<div class='container'>";
                echo "<table class='table table-striped'>";															
                    echo "<tr><td>CODE_User</td><td>Humeur_Libelle</td><td>Humeur_Emoji</td><td>Humeur_Time</td><td>Humeur_Description</td><tr>";		
                    while( $ligne = $resultats->fetch() ) { 	
                        echo "<tr>";												
                        echo "<td>".$ligne->CODE_User."</td>";	
                        echo "<td>".$ligne->Humeur_Libelle."</td>";
                        echo "<td>".$ligne->Humeur_Emoji."</td>";
                        echo "<td>".$ligne->Humeur_Time."</td>";
                        echo "<td>".$ligne->Humeur_Description."</td>";	
                        echo "<tr>";														
                    }
                echo "</table>" ;
            echo "</div>";	
        } catch(PDOException $e){
            echo "<h1>Erreur BD ".$e->getMessage();
        }
    ?>
    </body>
    </html>