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
    <canvas id="myChart"></canvas>
    <canvas id="myDonuts"></canvas>
    <canvas id="bar-chart" width="1200" height="800"></canvas>
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
        <script>
            // Bar chart
            new Chart(document.getElementById("bar-chart"), {
                type: 'bar',
                data: {
                labels: ["dégoût", "joie", "suicide", "a", "b", "c", "d", "e"],
                datasets: [
                    {
                    label: "Population (millions)",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                    data: [12, 4, 25, 1, 2, 3, 4, 5]
                    }
                ]
                },
                options: {
                responsive: false,
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Predicted world population (millions) in 2050'
                }
                }
            });
        </script>
    </body>
</html>