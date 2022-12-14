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
     * Fonction de base du controlleur, récupère le profil de l'utilisateur courant et l'affiche
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Account");
        /* récupère dans la base de données les infos de l'utilisateur */
        $resultats = $this->accountsService->getProfile($pdo); 

        /* met dans la view les données récupérées */
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

        /* création de la vue pour modifier son profil */
        $view = new View("CheckYourMood/codeCYM/views/editprofile");

        /* Création d'un objet profil contenant tous les paramètres lié au profil de l'utilisateur (mdp, email...) */
        /* créer un objet "Profile" qui stock tous les paramètres lié au profil de l'utilisateur envoyé par le formulaire */
        new Profile(); 

        /* récupération du profil de l'utilisateur courant */
        /* variable qui test si l'email existe déjà */
        $sameUsername = false;
        /* variable qui test si le pseudo existe déjà */
        $sameEmail = false; 
        $this->getDefaultProfile($pdo, $view); // récupère le profil de l'utilisateur courant dans la base de données
        Profile::initialisation($view); // Envoie les données stockées dans l'objet "Profile" dans la view

        /* appel des fonctions pour vérifier que l'email et le pseudo n'existe pas déjà dans la base de données */
        /* true si l'email existe déjà, false sinon */
        $sameEmail = $this->checkSameEmail($pdo); 
        /* true si le pseudo existe déjà, false sinon */
        $sameUsername = $this->checkSameUsername($pdo); 

        /* si l'email n'est pas vide et qu'il n'existe pas alors l'email est modifié */
        $this->updateEmail($pdo, $view, Profile::$update, Profile::$email, 
                           $view->getParams("defaultEmail"), $sameEmail);

        /* si le pseudo n'est pas vide et qu'il n'existe pas alors le pseudo est changé */
        $this->updateUsername($pdo, $view, Profile::$update, Profile::$username, 
                              $view->getParams("defaultUsername"), $sameUsername);

        /* si la date de naissance n'est pas la même que celle stocké dans la base de données pour l'utilisateur courant */
        /* alors elle est modifiée */
        $this->updateBirthDate($pdo, $view, Profile::$birthDate, $view->getParams("defaultBirthDate"));

        /* si le genre n'est pas le même que celui stocké dans la base de donnée alors il est modifié */
        $this->updateGender($pdo, $view, Profile::$gender, $view->getParams("defaultGender"));

        return $view;
    }

    /**
     * Récupère toutes les informations du profil de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function getDefaultProfile($pdo, $view) {

        /* récupère dans la base données les infos de l'utilisateur */
        $verif = $this->accountsService->getProfile($pdo); 

        /* met dans la view les données récupérées */
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

        return $view;
    }

    /**
     * Vérifie dans la base de données si l'email existe déjà
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function checkSameEmail($pdo) {

        /* récupère dans la base données les emails de tous les utilisateurs */
        $verifSameEmail = $this->accountsService->getEmails($pdo);

        /* Si la requête retourne au moins 1 ligne alors l'email existe déjà */
        if($verifSameEmail->rowCount() != 0) $sameEmail = true;

        return $sameEmail;
    }

    /**
     * Vérifie dans la base de données si le pseudo existe déjà
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function checkSameUsername($pdo) {

        /* récupère dans la base données les pseudos de tous les utilisateurs */
        $verifSameUsername = $this->accountsService->getUsernames($pdo);

        /* Si la requête retourne au moins 1 ligne alors le pseudo existe déjà */
        if($verifSameUsername->rowCount() != 0) $sameUsername = true;

        return $sameUsername;
    }

    /**
     * Modifie l'email de l'utilisateur courant
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function updateEmail($pdo, $view, $update, $email, $defaultEmail, $sameEmail) {

        /* Si les données du formulaire sont envoyées et que l'email n'est pas vide et qu'il n'existe pas */
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

        /* Si les données du formulaire sont envoyées et que le pseudo n'est pas vide et qu'il n'existe pas */
        /* le pseudo est modifié sinon affiche une erreur */
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

        /* Si les données du formulaire sont envoyées et que la date de naissance est inférieur à la date d'aujourd'hui */
        /* alors elle est modifié sinon affiche une erreur */
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

        /* Si les données du formulaire sont envoyée et que le genre sélectionné */
        /* n'est pas le même que celui sélectionné avant alors il change */
        if($gender != $defaultGender) {
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
        /* Création d'une nouvele vue */
        $view = new View("CheckYourMood/codeCYM/views/editpassword");

        /* Contrôle le champs ancien mot de passe */
        $view->setVar('resetPwd', 0);

        /* Création d'un objet "Passwords" et récupération des mots de passe de l'utilisateur courant */
        new Passwords();

        /* Mot de passe actuel de l'utilisateur */
        $stmt = $this->accountsService->getPasswords($pdo);
        while($row = $stmt->fetch()) {
            $defaultPassword = $row->User_Password;
        }
        /* Vérification de l'ancien mot de passe */
        $testOldPassword = !empty(Passwords::$oldPassword) 
                           && strcmp($defaultPassword, md5(Passwords::$oldPassword)) == 0;
        $view->setVar('testOldPassword', $testOldPassword);
        /* Envoie des valeurs des mots de passe dans la view */
        Passwords::initialisation($view);
        /* Si le nouveau mot de passe n'est pas le même que l'ancien et que le nouveau mot de passe */
        /* et le même que celui de la confirmation du nouveau mot de passe alors le mot de passe est modifié */
        if($testOldPassword && Passwords::$testNewPassword && Passwords::$testOldPasswordNotSameAsNew) {
            $this->accountsService->editPassword($pdo, Passwords::$newPassword); 
            $view->setVar('resetPwd', 1);      
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

        /* Chargement de la vue de la page pour supprimer son compte */
        $view = new View("CheckYourMood/codeCYM/views/deleteaccount");
        $delete = HttpHelper::getParam("delete");

        /* Si le bouton du formulaire à été cliqué alors on supprime le compte */
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

        /* Initialisation de la valeur de la session à null avant de la détruire */
        $_SESSION['UserID'] = null;
        session_destroy();

        /* Chargement de la vue de la page d'accueil du site */
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
 
        Profile::$email = HttpHelper::getParam("email");
        Profile::$username = HttpHelper::getParam("username");
        Profile::$birthDate = HttpHelper::getParam("birthDate");
        Profile::$gender = HttpHelper::getParam("genderList");
        Profile::$update = HttpHelper::getParam("envoyer");
        Profile::$message = null;
        Profile::$erreur = null;
    }

    public static function initialisation($view) {

        /* Ajout des valeurs dans la vue */
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

class Passwords {

    public static $oldPassword;
    public static $newPassword;
    public static $confirmPassword;
    public static $update;
    public static $message;
    public static $testNewPassword;
    public static $testOldPasswordNotSameAsNew;

    public function __construct() {

        Passwords::$update = HttpHelper::getParam("envoyer");
        Passwords::$newPassword = HttpHelper::getParam("newPassword");
        Passwords::$confirmPassword = HttpHelper::getParam("confirmPassword");
        Passwords::$oldPassword = HttpHelper::getParam("oldPassword");
        Passwords::$message = null;
        Passwords::$testNewPassword = !empty(Passwords::$newPassword) && !empty(Passwords::$confirmPassword) 
                                      && strcmp(Passwords::$newPassword, Passwords::$confirmPassword) == 0;;
        Passwords::$testOldPasswordNotSameAsNew = strcmp(Passwords::$oldPassword, Passwords::$newPassword) != 0;;
    }

    public static function initialisation($view) {

        /* Ajout des valeurs dans la vue */
        $view->setVar('message', Passwords::$message);
        $view->setVar('update', Passwords::$update);
        $view->setVar('testNewPassword', Passwords::$testNewPassword);
        $view->setVar('testOldPasswordNotSameAsNew', Passwords::$testOldPasswordNotSameAsNew);
        $view->setVar('oldPassword', Passwords::$oldPassword);

        return $view;

    } 
}