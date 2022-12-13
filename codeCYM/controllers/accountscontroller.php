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
        session_start();
        $verif = $this->accountsService->getProfile($pdo);
        $envoyer = HttpHelper::getParam("envoyer");
        while($row = $verif->fetch()) {
            $verifEmail = $row->User_Email;
            $verifUsername = $row->User_Name;
            $verifDateOfBirth = $row->User_BirthDate;
            $verifGender = $row->User_Gender;
        }
        $view = new View("CheckYourMood/codeCYM/views/editprofile");
        $email = HttpHelper::getParam("email");
        $username = HttpHelper::getParam("pseudo");
        $dateOfBirth = HttpHelper::getParam("dateOfBirth");
        $gender = HttpHelper::getParam("genderList");
        $update = HttpHelper::getParam("envoyer");
        $view->setVar('message', null);
        $view->setVar('mailChanged', false);
        $view->setVar('usernameChanged', false);
        $view->setVar('birthDateChanged', false);
        $view->setVar('genderChanged', false);
        $view->setVar('envoyer', $envoyer);
        $view->setVar('email', $email);
        $view->setVar('pseudo', $username);
        $view->setVar('dateOfBirth', $dateOfBirth);
        $view->setVar('gender', $gender);
        $view->setVar('defaultEmail', $verifEmail);
        $view->setVar('defaultPseudo', $verifUsername);
        $view->setVar('defaultDateOfBirth', $verifDateOfBirth);
        $view->setVar('defaultGender', $verifGender);
        $sameUsername = false;
        $sameEmail = false;
        $verifSameEmail = $this->accountsService->getEmails($pdo);
        $verifSameUsername = $this->accountsService->getUsernames($pdo);
        while($row = $verifSameEmail->fetch() && !$sameEmail) {
            if($row == $email) {
                $sameEmail = true;
            }
        }
        while($row = $verifSameUsername->fetch() && !$sameUsername) {
            if($row == $email) {
                $sameUsername = true;
            }
        }
        if(!empty($update) && !empty($email) && $email != $verifEmail && !$sameEmail) {
            $this->accountsService->editMail($pdo, $email);
            $view->setVar('mailChanged', true);              
            $view->setVar('message', "Vos informations ont bien été changées !");
        } else {
            $view->setVar('message', "Email déjà existante !");
        }
        if(!empty($update) && !empty($username) && $username != $verifUsername && !$sameUsername) {
            $this->accountsService->editUsername($pdo, $username);
            $view->setVar('usernameChanged', true);
            $view->setVar('message', "Vos informations ont bien été changées !");
        } else {
            $view->setVar('message', "Pseudonyme déjà existant !");
        }
        if(!empty($dateOfBirth) && $dateOfBirth != $verifDateOfBirth) {
            $this->accountsService->editDateOfBirth($pdo, $dateOfBirth);
            $view->setVar('birthDateChanged', true);
            $view->setVar('message', "Vos informations ont bien été changées !");
        }
        if(!empty($gender) && $gender != $verifGender) {
            $this->accountsService->editGender($pdo, $gender);
            $view->setVar('genderChanged', true);
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