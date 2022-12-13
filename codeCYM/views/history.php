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
    ?>
    </body>
</html>