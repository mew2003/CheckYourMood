<?php
namespace controllers;

use yasmf\HttpHelper;
use services\AccountsService;
use yasmf\View;

class AccountsController {

    private $accountsService;

    public function __construct()
    {
        $this->accountsService = AccountsService::getDefaultAccountsService();
    }

    public function index($pdo) {
        session_start();
        $view = new View("CheckYourMood/codeCYM/views/Account");
        $resultats = $this->accountsService->getProfile($pdo);
        $view->setVar('resultats',$resultats);
        while($row = $resultats->fetch()) {
            $view->setVar('mail', $row->User_Email);
            $view->setVar('username', $row->User_Name);
            $view->setVar('password', $row->User_Password);
            $view->setVar('dateOfBirth', $row->User_BirthDate);
            $view->setVar('gender', $row->User_Gender);
        }
        return $view;
    }

    public function editProfile($pdo) {
        // lancement de la session
        session_start();
        // création de la vue pour modifié son profil
        $view = new View("CheckYourMood/codeCYM/views/editprofile");
        // récupération de toutes les données du formulaire
        $email = HttpHelper::getParam("email");
        $username = HttpHelper::getParam("username");
        $dateOfBirth = HttpHelper::getParam("dateOfBirth");
        $gender = HttpHelper::getParam("genderList");
        $update = HttpHelper::getParam("envoyer");
        // récupération du profil de l'utilisateur courant
        $verif = $this->accountsService->getProfile($pdo);
        while($row = $verif->fetch()) {
            $defaultEmail = $row->User_Email;
            $defaultUsername = $row->User_Name;
            $defaultDateOfBirth = $row->User_BirthDate;
            $defaultGender = $row->User_Gender;
        }
        // initialisation des variables
        $view->setVar('message', null);
        $view->setVar('defaultEmail', $defaultEmail);
        $view->setVar('defaultUsername', $defaultUsername);
        $view->setVar('defaultDateOfBirth', $defaultDateOfBirth);
        $view->setVar('defaultGender', $defaultGender);
        $view->setVar('email', $email);
        $view->setVar('username', $username);
        $view->setVar('dateOfBirth', $dateOfBirth);
        $view->setVar('gender', $gender);
        $view->setVar('update', $update);
        $sameUsername = false;
        $sameEmail = false;
        // appel des fonctions pour récupérer les emails et les pseudo de tous les utilisateur inscrits sur le site
        $verifSameEmail = $this->accountsService->getEmails($pdo);
        $verifSameUsername = $this->accountsService->getUsernames($pdo);
        // vérification que l'email envoyé n'existe pas déjà dans la base de données
        while($row = $verifSameEmail->fetch()) {
            if(strcmp($row->User_Email, $email) == 0) {
                $sameEmail = true;
            }
        }
        // vérification que le pseudo envoyé n'existe pas déjà dans la base de données
        while($row = $verifSameUsername->fetch()) {
            if(strcmp($row->User_Name, $username) == 0) {
                $sameUsername = true;
            }
        }
        echo var_dump($sameUsername);
        echo var_dump($sameEmail);        
        // si l'email n'est pas vide et qu'il n'existe pas alors on l'email est modifié
        if(!empty($update) && !empty($email) && $email != $defaultEmail && $sameEmail == false) {
            $this->accountsService->editMail($pdo, $email);              
            $view->setVar('message', "Vos informations ont bien été changées !");
        } else if(!empty($update) && !empty($email) && $email != $defaultEmail && $sameEmail == true) {
            $view->setVar('message', "Email déjà existante !");
        }
        // si le pseudo n'est pas vide et qu'il n'existe pas alors le pseudo est changé
        if(!empty($update) && !empty($username) && $username != $defaultUsername && $sameUsername == false) {
            $this->accountsService->editUsername($pdo, $username);
            $view->setVar('message', "Vos informations ont bien été changées !");
        } else if(!empty($update) && !empty($username) && $username != $defaultUsername && $sameUsername == true) {
            $view->setVar('message', "Pseudonyme déjà existant !");
        }
        // si la date de naissance n'est pas la même que celle stocké dans la base de données pour l'utilisateur courant alors elle est modifiée
        if(!empty($dateOfBirth) && $dateOfBirth != $defaultDateOfBirth && $dateOfBirth < date("Y-m-d")) {
            $defaultDateOfBirth = $this->accountsService->editDateOfBirth($pdo, $dateOfBirth);
            $view->setVar('defaultDateOfBirth', $defaultDateOfBirth);
            $view->setVar('message', "Vos informations ont bien été changées !");
        } else if($dateOfBirth != $defaultDateOfBirth && $dateOfBirth > date("Y-m-d")) {
            $view->setVar('message', "Votre date de naissance ne peut pas être supérieur à la date d'aujourd'hui !");
        }
        // si le genre n'est pas le même que celui stocké dans la base de donnée alors il est modifié
        if(!empty($gender) && $gender != $defaultGender) {
            $this->accountsService->editGender($pdo, $gender);
            $view->setVar('message', "Vos informations ont bien été changées !");
        }
        return $view;
    }

    public function editPassword($pdo) {
        session_start();
        $view = new View("CheckYourMood/codeCYM/views/editpassword");
        $envoyer = HttpHelper::getParam("envoyer");
        $newPassword = HttpHelper::getParam("newPassword");
        $confirmPassword = HttpHelper::getParam("confirmPassword");
        $oldPassword = HttpHelper::getParam("oldPassword");
        $resultats = $this->accountsService->getPasswords($pdo);
        while ($ligne = $resultats->fetch()) {
            $password = $ligne->User_Password;
        }
        $testOldPasswords = !empty($oldPassword) && strcmp($password, $oldPassword) == 0;
        $testNewPasswords = !empty($newPassword) && !empty($confirmPassword) && strcmp($newPassword, $confirmPassword) == 0;
        $view->setVar('testOldPasswords', $testOldPasswords);
        $view->setVar('testNewPasswords', $testNewPasswords);
        $view->setVar('envoyer', $envoyer);
        $view->setVar('password',$password);
        $view->setVar('oldPassword',$oldPassword);
        $view->setVar('newPassword',$newPassword);
        $view->setVar('confirmPassword',$confirmPassword);
        if($testOldPasswords && $testNewPasswords) {
            $this->accountsService->editPassword($pdo, $newPassword);       
        } 
        return $view;
    }

    public function deleteAccount($pdo) {
        session_start();
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
        session_start();
        session_destroy();
        echo "<input type='hidden' name='action' value='index'>";
        echo "<input type='hidden' name='controller' value='home'";
        $view = new View("CheckYourMood/codeCYM/views/index");
        return $view;
    }

}