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
    <!-- <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?> -->
    <header-component></header-component>
   
    <table>
        <tr class="title">
            <td class="top-float-part">
                <div class="date-selector">
                    <label>Date début:</label>
                    <input Type="date">
                </div>
                <div class="date-selector">
                    <label>Date fin:</label>
                    <input Type="date">
                </div>
                <select name="humeur">
                    <option selected>humeur</option>
                    <?php

                    ?>
                </select>
            </td>
            <td class="top-const-part">
                <h1>All Time</h1>
            </td>
        </tr>
        <tr class="second-part">
            <td class="mid-float-part">

            </td>
            <td class="mid-const-part">
                <?php
                    $valueMostUseHumeurLib = $MaxHumeurLib->fetchColumn();
                    $valueMostUseHumeurCount = $MaxHumeurCount->fetchColumn();
                    echo $valueMostUseHumeurCount;//FAUX le count return le count de toute les humeurs pas seulement la plus présente
                    echo $valueMostUseHumeurLib; 
                ?>
            </td>
        </tr>
        <tr class="third-part">
            <td class="bot-float-part">

            </td>
            <td class="bot-const-part">

            </td>
        </tr>
    </table>
    </body>
</html>