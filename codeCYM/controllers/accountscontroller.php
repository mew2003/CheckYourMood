<?php
namespace controllers;

use yasmf\HttpHelper;
use services\AccountsService;
use yasmf\View;

class AccountsController {

    private $accountsService;

    public function __construct()
    {
        session_start();
        $this->accountsService = AccountsService::getDefaultAccountsService();
    }

    /**
     * Fonction de base du controlleur, récupère le profil de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Account");
        $resultats = $this->accountsService->getProfile($pdo);
        $view->setVar('resultats',$resultats);
        while($row = $resultats->fetch()) {
            $view->setVar('mail', $row->User_Email);
            $view->setVar('username', $row->User_Name);
            $view->setVar('password', $row->User_Password);
            $view->setVar('birthDate', $row->User_BirthDate);
            $view->setVar('gender', $row->User_Gender);
        }
        return $view;
    }

    /**
     * Change les informations du profil de l'utilisateur
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editProfile($pdo) {
        // création de la vue pour modifié son profil
        $view = new View("CheckYourMood/codeCYM/views/editprofile");
        // Création d'un objet profil contenant tous les paramètres lié au profil de l'utilisateur (mdp, email...)
        new Profile();
        // récupération du profil de l'utilisateur courant
        // $this->getDefaultProfile($pdo, $view);
        $verif = $this->accountsService->getProfile($pdo);
        while($row = $verif->fetch()) {
            $defaultEmail = $row->User_Email;
            $defaultUsername = $row->User_Name;
            $defaultBirthDate = $row->User_BirthDate;
            $defaultGender = $row->User_Gender;
        }
        $view->setVar('defaultEmail', $defaultEmail);
        $view->setVar('defaultUsername', $defaultUsername);
        $view->setVar('defaultBirthDate', $defaultBirthDate);
        $view->setVar('defaultGender', $defaultGender);
        // initialise les variables du profil dans la vue
        $sameUsername = false;
        $sameEmail = false;
        Profile::initialisation($view);
        // appel des fonctions pour récupérer les emails et les pseudos de tous les utilisateurs inscrits sur le site
        $verifSameEmail = $this->accountsService->getEmails($pdo);
        $verifSameUsername = $this->accountsService->getUsernames($pdo);
        // vérification que l'email envoyé n'existe pas déjà dans la base de données
        while($row = $verifSameEmail->fetch()) {
            if(strcmp($row->User_Email, Profile::$email) == 0) {
                $sameEmail = true;
            }
        }
        // vérification que le pseudo envoyé n'existe pas déjà dans la base de données
        while($row = $verifSameUsername->fetch()) {
            if(strcmp($row->User_Name, Profile::$username) == 0) {
                $sameUsername = true;
            }
        }       
        // si l'email n'est pas vide et qu'il n'existe pas alors on l'email est modifié
        $this->updateEmail($pdo, $view, Profile::$update, Profile::$email, $defaultEmail, $sameEmail);
        // si le pseudo n'est pas vide et qu'il n'existe pas alors le pseudo est changé
        $this->updateUsername($pdo, $view, Profile::$update, Profile::$username, $defaultUsername, $sameUsername);
        // si la date de naissance n'est pas la même que celle stocké dans la base de données pour l'utilisateur courant alors elle est modifiée
        $this->updateBirthDate($pdo, $view, Profile::$birthDate, $defaultBirthDate);
        // si le genre n'est pas le même que celui stocké dans la base de donnée alors il est modifié
        $this->updateGender($pdo, $view, Profile::$gender, $defaultGender);
        return $view;
    }

    /**
     * Récupère toutes les informations du profil de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    // public function getDefaultProfile($pdo, $view) {
    //     $verif = $this->accountsService->getProfile($pdo);
    //     while($row = $verif->fetch()) {
    //         $defaultEmail = $row->User_Email;
    //         $defaultUsername = $row->User_Name;
    //         $defaultBirthDate = $row->User_BirthDate;
    //         $defaultGender = $row->User_Gender;
    //     }
    //     $view->setVar('defaultEmail', $defaultEmail);
    //     $view->setVar('defaultUsername', $defaultUsername);
    //     $view->setVar('defaultBirthDate', $defaultBirthDate);
    //     $view->setVar('defaultGender', $defaultGender);
    //     return $view;
    // }

    /**
     * Modifie l'email de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function updateEmail($pdo, $view, $update, $email, $defaultEmail, $sameEmail) {
        if(!empty($update) && !empty($email) && $email != $defaultEmail && $sameEmail == false) {
            $this->accountsService->editMail($pdo, $email);             
            $view->setVar('message', "Votre email a bien été changé !");
        } else if(!empty($update) && !empty($email) && $email != $defaultEmail && $sameEmail == true) {
            $view->setVar('erreur', "Email déjà existant !");
        }
        return $view;
    }

    /**
     * Modifie le pseudo de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function updateUsername($pdo, $view, $update, $username, $defaultUsername, $sameUsername) {
        if(!empty($update) && !empty($username) && $username != $defaultUsername && $sameUsername == false) {
            $this->accountsService->editUsername($pdo, $username);
            $view->setVar('message', "Votre pseudo a bien été changé !");
        } else if(!empty($update) && !empty($username) && $username != $defaultUsername && $sameUsername == true) {
            $view->setVar('erreur', "Pseudonyme déjà existant !");
        }
        return $view;
    }

    /**
     * Modifie la date de naissance de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function updateBirthDate($pdo, $view, $birthDate, $defaultBirthDate) {
        if(!empty($birthDate) && $birthDate != $defaultBirthDate && $birthDate < date("Y-m-d")) {
            $this->accountsService->editBirthDate($pdo, $birthDate);
            $view->setVar('message', "Votre date de naissance à bien été changée !");
        } else if($birthDate != $defaultBirthDate && $birthDate > date("Y-m-d")) {
            $view->setVar('erreur', "Votre date de naissance ne peut pas être supérieur à la date d'aujourd'hui !");
        }
        return $view;
    }

    /**
     * Modifie le genre de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function updateGender($pdo, $view, $gender, $defaultGender) {
        if(!empty($gender) && $gender != $defaultGender) {
            $this->accountsService->editGender($pdo, $gender);
            $view->setVar('genderChanged', true);
            $view->setVar('message', "Votre genre a bien été changé !");
        }
        return $view;
    }
    

    /**
     * Change le mot de passe de l'utilisateur
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function editPassword($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/editpassword");
        $view->setVar('message', null);
        $update = HttpHelper::getParam("envoyer");
        $newPassword = HttpHelper::getParam("newPassword");
        $confirmPassword = HttpHelper::getParam("confirmPassword");
        $oldPassword = HttpHelper::getParam("oldPassword");
        $resultats = $this->accountsService->getPasswords($pdo);
        while ($ligne = $resultats->fetch()) {
            $password = $ligne->User_Password;
        }
        $testOldPasswordsNotSameAsNew = strcmp($oldPassword, $newPassword) != 0;
        $testOldPasswords = !empty($oldPassword) && strcmp($password, md5($oldPassword)) == 0;
        $testNewPasswords = !empty($newPassword) && !empty($confirmPassword) && strcmp($newPassword, $confirmPassword) == 0;
        $view->setVar('update', $update);
        $view->setVar('testOldPasswords', $testOldPasswords);
        $view->setVar('testNewPasswords', $testNewPasswords);
        $view->setVar('testOldPasswordsNotSameAsNew', $testOldPasswordsNotSameAsNew);
        if($testOldPasswords && $testNewPasswords && $testOldPasswordsNotSameAsNew) {
            $this->accountsService->editPassword($pdo, $newPassword);       
            $view->setVar('message', "Votre mot de passe a bien été modifié !");
        } 
        return $view;
    }

    /**
     * Supprime le compte de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function deleteAccount($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/deleteaccount");
        $delete = HttpHelper::getParam("delete");
        if(!empty($delete)) {
            $this->accountsService->deleteProfile($pdo);
            $view = new View("CheckYourMood/codeCYM/views/accountdeleted");
            session_destroy();
        } 
        return $view;
    }

    /**
     * Déconnecte l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function disconnect($pdo) {
        session_destroy();
        $view = new View("CheckYourMood/codeCYM/views/index");
        return $view;
    }

}

class Profile {

    public static $email;
    public static $username;
    public static $birthDate;
    public static $gender;
    public static $update;
    public static $message;
    public static $erreur;

    public function __construct() {
        // récupération de toutes les données du formulaire
        Profile::$email = HttpHelper::getParam("email");
        Profile::$username = HttpHelper::getParam("username");
        Profile::$birthDate = HttpHelper::getParam("birthDate");
        Profile::$gender = HttpHelper::getParam("genderList");
        Profile::$update = HttpHelper::getParam("envoyer");
        Profile::$message = null;
        Profile::$erreur = null;
    }

    public static function initialisation($view) {
        // initialisation des variables
        $view->setVar('message', Profile::$message);
        $view->setVar('erreur', Profile::$erreur);
        $view->setVar('email', Profile::$email);
        $view->setVar('username', Profile::$username);
        $view->setVar('birthDate', Profile::$birthDate);
        $view->setVar('gender', Profile::$gender);
        $view->setVar('update', Profile::$update);
        return $view;
    }

}
