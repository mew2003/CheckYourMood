<?php

namespace services;

use PDOException;

class EditprofilesService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editMail($pdo, $newEmail) {
        $stmt = $pdo->prepare("UPDATE user SET User_Email = :email WHERE User_ID = 2");
        $stmt->bindParam('email', $newEmail);
        $stmt->execute();
    }

    public function editUsername($pdo, $newUsername) {
        $stmt = $pdo->prepare("UPDATE user SET User_Name = :username WHERE User_ID = 2");
        $stmt->bindParam('username', $newUsername);
        $stmt->execute();
    }

    private static $defaulteditprofilesService ;
    public static function getDefaultEditprofilesService()
    {
        if (EditprofilesService::$defaulteditprofilesService == null) {
            EditprofilesService::$defaulteditprofilesService = new EditprofilesService();
        }
        return EditprofilesService::$defaulteditprofilesService;
    }
}