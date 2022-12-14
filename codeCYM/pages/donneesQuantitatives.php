<?php
	// Démarrage de la session
	session_start() ;
    $_SESSION['UserID'] = 5;
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="/CheckYourMood/codeCYM/CSS/stats.css" rel="stylesheet"/>
        <title>Données quantitatives</title>
        <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
    <header-component></header-component>

    <?php
        var_dump($_POST);
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
         * cochées
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
            $nbreTotHum = $ligne['nombreSaisie'];
        }

        /**
         * la liste des humeurs
         */
        $humeurs = $pdo->query("SELECT DISTINCT humeur_libelle FROM humeur");
        while ($ligne = $humeurs->fetch()) {

            $humeur = str_replace(' ', '_', $ligne['humeur_libelle']);

            /**
             * affichage sous forme d'un formulaire avec des cases à cocher
             */
            echo '<input type = "checkbox" name = "' . $humeur . '" ';
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
        $humeurs = $pdo->query("SELECT DISTINCT humeur_libelle FROM humeur");
        while ($ligne = $humeurs->fetch()) {
            $humeur = str_replace(' ', '_', $ligne['humeur_libelle']);
            if (isset($_POST["$humeur"])) { 
                /**
                 * le nombre de saisie d'humeur sélectionnée par l'utilisateur
                 * depuis la création de son compte
                 */
                $nombreHumeurSaisie = $pdo->prepare("SELECT COUNT(*) AS nombreSaisie FROM humeur WHERE code_user = :code_user AND humeur_libelle = :humeur_libelle GROUP BY humeur_libelle");
                $nombreHumeurSaisie->bindParam("code_user", $_SESSION['UserID']);
                $humeur = str_replace('_', ' ', $humeur);
                $nombreHumeurSaisie->bindParam("humeur_libelle", $humeur);
                $nombreHumeurSaisie->execute();
                while ($ligne = $nombreHumeurSaisie->fetch()) {
                    echo 'Votre humeur ' . $humeur . ' a été saisie ' . $ligne['nombreSaisie'];
                    echo ' fois sur un nombre total de ' . $nbreTotHum . ' fois <br>';
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