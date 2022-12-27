<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/stats.css" rel="stylesheet"/>
        <title>test php et database</title>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="/JS/humeurs.js"></script>
    </head>
    <body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
   
    <table>
        <tr class="title">
            <td class="top-float-part">
                <form class="top-float-part" action="#" method="get">
                    <input hidden id="action" name="action" value="optionSelected">
                    <input hidden name="controller" value="stats">
                    <div class="date-selector">
                        <label>Date début:</label>
                        <input Type="date" name="startDate" value="<?php 
                            if (isset($startDate)) {
                                echo $startDate;
                            }
                        ?>">
                    </div>
                    <div class="date-selector">
                        <label>Date fin:</label>
                        <input Type="date" name="endDate" value="<?php 
                            if (isset($endDate)) {
                                echo $endDate;
                            }
                        ?>">
                    </div>
                    <select name="humeurs">
                        <label>Humeurs</label>
                        <option>TOUS</option>
                        <?php 
                            foreach ($listeHumeurs as $row) {
                                if (isset($humeurs)) {  
                                    if ($humeurs == $row) {
                                        echo "<option selected>".$row."</option>";
                                    } else {
                                        echo "<option>".$row."</option>";
                                    }
                                } else { 
                                    echo "<option>".$row."</option>";
                                }
                            }
                        ?>
                    </select>
                    <div class="date-selector">
                        <input type="submit" class="btn bouton">
                    </div>
                </form>
            </td>
            <td class="top-const-part">
                <h1>All Time</h1>
            </td>
        </tr>
        <tr class="second-part">
            <td class="mid-float-part">
                <div class="chart-container" style="position: relative; height:40vh;">
                    <canvas id="myLineChart"></canvas>
                </div>
                <?php
                    $countRow = $valueByDate1->rowCount();
                ?>
                <script>
                    const ctx1 = document.getElementById('myLineChart');
                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: <?php 
                                        $i = 0;
                                        while ($row = $valueByDate1->fetch()) {
                                            if($i == 0) {
                                                echo "[";
                                            }
                                            echo "\"$row->Date\",";
                                            if ($i == $countRow - 1) {
                                                echo "]";
                                            }
                                            $i++;
                                        }
                                    ?>,
                            datasets: [{
                                label: <?php echo "'$humeurSelected'" ?>,
                                data: <?php 
                                            $i = 0;
                                            while ($row2 = $valueByDate2->fetch()) {
                                                if($i == 0) {
                                                    echo "[";
                                                }
                                                echo "\"$row2->nombreHumeur\",";
                                                if ($i == $countRow - 1) {
                                                    echo "]";
                                                }
                                                $i++;
                                            }
                                        ?>,
                                borderWidth: 1,
                                borderColor: 'rgb(0, 0, 0)',
                                backgroundColor: [
                                    '#00ff7f',
                                    '#dc143c',
                                    '#00bfff',
                                    '#0000ff',
                                    '#8b008b',
                                    '#b03060',
                                    '#ff0000',
                                    '#ffd700',
                                    '#ff00ff',
                                    '#1e90ff',
                                    '#eee8aa',
                                    '#00ffff',
                                    '#b0e0e6',
                                    '#ff1493',
                                    '#ee82ee',
                                    '#ffb6c1',
                                    '#00008b',
                                    '#556b2f',
                                    '#0000ff',
                                    '#8b4513',
                                    '#483d8b',
                                    '#3cb371',
                                    '#b8860b',
                                    '#7fff00',
                                    '#8a2be2',
                                    '#ff7f50',
                                    '#008b8b',
                                    '#9acd32',
                                    '#00bfff',
                            ],
                            tension: 0.1
                            }]
                        },
                        options: {
                            indexAxis: 'x',
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        },
                    });
                </script>
            </td>
            <td class="mid-const-part">
                <?php
                    if ($MaxHumeur == "Vous n'avez saisie aucune humeur !!!") {
                        echo "<h1>🤔</h1>";
                        echo "<h1>$MaxHumeur</h1>";
                    } else {
                        $ligne = $MaxHumeur->fetch();
                        $stockerSmiley = $ligne->Humeur_Emoji;
                        $stocker = $ligne->compteur;
                        $stockerLib = $ligne->Humeur_Libelle;
                        echo "<div class='smiley'>$stockerSmiley</div>";
                        echo "<h1> Voici l'humeur prédomiante chez vous \"<span style='color:red'>".strtoupper($stockerLib)."</span>\".<br> Vous l'avez utiliser <span style='color:red'>$stocker</span> fois.</h1>";
                    }
                ?>
            </td>
        </tr>
        <tr class="third-part">
            <td class="bot-float-part">
                <?php 
                    if (!isset($emojiUsed)) {
                        echo "<p>Sélectionner une date début/fin et une humeur</p>";
                    } else {
                        echo $emojiUsed;
                    }
                ?>
            </td>
            <td class="bot-const-part">
                <div class="chart-container" style="position: relative; height:40vh;">
                    <canvas id="myChart"></canvas>
                </div>
                <?php
                    $countRow = $allValue1->rowCount();
                ?>
                <script>
                    const ctx2 = document.getElementById('myChart');

                    new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: <?php 
                                        $i = 0;
                                        while ($row = $allValue1->fetch()) {
                                            if($i == 0) {
                                                echo "[";
                                            }
                                            echo "\"$row->Humeur_Libelle\",";
                                            if ($i == $countRow - 1) {
                                                echo "]";
                                            }
                                            $i++;
                                        }
                                    ?>,
                            datasets: [{
                                data: <?php 
                                            $i = 0;
                                            while ($row = $allValue2->fetch()) {
                                                if($i == 0) {
                                                    echo "[";
                                                }
                                                echo "\"$row->compteur\",";
                                                if ($i == $countRow - 1) {
                                                    echo "]";
                                                }
                                                $i++;
                                            }
                                        ?>,
                                borderWidth: 0.75,
                                backgroundColor: [
                                    '#00ff7f',
                                    '#dc143c',
                                    '#00bfff',
                                    '#0000ff',
                                    '#8b008b',
                                    '#b03060',
                                    '#ff0000',
                                    '#ffd700',
                                    '#ff00ff',
                                    '#1e90ff',
                                    '#eee8aa',
                                    '#00ffff',
                                    '#b0e0e6',
                                    '#ff1493',
                                    '#ee82ee',
                                    '#ffb6c1',
                                    '#00008b',
                                    '#556b2f',
                                    '#0000ff',
                                    '#8b4513',
                                    '#483d8b',
                                    '#3cb371',
                                    '#b8860b',
                                    '#7fff00',
                                    '#8a2be2',
                                    '#ff7f50',
                                    '#008b8b',
                                    '#9acd32',
                                    '#00bfff',
                                ],
                            }]
                        },
                    });
                </script>
            </td>
        </tr>
    </table>
    </body>
</html>