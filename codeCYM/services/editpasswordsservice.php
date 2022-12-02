<?php

namespace services;

use PDOException;

class EditpasswordsService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getPasswords($pdo) {
        $requete = "SELECT User_Password FROM User";
        $resultats=$pdo->query($requete);
        return $resultats;
    }

    public function editPassword($pdo, $newPassword) {
        $stmt = $pdo->prepare("UPDATE user SET User_Password = :lemdp WHERE User_ID = 2");
        $stmt->bindParam('lemdp', $newPassword);
        $stmt->execute();
    }

    private static $defaulteditpasswordsService ;
    public static function getDefaultEditpasswordsService()
    {
        if (EditpasswordsService::$defaulteditpasswordsService == null) {
            EditpasswordsService::$defaulteditpasswordsService = new EditpasswordsService();
        }
        return EditpasswordsService::$defaulteditpasswordsService;
    }
}