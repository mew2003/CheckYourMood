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

    private static $defaultStatsService ;
    public static function getDefaultStatsService()
    {
        if (StatsService::$defaultStatsService == null) {
            StatsService::$defaultStatsService = new StatsService();
        }
        return StatsService::$defaultStatsService;
    }
}