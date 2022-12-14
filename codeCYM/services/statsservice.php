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
    public function getHistorique($pdo) {
        $resultats = $pdo->prepare('SELECT CODE_User, Humeur_Libelle, Humeur_Emoji, Humeur_Time, Humeur_Description FROM Humeur WHERE CODE_User = :id');
        $resultats->execute(['id'=>$_SESSION['UserID']]);
        return $resultats;
    }
    
    /**
     * Récupère l'humeur la plus présente dans la base de donnée
     */
    public function getMaxHumeurLib($pdo) {
        $req =$pdo->prepare("SELECT MAX(Humeur_Libelle) FROM humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }

    public function getMaxHumeurCount($pdo) {
        $req =$pdo->prepare("SELECT COUNT(*) FROM humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }

    public function getNumberOfHumForMaxHumeur($pdo) {
        $req =$pdo->prepare ("SELECT COUNT(Humeur_Libelle) FROM humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id GROUP BY Humeur_Libelle LIMIT 4");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }

    public function getAllHumeur($pdo) {
        $req =$pdo->prepare ("SELECT Humeur_Libelle FROM humeur join user On user.User_ID = humeur.CODE_User WHERE CODE_User = :id GROUP BY Humeur_Libelle");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }
    
    public function getAllHumeurDate($pdo) {
        $req =$pdo->prepare ("SELECT COUNT(Humeur_Libelle) FROM humeur join user On user.User_ID = humeur.CODE_User WHERE CODE_User = :id GROUP BY Humeur_Libelle");
        $req->execute(['id'=>$_SESSION['UserID']]);
        return $req;
    }

    public function getNumberOfHumeurInTotal($pdo) {
        $req =$pdo->prepare ("SELECT COUNT(DISTINCT Humeur_Libelle) FROM humeur join user on user.User_ID = humeur.CODE_User WHERE CODE_User = :id");
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

    private static $defaultStatsService ;
    public static function getDefaultStatsService()
    {
        if (StatsService::$defaultStatsService == null) {
            StatsService::$defaultStatsService = new StatsService();
        }
        return StatsService::$defaultStatsService;
    }
}