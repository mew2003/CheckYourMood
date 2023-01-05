<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/history.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/fontawesome-free-6.2.0-web/css/all.css">
        <script src="/CheckYourMood/codeCYM/JS/history.js"></script>
        <script src="/CheckYourMood/codeCYM/third-party/JQuery/jquery-3.6.1.js"></script>
        <title>Historique</title>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    </head>
    <body>
    <div class='background' id='background'></div>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <div class="container">
        <?php  
            if(isset($_GET['page']) && !empty($_GET['page'])){
                $currentPage = (int) strip_tags($_GET['page']);
            } else {
                $currentPage = 1;
            }
            $nombreLigneMax = 15 * $currentPage;
            echo "<h1 class='title'>Historique des humeurs</h1>";
            echo "<div class='container'>";
                echo "<table class='table table-striped'>";
                    echo "<tr>
                            <form>
                                <input hidden name='action' value='historyVal'>
                                <input hidden name='controller' value='stats'>
                                <th>
                                    Humeur
                                </th>
                                <th>Emoji associé</th>
                                <th>
                                    Date/Heure
                                </th>
                                <th>Propriétés</th>
                            </form>
                          <tr>";		
                    $min = 0 + (15 * ($currentPage - 1));
                    $i = 1;
                    while( $ligne = $historyValue->fetch() ) { 
                        if($i <= $nombreLigneMax && $i > $min) {
                            $date1 = $ligne->Humeur_TimeConst;
                            $timeStamp1 = strtotime($date1);
                            $finalDate = $timeStamp1 + 86400;
                            $finalDate1 = date('Y-m-d H:i:s', $finalDate);

                            $actualDate = date_default_timezone_get(); 
                            $actual = date('Y-m-d H:i:s', time());
                            $actualTimeStamp = strtotime($actual);
                            $actualFinalTimeStanp = date('Y-m-d H:i:s', $actualTimeStamp);

                            $dayBefore = $timeStamp1 - 86400;
                            $min = date('Y-m-d H:i:s', $dayBefore);
                            echo "<tr>
                                    <td>".htmlspecialchars($ligne->Humeur_Libelle)."</td>
                                    <td>".htmlspecialchars($ligne->Humeur_Emoji)."</td>
                                    <td>".htmlspecialchars($ligne->Humeur_Time)."</td>
                                    <td><form action='#' method='post'><button name='pop' value='$i' id='$i' type='submit' class='param'><i class='fa-solid fa-gear'></i></button></form></<td>
                                    <div class='popuptext' id='myPopup$i'>
                                    <div class='cross-button'><form action='#' method='post'><button type='submit' class='xMark'><i class='fa-solid fa-xmark'></i></button></form></div>
                                    <div class='desc-title'>Description :</div>
                                    <div class='description'>
                                        ".htmlspecialchars($ligne->Humeur_Description)."
                                    </div>
                                    <div class='delimiter-Row'></div>
                                    <div>Nouvelle Description :<br></div>
                                    <div class='buttons'>
                                        <form action='#' method='post' class='form-desc'>
                                            <input hidden name='action' value='update'>
                                            <input hidden name='controller' value='stats'>
                                            <input hidden name='time' value='$ligne->Humeur_Time'>
                                            <input hidden name='libelle' value='$ligne->Humeur_Libelle'>
                                            <textarea name='desc' class='textarea' value='$ligne->Humeur_Description'>$ligne->Humeur_Description</textarea>";
                                            if ($actualFinalTimeStanp <= $finalDate1) {
                                                echo "<label>Nouvelle Date : (Max -24H) </label>
                                                    <input class='time' type='datetime-local' name='change-time' value='$ligne->Humeur_Time'  min='$min' max='$ligne->Humeur_TimeConst'>";
                                            } else {
                                                echo "<label>Date non modifiable <br>(humeur créé il y a trop logntemps):</label>
                                                    <input hidden name='change-time' value='$ligne->Humeur_Time'>
                                                    <input type='text' value='$ligne->Humeur_Time' disabled>";
                                            }
                                            echo "<button type='submit' name='del-humeur' val='$i' class='update'>
                                                Valider
                                            </button>
                                        </form>
                                        <form action='#' method='get' class='form-del'>
                                            <input hidden name='action' value='deleteHumeur'>
                                            <input hidden name='controller' value='stats'>
                                            <input hidden name='time' value='$ligne->Humeur_Time'>
                                            <input hidden name='libelle' value='$ligne->Humeur_Libelle'>
                                            <button type='submit' name='del-humeur' val='$i' class='trash'>
                                                Suprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>";
                            echo "</tr>";
                        }
                        $i++;										
                    }
                echo "</table>" ;
            echo "</div>";	
            if(isset($_POST['pop']) && $_POST['pop'] != "") {
                if ($_POST['pop'] == 0) {
                    $val = $_POST['pop'];
                    echo "<script>removePopup($val);</script>";
                    $_POST['pop'] = "";
                } else {
                    $val = $_POST['pop'];
                    echo "<script>showPopup($val);</script>";
                }
            }
            $pages = $allRow / 15;
            $valAcomparer = $pages % 15;
            if ($pages > $valAcomparer && $pages >= 1) {
                $pages = $pages + 1;
            }
            echo "<nav>";
                echo "<ul class='pagination'>";
                    if ($currentPage > 1) {
                        echo "<li class='page-item'>"; 
                            ?>
                            <a class="page-button" href="./?action=historyVal&controller=stats&page=0"><i class="fa-solid fa-angles-left"></i></a>
                            <?php
                        echo "</li>";
                    }
                    if ($currentPage > 1) {
                        echo "<li class='page-item'>"; 
                            ?>
                            <a class="page-button" href="./?action=historyVal&controller=stats&page=<?php echo $currentPage - 1?>"><i class="fa-solid fa-chevron-left"></i></a>
                            <?php
                        echo "</li>";
                    }
                    for ($compteur = 1; $compteur <= $pages; $compteur++) { 
                        if ($compteur == $currentPage - 2 || $compteur == $currentPage -1 || $compteur == $currentPage || $compteur == $currentPage + 1 || $compteur == $currentPage + 2) {
                            ?>
                            <li class="page-item <?= ($currentPage == $compteur) ? "active" : "" ?>">
                                <a class="page-button" href="./?action=historyVal&controller=stats&page=<?php echo $compteur?>"><?php echo $compteur ?></a>
                            </li>
                            <?php 
                        }
                    } 
                    if ($compteur - 1 != $currentPage && $pages > 1) {
                        echo "<li class='page-item'>"; 
                            ?>
                            <a class="page-button" href="./?action=historyVal&controller=stats&page=<?php echo $currentPage + 1?>"><i class="fa-solid fa-chevron-right"></i></a>
                            <?php
                        echo "</li>";
                    }
                    if ($compteur - 1 != $currentPage && $pages > 1) {
                        echo "<li class='page-item'>"; 
                            ?>
                            <a class="page-button" href="./?action=historyVal&controller=stats&page=<?php echo $pages ?>"><i class="fa-solid fa-angles-right"></i></a>
                            <?php
                        echo "</li>";
                    }
                echo "</ul>";
            echo "</nav>";
            ?>
        </div>
    </body>
</html>