<?php

namespace services;

use PDOException;

class DeleteaccountsService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function DeleteProfile($pdo) {
        $stmt = $pdo->prepare("DELETE FROM humeur WHERE CODE_USER = 2");
        $stmt->execute();
        $stmt = $pdo->prepare("DELETE FROM user WHERE User_ID = 2");
        $stmt->execute();
    }

    private static $defaultDeleteaccountsService ;
    public static function getDefaultDeleteaccountsService()
    {
        if (DeleteaccountsService::$defaultDeleteaccountsService == null) {
            DeleteaccountsService::$defaultDeleteaccountsService = new DeleteaccountsService();
        }
        return DeleteaccountsService::$defaultDeleteaccountsService;
    }
}