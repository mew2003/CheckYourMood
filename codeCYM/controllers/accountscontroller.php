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
        $view = new View("CheckYourMood/codeCYM/views/editprofile");
        $email = HttpHelper::getParam("email");
        $username = HttpHelper::getParam("pseudo");	
        if(!empty($email) && !empty($username)) {
            $this->accountsService->editMail($pdo, $email);
            $this->accountsService->editUsername($pdo, $username);
            $view->setVar('test', "Profil modifié");
        } else {
            $view->setVar('test', "Profil non modifié");
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
        $view = new View("CheckYourMood/codeCYM/views/index");
        return $view;
    }

}