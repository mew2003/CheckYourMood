<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="../third-party/bootstrap\css\bootstrap.css" rel="stylesheet"/>
        <link href="..\CSS\stats.css" rel="stylesheet"/>
        <title>test php et database</title>
        <script src="../JS/header-component.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES=>false];
        
        echo "<header-component></header-component>";
    ?>
    <div>
        <canvas id="myChart"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                labels: ['Humeur_Libelle', 'Humeur_Emoji', 'Humeur_Time', 'Humeur_Description'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5,],
                    borderWidth: 1
                }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    <?php
        try{	
            $pdo=new PDO($dsn,$user,$pass,$options);		
            $requete = "SELECT * FROM Humeur";
            $resultats=$pdo->query($requete);  												
            $resultats->fetch();
            
            echo "<h1>Historique des humeurs</h1>";
            echo "<div class='container'>";
                echo "<table class='table table-striped'>";															
                    echo "<tr><td>Humeur_Libelle</td><td>Humeur_Emoji</td><td>Humeur_Time</td><td>Humeur_Description</td><tr>";		
                    while( $ligne = $resultats->fetch() ) { 	
                        echo "<tr>";												
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