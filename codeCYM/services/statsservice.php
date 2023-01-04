<?php

namespace services;

use PDOException;

class StatsService
{
    /**
     * Récupère l'historique de toutes les humeurs de l'utilisateur
     * @param $pdo  la connexion à la base de données
     * @return $resultats  le résultat de la requête (toutes les humeurs entrées par un utilisateur)
     */
    public function getHistorique($pdo) {
        $requete = 'SELECT CODE_User, Humeur_Libelle, Humeur_Emoji, Humeur_Time, Humeur_Description FROM Humeur WHERE CODE_User = :id ORDER BY Humeur_Time DESC';
        $resultats = $pdo->prepare($requete);
        $resultats->execute(['id'=>$_SESSION['UserID']]);
        return $resultats;
    }
    
    /**
     * Récupère le nombre de fois où toutes les humeurs apparaissent dans 
     * la base de donné ainsi que les humeurs associer à ce nombre 
     * @param $pdo  la connexion à la base de données
     * @return $req  le résultat de la requête
     */
    public function getMaxHumeur($pdo) {
        $req =$pdo->prepare("SELECT Humeur_Libelle, COUNT(Humeur_Libelle) as compteur, Humeur_Emoji from humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id GROUP BY Humeur_Libelle ORDER BY compteur DESC LIMIT 1");
        $req->execute(['id'=>$_SESSION['UserID']]);
        if($req->rowCount() == 0) {
            return "Vous n'avez saisie aucune humeur !!!";
        }
        return $req;
    }

    /**
     * Récupère le nombre de fois qu'un utilisateur à saisi chaque humeur
     * @param $pdo  la connexion à la base de données
     * @return $req  le résultat de la requête
     */
    public function getAllValue($pdo) {
        $req = $pdo->prepare("SELECT Humeur_Libelle, COUNT(Humeur_Libelle) as compteur from humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id GROUP BY Humeur_Libelle");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }

    /**
     * Récupère le nombre d'humeurs qu'un utilisateur a
     * @param $pdo  la connexion à la base de données
     * @return $allRow  le résultat de la requête converti en int
     */
    public function getAllRow($pdo) {
        $req = $pdo->prepare ("SELECT COUNT(*) AS allRow FROM humeur WHERE CODE_User = :id");
        $req->execute(['id'=>$_SESSION['UserID']]);
        $splitResult = $req->fetchColumn();
        $allRow = (int) $splitResult;
        return $allRow;
    }

    /**
     * Récupère le nombre de fois qu'un utilisateur a eu une humeur entre 2 dates
     * @param $pdo  la connexion à la base de données
     * @param $startDate  la date de début choisit par l'utilisateur
     * @param $endDate  la date de fin choisit par l'utilisateur
     * @param $humeurs  l'humeur choisit par l'utilisateur
     * @return $result  le résultat de la requête
     */
    public function getMostUsed($pdo, $startDate, $endDate, $humeurs) {
        $result = "";
        if ($humeurs == "TOUS") {
            $req = $pdo->prepare ("SELECT COUNT(*) AS 'NB_Humeur' FROM `humeur` WHERE `CODE_User` = :id AND `Humeur_Time` <= :endDate AND `Humeur_Time` >= :startDate");
            $req->execute(['id'=>$_SESSION['UserID'], 'startDate'=>$startDate, 'endDate'=>$endDate]);
            while ($row = $req->fetch()) {
                $result = [$row->NB_Humeur];
            }
        } else {
            $req = $pdo->prepare ("SELECT COUNT(`Humeur_Libelle`) AS 'NB_Humeur', `Humeur_Emoji` AS 'Emoji' FROM `humeur` WHERE `CODE_User` = :id AND `Humeur_Libelle` = :libelle AND `Humeur_Time` <= :endDate AND `Humeur_Time` >= :startDate GROUP BY `Humeur_Libelle`");
            $req->execute(['id'=>$_SESSION['UserID'], 'libelle'=>$humeurs, 'startDate'=>$startDate, 'endDate'=>$endDate]);
            while ($row = $req->fetch()) {
                $result = [$row->Emoji, $row->NB_Humeur];
            }
        }
        return $result;
    }

