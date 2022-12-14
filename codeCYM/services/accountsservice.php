<?php

namespace services;

use PDOException;

class AccountsService
{
    /**
     * Retourne les informations du profil de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getProfile($pdo) {

        $id = $_SESSION['UserID'];
        $requete = "SELECT * FROM User WHERE User_ID = $id";
        $resultats=$pdo->query($requete);

        return $resultats;
    }

    /**
     * Retourne les emails de tous les utilisateurs inscrits
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getEmails($pdo) {

        $requete = "SELECT User_Email FROM User";
        $resultats=$pdo->query($requete);

        return $resultats;
    }

    /**
     * Retourne les pseudo de tous les utilisateurs inscrits
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getUsernames($pdo) {

        $requete = "SELECT User_Name FROM User";
        $resultats=$pdo->query($requete);

        return $resultats;
    }

    /**
     * Retourne le mot de passe actuel de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getPasswords($pdo) {

        $id = $_SESSION['UserID'];
        $requete = "SELECT User_Password FROM User WHERE User_ID = $id";
        $resultats=$pdo->query($requete);

        return $resultats;
    }

    /**
     * Modifie le mot de passe de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editPassword($pdo, $newPassword) {

        $id = $_SESSION['UserID'];
        $stmt = $pdo->prepare("UPDATE user SET User_Password = :lemdp WHERE User_ID = $id");
        $newPassword = md5($newPassword);
        $stmt->bindParam('lemdp', $newPassword);
        $stmt->execute();
    }

    /**
     * Modifie le mail de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editMail($pdo, $newEmail) {

        $id = $_SESSION['UserID'];
        $stmt = $pdo->prepare("UPDATE user SET User_Email = :email WHERE User_ID = $id");
        $stmt->bindParam('email', $newEmail);
        $stmt->execute();
    }

    /**
     * Modifie le nom d'utilisateur de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editUsername($pdo, $newUsername) {

        $id = $_SESSION['UserID'];
        $stmt = $pdo->prepare("UPDATE user SET User_Name = :username WHERE User_ID = $id");
        $stmt->bindParam('username', $newUsername);
        $stmt->execute();
    }

    /**
     * Modifie la date de naissance de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editBirthDate($pdo, $newBirthDate) {

        $id = $_SESSION['UserID'];
        $stmt = $pdo->prepare("UPDATE user SET User_BirthDate = :birthDate WHERE User_ID = $id");
        $stmt->bindParam('birthDate', $newBirthDate);
        $stmt->execute();
    }

    /**
     * Modifie le nom d'utilisateur de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editGender($pdo, $newGender) {

        $id = $_SESSION['UserID'];
        $stmt = $pdo->prepare("UPDATE user SET User_Gender = :gender WHERE User_ID = $id");
        $stmt->bindParam('gender', $newGender);
        $stmt->execute();
    }

    /**
     * Supprime le profil de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function deleteProfile($pdo) {
        
        $id = $_SESSION['UserID'];
        $stmt = $pdo->prepare("DELETE FROM humeur WHERE CODE_USER = $id");
        $stmt->execute();
        $stmt = $pdo->prepare("DELETE FROM user WHERE User_ID = $id");
        $stmt->execute();
    }

    // Singleton qui permet d'instancier le service
    private static $defaultAccountsService ;
    public static function getDefaultAccountsService()
    {
        if (AccountsService::$defaultAccountsService == null) {
            AccountsService::$defaultAccountsService = new AccountsService();
        }
        return AccountsService::$defaultAccountsService;
    }
}