<?php

namespace services;

use PDOException;

class StatsService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getHistorique($pdo) {
        $requete = "SELECT CODE_User, Humeur_Libelle, Humeur_Emoji, Humeur_Time, Humeur_Description FROM Humeur";
        $resultats=$pdo->query($requete);
        return $resultats;
    }

    public function getMaxHumeur($pdo) {
        $req = "SELECT MAX(Humeur_Libelle) FROM humeur join user ON user.User_ID = humeur.CODE_USER WHERE User_ID = 2 GROUP BY Humeur_Libelle LIMIT 4";
        $result=$pdo->query($req);
        return $result;
    }

    public function getNumberOfHumForMaxHumeur($pdo) {
        $req = "SELECT COUNT(Humeur_Libelle) FROM humeur join user ON user.User_ID = humeur.CODE_USER WHERE User_ID = 2 GROUP BY Humeur_Libelle LIMIT 4";
        $result=$pdo->query($req);
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