    /**
     * Récupère le nombre de fois qu'un utilisateur a eu une humeur entre 2 dates regroupé par jour
     * @param $pdo  la connexion à la base de données
     * @param $startDate  la date de début choisit par l'utilisateur
     * @param $endDate  la date de fin choisit par l'utilisateur
     * @param $humeurs  l'humeur choisit par l'utilisateur
     * @return $req  le résultat de la requête
     */
    public function getHumeurByTime($pdo, $startDate, $endDate, $humeurs) {
        $req = $pdo->prepare("SELECT count(*) as nombreHumeur, Humeur_Libelle, DATE_FORMAT(Humeur_Time, '%d/%m/%y') as Date from humeur where code_User=:id AND Humeur_Libelle = :libelle and Humeur_Time BETWEEN :startDate AND :endDate and Humeur_time GROUP BY (SELECT DATE_FORMAT(Humeur_Time, '%d/%m/%y'))");
        $req->execute(['id'=>$_SESSION['UserID'], 'libelle'=>$humeurs, 'startDate'=>$startDate, 'endDate'=>$endDate]);
        return $req;
    }

    public function getNombreTotalHumeursSaisies($pdo) {
        /**
         * toutes les humeurs saisies
         */
        $toutesLesHumeursSaisies = "SELECT humeur_libelle FROM humeur WHERE code_user = :code_user";
        $toutesLesHumeursSaisies = $pdo->prepare($toutesLesHumeursSaisies);
        $toutesLesHumeursSaisies->bindParam("code_user", $_SESSION['UserID']);
        $toutesLesHumeursSaisies->execute();

        /**
         * récupère le résultat de la requête
         * (résultat unique)
         */
        $nombreTotalHumeursSaisies = $toutesLesHumeursSaisies -> rowCount();
        return $nombreTotalHumeursSaisies;
    }

    /**
     * récupère le nombre de saisies de l'humeur saisie par l'utilisateur
     */
    public function getNombreSaisiesHumeurSelectionnee($pdo, $humeurSelectionnee) {
        $nombreSaisiesHumeurSelectionnee = "SELECT humeur_libelle FROM humeur WHERE code_user = :code_user AND humeur_libelle = :humeur_libelle";
        $nombreSaisiesHumeurSelectionnee = $pdo -> prepare($nombreSaisiesHumeurSelectionnee);
        $nombreSaisiesHumeurSelectionnee -> bindParam('humeur_libelle', $humeurSelectionnee);
        $nombreSaisiesHumeurSelectionnee -> bindParam('code_user', $_SESSION['UserID']);
        $nombreSaisiesHumeurSelectionnee -> execute();
        $nombreSaisiesHumeurSelectionnee = $nombreSaisiesHumeurSelectionnee -> rowCount();
        return $nombreSaisiesHumeurSelectionnee;
    }

    public function delHumeur($pdo, $time, $libelle) {
        $req = $pdo->prepare('DELETE FROM humeur WHERE Humeur_Time = :time AND Humeur_Libelle = :libelle AND CODE_User = :id');
        $req->bindParam('time', $time);
        $req->bindParam('libelle', $libelle);
        $req->bindParam('id', $_SESSION['UserID']);
        $req->execute();
    }
    
    public function updateDesc($pdo, $time, $libelle, $desc) {
        $req = $pdo->prepare('UPDATE humeur SET Humeur_Description = :desc WHERE CODE_User = :id AND Humeur_Time = :time AND Humeur_Libelle = :libelle');
        $req->bindParam('time', $time);
        $req->bindParam('libelle', $libelle);
        $req->bindParam('desc', $desc);
        $req->bindParam('id', $_SESSION['UserID']);
        $req->execute();
    }

    /* Singleton d'instanciation */
    private static $defaultStatsService ;
    public static function getDefaultStatsService()
    {
        if (StatsService::$defaultStatsService == null) {
            StatsService::$defaultStatsService = new StatsService();
        }
        return StatsService::$defaultStatsService;
    }
}