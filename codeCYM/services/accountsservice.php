<?php

namespace services;

use PDOException;

class AccountsService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getProfile($pdo) {
        $requete = "SELECT * FROM User";
        $resultats=$pdo->query($requete);
        return $resultats;
    }

    private static $defaultAccountsService ;
    public static function getDefaultAccountsService()
    {
        if (AccountsService::$defaultAccountsService == null) {
            AccountsService::$defaultAccountsService = new AccountsService();
        }
        return AccountsService::$defaultAccountsService;
    }
}