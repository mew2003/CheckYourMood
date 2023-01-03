<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/history.css" rel="stylesheet"/>
        <title>test php et database</title>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    </head>
    <body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <?php
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        
        $nombreLigneMax = 15 * $currentPage;
        echo "<h1>Historique des humeurs</h1>";
        echo "<div class='container'>";
            echo "<table class='table table-striped'>";
                echo "<tr><td>Humeur_Libelle</td><td>Humeur_Emoji</td><td>Humeur_Time</td><td>Humeur_Description</td><tr>";		
                $min = 0 + (15 * ($currentPage - 1));
                $i = 1;                
                while( $ligne = $resultats->fetch() ) { 
                    if($i <= $nombreLigneMax && $i > $min) {
                        echo "<tr>";												
                            echo "<td>".htmlspecialchars($ligne->Humeur_Libelle)."</td>";
                            echo "<td>".htmlspecialchars($ligne->Humeur_Emoji)."</td>";
                            echo "<td>".htmlspecialchars($ligne->Humeur_Time)."</td>";
                            echo "<td>".htmlspecialchars($ligne->Humeur_Description)."</td>";	
                        echo "</tr>";
                    }
                    $i++;										
                }
            echo "</table>" ;
        echo "</div>";	
        echo "<nav>";
            echo "<ul class='pagination'>";
                $pages = $allRow / 15;
                $valAcomparer = $pages % 15;
                if ($pages > $valAcomparer) {
                    $pages = $pages + 1;
                }
                for ($compteur = 1; $compteur <= $pages; $compteur++) {  
        ?>
                    <li class="page-item <?= ($currentPage == $compteur) ? "active" : "" ?>">
                        <a class="page" href="./?action=historyVal&controller=stats&page=<?php echo $compteur?>"><?php echo $compteur ?></a>
                    </li>
        <?php   } 
            echo "</ul>";
        echo "</nav>";
    ?>
    </body>
</html>