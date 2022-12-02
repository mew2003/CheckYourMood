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
    <canvas id="myDonuts"></canvas>
        </div>
        <script>
// ###################################################################################################
// ##  Mon Graphe à Bar  #############################################################################
// ###################################################################################################
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
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
                        label: 'Les 4 humeurs les plus présente chez vous',
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
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 40
                            }
                        }]
                    }
                }
            });
// ###################################################################################################
// #####  Mon donuts   ###############################################################################
// ###################################################################################################
            var ctxDonuts = document.getElementById("myDonuts");
            const data = {
                labels:<?php 
                    $i = 1;  
                    $counter = $TotalOfHumeur->fetchColumn();
                        while ($row = $AllHumeur->fetchColumn()) {
                            if($i == 1) {
                                echo "[";
                            }
                            echo "\"$row\",";
                            if ($i == $counter) {
                                echo "]";
                            }
                            $i++;
                        }
                    ?>,
                datasets: [{
                    label: 'Toute vos humeurs',
                    data: <?php 
                        $i = 1;
                        while ($row = $AllHumeurData->fetchColumn()) {
                            if($i == 1) {
                                echo "[";
                            }
                            echo "\"$row\",";
                            if ($i == $counter) {
                                echo "]";
                            }
                            $i++;
                        }
                    ?>,
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            };
            var myDonuts = new Chart(ctxDonuts, {
                type: 'doughnut',
                data: data,
            });
        </script>
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