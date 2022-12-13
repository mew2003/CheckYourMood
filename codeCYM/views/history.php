<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/stats.css" rel="stylesheet"/>
        <title>test php et database</title>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <?php
        echo "<h1>Historique des humeurs</h1>";
        echo "<div class='container'>";
            echo "<table class='table table-striped'>";															
                echo "<tr><td>Libelle de l'humeur</td><td>Emoji associé</td><td>Date / Heure</td><td>Description</td><tr>";		
                while( $ligne = $resultats->fetch() ) { 
                    echo "<tr>";												
                    echo "<td>".htmlspecialchars($ligne->Humeur_Libelle)."</td>";
                    echo "<td>".htmlspecialchars($ligne->Humeur_Emoji)."</td>";
                    echo "<td>".htmlspecialchars($ligne->Humeur_Time)."</td>";  
                    echo "<td>".htmlspecialchars($ligne->Humeur_Description)."</td>";	
                    echo "<tr>";														
                }
            echo "</table>" ;
        echo "</div>";	
    ?>
    </body>
</html>