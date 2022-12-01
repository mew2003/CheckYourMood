<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap\css\bootstrap.css" rel="stylesheet"/>
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
    <?php 
        echo "<header-component></header-component>";
        
    ?>
    <canvas id="myChart"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                labels: <?php 
                $i = 0;
                    while ($row = $MaxHumeur->fetchColumn()) {
                        if($i == 0) {
                            echo "[";
                        }
                        echo "\"$row\",";
                        if ($i == 3) {
                            echo "]";
                        }
                        $i++;
                    }
                ?>,
                datasets: [{
                    label: 'Les 4 Humeurs les plus prédominante chez vous',
                    data: <?php 
                        $i = 0;
                        while ($row = $MaxValHum->fetchColumn()) {
                            if($i == 0) {
                                echo "[";
                            }
                            echo "\"$row\",";
                            if ($i == 3) {
                                echo "]";
                            }
                            $i++;
                        }
                    ?>,
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
    ?>
    </body>
</html>