<?php

namespace services;

use PDOException;

class StatsService
{
    /**
     * Renvoie l'historique de toutes les humeurs de l'utilisateur
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getHistorique($pdo, $sort) {
        $requete = 'SELECT CODE_User, Humeur_Libelle, Humeur_Emoji, Humeur_Time, Humeur_Description FROM Humeur WHERE CODE_User = :id'.$sort;
        $resultats = $pdo->prepare($requete);
        $resultats->execute(['id'=>$_SESSION['UserID']]);
        return $resultats;
    }
    
    /**
     * Récupère le nombre de fois où toutes les humeurs apparaissent dans la base de donné ainsi que les humeurs associer à ce nombre 
     */
    public function getMaxHumeur($pdo) {
        $req =$pdo->prepare("SELECT Humeur_Libelle, COUNT(Humeur_Libelle) as compteur, Humeur_Emoji from humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id GROUP BY Humeur_Libelle ORDER BY compteur DESC LIMIT 1");
        $req->execute(['id'=>$_SESSION['UserID']]);
        if($req->rowCount() == 0) {
            return "Vous n'avez saisie aucune humeur !!!";
        }
        return $req;
    }

    public function getAllValue($pdo) {
        $req = $pdo->prepare("SELECT Humeur_Libelle, COUNT(Humeur_Libelle) as compteur from humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id GROUP BY Humeur_Libelle");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }

    public function getAllRow($pdo) {
        $req = $pdo->prepare ("SELECT COUNT(*) AS allRow FROM humeur WHERE CODE_User = :id");
        $req->execute(['id'=>$_SESSION['UserID']]);
        $splitResult = $req->fetchColumn();
        $allRow = (int) $splitResult;
        return $allRow;
    }

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

    public function getHumeurByTime($pdo, $startDate, $endDate, $humeurs) {
        $req = $pdo->prepare("SELECT count(*) as nombreHumeur, Humeur_Libelle, DATE_FORMAT(Humeur_Time, '%d/%m/%y') as Date from humeur where code_User=:id AND Humeur_Libelle = :libelle and Humeur_Time BETWEEN :startDate AND :endDate and Humeur_time GROUP BY (SELECT DATE_FORMAT(Humeur_Time, '%d/%m/%y'))");
        $req->execute(['id'=>$_SESSION['UserID'], 'libelle'=>$humeurs, 'startDate'=>$startDate, 'endDate'=>$endDate]);
        return $req;
    }

    public function getDonneesQuantitatives($pdo, $startDate, $endDate, $humeurs) {
        $nbreTotalHumeurSaisies = $pdo->prepare("SELECT COUNT(*) as nombreSaisie FROM humeur WHERE code_user = :code_user GROUP BY code_user");
        $nbreTotalHumeurSaisies->bindParam("code_user", $_SESSION['UserID']);
        $nbreTotalHumeurSaisies->execute();
        return $nbreTotalHumeurSaisies;
    }
    
    private static $defaultStatsService ;
    public static function getDefaultStatsService()
    {
        if (StatsService::$defaultStatsService == null) {
            StatsService::$defaultStatsService = new StatsService();
        }
        return StatsService::$defaultStatsService;
    }
}