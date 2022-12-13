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
        if (isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Account");
            $resultats = $this->accountService->getProfile($pdo, $_SESSION['UserID']);
            while($row = $resultats->fetch()) {
                $view->setVar('mail', $row->User_Email);
                $view->setVar('username', $row->User_Name);
                $view->setVar('password', $row->User_Password);
                $view->setVar('birthDate', $row->User_BirthDate);
                $view->setVar('gender', $row->User_Gender);
            }
        } else {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        }
        return $view;
    }

    public function registerAndLogin($pdo) {
        session_start();
        $username = HttpHelper::getParam("username");
        $email = HttpHelper::getParam("email");
        $birthDate = HttpHelper::getParam("birth-date");
        $gender = HttpHelper::getParam("gender");
        $password = HttpHelper::getParam("password");
        $confirmPassword = HttpHelper::getParam("confirm-password");
        $login = HttpHelper::getParam("login");

        $view = new View("CheckYourMood/codeCYM/views/Register");
        if (isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Account");
        } else if ($username != null && $email != null && $birthDate != null && $gender != "Choisissez votre genre" && $password != null && $confirmPassword != null) {
            // Register
            $error = $this->registerService->insertUserValues($pdo, $username, $email, $birthDate, $gender, $password, $confirmPassword);
            if ($error == "") {
                $email = null;
                $birthDate = null;
                $gender = null;
                $confirmPassword = null;
            } else {
                $view->setVar('error', $error);
            }
        } else if ($username != null && $password != null && $login == 1) {
            // Login
            $result = $this->registerService->getLoginIn($pdo, $username, $password);
            if (is_integer($result)) {
                $_SESSION['UserID'] = $result;
                $view = new View("CheckYourMood/codeCYM/views/index");
                return $view;
            } else {
                $view->setVar('error', $result);
            }
        } else {
            $view->setVar('error', "Manque des valeurs");
        }
        $view->setVar('username', $username);
        $view->setVar('email', $email);
        $view->setVar('birthDate', $birthDate);
        $view->setVar('gender', $gender);
        $view->setVar('password', $password);
        $view->setVar('confirmPassword', $confirmPassword);
        return $view;
    }
}