<?php
namespace controllers;

use services\RegisterService;
use services\AccountsService;
use yasmf\HttpHelper;
use yasmf\View;

class RegisterController {

    private $registerService;
    private $accountService;

    public function __construct()
    {
        $this->registerService = RegisterService::getDefaultRegisterService();
        $this->accountService = AccountsService::getDefaultAccountsService();
    }

    public function index($pdo) {
        session_start();
        $view = new View("CheckYourMood/codeCYM/views/Register");
        $verifList = $this->registerService->getVerifyAlreadyUsed($pdo);
        $view->setVar('verifList', $verifList);
        $username = HttpHelper::getParam("username");
        $email = HttpHelper::getParam("email");
        $birthDate = HttpHelper::getParam("birth-date");
        $gender = HttpHelper::getParam("gender");
        $password = HttpHelper::getParam("password");
        $confirmPassword = HttpHelper::getParam("confirm-password");
        $login = HttpHelper::getParam("login");
        $error = "";
        $view->setVar('username', $username);
        $view->setVar('email', $email);
        $view->setVar('birthDate', $birthDate);
        $view->setVar('gender', $gender);
        $view->setVar('password', $password);
        $view->setVar('confirmPassword', $confirmPassword);
        if ($username != null && $email != null && $birthDate != null && $gender != "Choisissez votre genre" && $password != null) {
            $error = $this->registerService->insertUserValues($pdo, $username, $email, $birthDate, $gender, $password);
        } else if ($username != null && $password != null && $login == 1) {
            $result = $this->registerService->getUserId($pdo, $username);
            $_SESSION['UserID'] = $result; // ATTENTION VERIFIER QUE LE MOT DE PASSE SOIT LE BON, POUR LE MOMENT AUCUNE VERIF CONNECTE DIRECTEMENT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
        if (isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Account");
            $resultats = $this->accountService->getProfile($pdo, $_SESSION['UserID']);
            while($row = $resultats->fetch()) {
                $view->setVar('mail', $row->User_Email);
                $view->setVar('username', $row->User_Name);
                $view->setVar('password', $row->User_Password);
                $view->setVar('dateOfBirth', $row->User_BirthDate);
                $view->setVar('gender', $row->User_Gender);
            }
        }
        $view->setVar('error', $error);
        return $view;
    }
}