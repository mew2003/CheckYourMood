<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/history.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/CheckYourMood/codeCYM/third-party/fontawesome-free-6.2.0-web/css/all.css">
        <script src="/CheckYourMood/codeCYM/JS/history.js"></script>
        <title>Historique</title>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    </head>
    <body>
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
                echo "<table class='table table-striped '>";
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
                    while( $ligne = $resultats->fetch() ) { 
                        if($i <= $nombreLigneMax && $i > $min) {
                            echo "<tr>";
                                echo "<td>".htmlspecialchars($ligne->Humeur_Libelle)."</td>";
                                echo "<td>".htmlspecialchars($ligne->Humeur_Emoji)."</td>";
                                echo "<td>".htmlspecialchars($ligne->Humeur_Time)."</td>";
                                echo "<td><form action='#' method='post'><button name='pop' value='$i' id='$i' type='submit' class='param'><i class='fa-solid fa-gear'></i></button></form></<td>";
                                echo "<div class='popuptext' id='myPopup$i'>
                                         <div class='description'>
                                            ".htmlspecialchars($ligne->Humeur_Description)."
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
                    echo "<script>myFunctionRemove($val);</script>";
                    $_POST['pop'] = "";
                } else {
                    var_dump($_POST['pop']);
                    $val = $_POST['pop'];
                    echo "<script>myFunction($val);</script>";
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