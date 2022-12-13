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
    
    public function getMaxHumeur($pdo) {
        $req =$pdo->prepare("SELECT MAX(Humeur_Libelle) FROM humeur join user ON user.User_ID = humeur.CODE_USER WHERE CODE_User = :id GROUP BY Humeur_Libelle LIMIT 4");
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

    private static $defaultStatsService ;
    public static function getDefaultStatsService()
    {
        if (StatsService::$defaultStatsService == null) {
            StatsService::$defaultStatsService = new StatsService();
        }
        return StatsService::$defaultStatsService;
    }
}