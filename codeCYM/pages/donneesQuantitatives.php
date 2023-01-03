<?php
	// Démarrage de la session
	session_start() ;
    $_SESSION['UserID'] = 4;
?>

<!-- définit la langue du site afin -->
<!DOCTYPE html>
<html lang="fr">
    <head>

        <!-- encodage -->
        <meta charset="UTF-8">

        <!-- lien vers le bootstrap -->
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>

        <!-- lien vers notre feuille de style -->
        <link href="/CheckYourMood/codeCYM/CSS/stats.css" rel="stylesheet"/>

        <!-- titre du site affiché dans l'onglet -->
        <title>Données quantitatives</title>

        <!-- lien vers le script JavaScript et s'exécute au fur et à mesure -->
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>

    </head>
    <body>

    <!-- inclusion du bandeau du haut -->
        <header-component></header-component>

    <?php

    /**
     * compte le nombre d'humeurs sélectionnées afin de constituer la requête
     * qui affiche les données quantitatives des humeurs sélectionnées
     * par l'utilisateur
     */
    $nombreHumeurs = 0;

        $host='localhost';	// Serveur de BD
        $db='cym';	// Nom de la BD
        $user='root';		// User 
        $pass='root';		// Mot de passe
        $charset='utf8mb4';	// charset utilisé

        // Constitution variable DSN
        $dsn="mysql:host=$host;dbname=$db;charset=$charset";

        // Réglage des options
        $options=[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES=>false];
        $pdo=new PDO($dsn,$user,$pass,$options);

        /**
         * début du formulaire permettant de renvoyer les cases 
         * à cocher
         */
        echo '<form method = "post" action = "donneesQuantitatives.php">';

        /**
         * le nombre total de saisie d'humeurs 
         * depuis la création de son compte, 
         * toutes humeurs cumulées
         */
        $nbreTotalHumeurSaisies = $pdo->prepare("SELECT COUNT(*) as nombreSaisie FROM humeur WHERE code_user = :code_user GROUP BY code_user");
        $nbreTotalHumeurSaisies->bindParam("code_user", $_SESSION['UserID']);
        $nbreTotalHumeurSaisies->execute();
        while ($ligne = $nbreTotalHumeurSaisies -> fetch()) {

            /**
             * récupère le résultat de la requête
             * (résultat unique)
             */
            $nbreTotHum = $ligne['nombreSaisie'];
        }

        /**
         * la liste des humeurs
         */
        $requete = "SELECT DISTINCT humeur_libelle FROM humeur WHERE code_user = :code_user";
        $humeurs = $pdo->prepare($requete);
        $humeurs -> bindParam("code_user", $_SESSION['UserID']);
        $humeurs->execute();
        $i = 0;

        /**
         * stockage de la liste des humeurs dans un tableau pour 
         * limiter les accès à la base de données
         */
        $tabHumeurs = "";
        while ($ligne = $humeurs->fetch()) {
            $tabHumeurs[$i] = $ligne['humeur_libelle'];
            $i++;
        }

        foreach($tabHumeurs as $humeur) {

            $humeur = str_replace(' ', '_', $humeur);

            /**
             * affichage sous forme d'un formulaire avec des cases à cocher
             */
            echo '<input type = "checkbox" name = "' . $humeur . '" value = "' . $humeur . '"';
            if (isset($_POST["$humeur"])) {
                echo 'checked' . '>';
            }
            echo '<label for = "' . $humeur . '">' . str_replace('_', ' ', $humeur);
            echo '</label> &nbsp; &nbsp;';
        }

        /**
         * affichage d'un bouton pour valider le formulaire
         */
        echo '<input type="submit">';
        echo '</form>';

        /**
         * affichage du nombre de saisie d'une humeur 
         * en fonction du nombre de saisie de toutes les humeurs
         * pour chaque humeur sélectionnée plus haut
         */

        for ($i = 0 ; $i < count($_POST) ; $i++) {
            $nombreHumeurs++;
            if ($nombreHumeurs == 1) {
                $requete .= " AND humeur_libelle = :humeur_libelle" . $i;
            }
            if ($nombreHumeurs > 1) {
                $requete .= " OR humeur_libelle = :humeur_libelle" . $i;
            }

        }

        /**
         * préparation de la requête constituée de toutes les humeurs
         */
        $humeurs = $pdo->prepare($requete);

        $i = 0;
        foreach ($tabHumeurs as $humeur) {
            $humeur = str_replace(' ', '_', $humeur);
            if (isset($_POST["$humeur"])) {
                $humeur = str_replace('_', ' ', $humeur);
                $humeurs->bindParam("humeur_libelle" . $i, $humeur);
                $i++;
            }
        }

        foreach ($tabHumeurs as $humeur) {

            $humeur = str_replace(' ', '_', $humeur);
            if (isset($_POST["$humeur"])) {
                $humeur = str_replace('_', ' ', $humeur);
                /**
                 * le nombre de saisie d'humeur sélectionnée par l'utilisateur
                 * depuis la création de son compte
                 */
                $nombreHumeurSaisie = $pdo->prepare("SELECT COUNT(*) AS nombreSaisie FROM humeur WHERE code_user = :code_user AND humeur_libelle = :humeur_libelle GROUP BY humeur_libelle");
                $nombreHumeurSaisie->bindParam("code_user", $_SESSION['UserID']);
                $nombreHumeurSaisie->bindParam("humeur_libelle", $humeur);
                $nombreHumeurSaisie->execute();
                while ($ligne = $nombreHumeurSaisie->fetch()) {
                    echo 'Votre humeur ' . $humeur . ' a été saisie ' . $ligne['nombreSaisie'];
                    echo ' fois pour ' . $nbreTotHum;
                    if ($nbreTotHum < 2) {
                        echo ' saisie ';
                    }  else {
                        echo ' saisies ';
                    }
                    echo ' d\'humeur au total <br>';
                    echo 'Son taux de saisie est de ' . round($ligne['nombreSaisie'] * 100 / $nbreTotHum, 2) . '%. <br> <br>';
            }
            }
        }

        /*public function getDonneesQuantitatives($pdo,$humeur) {
            $requete = $pdo->prepare("SELECT humeur from cym where humeur_libelle = :humeur_libelle");
            $requete->execute(['humeur_libelle'=>$humeur])
            return $requete;
        }

        $DonneesQuantitatives = $this->statsService->getDonneesQuantitatives($pdo);*/

        ?>
    </body>
</html>