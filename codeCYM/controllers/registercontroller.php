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

    public function register($pdo) {
        session_start();
        new User();

        $view = new View("CheckYourMood/codeCYM/views/Register");
        if (User::$username != null && User::$email != null && User::$birthDate != null && User::$gender != "Choisissez votre genre" && User::$password != null && User::$confirmPassword != null) {
            // Register
            $error = $this->registerService->insertUserValues($pdo, User::$username, User::$email, User::$birthDate, User::$gender, User::$password, User::$confirmPassword);
            if ($error == "") {
                User::$email = null;
                User::$birthDate = null;
                User::$gender = null;
                User::$confirmPassword = null;
            }
            $view->setVar('registerError', $error);
        } else {
            $view->setVar('registerError', "Manque des valeurs");
        }
        return User::sendValues($view);
    }

    public function login($pdo) {
        session_start();
        new User();

        $view = new View("CheckYourMood/codeCYM/views/Register");
        if (isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Account");
        } else if (User::$username != null && User::$password != null && User::$login == 1) {
            // Login
            $result = $this->registerService->getLoginIn($pdo, User::$username, User::$password);
            if (is_integer($result)) {
                $_SESSION['UserID'] = $result;
                $view = new View("CheckYourMood/codeCYM/views/index");
                return $view;
            }
            $view->setVar('loginError', $result);
        } else {
            $view->setVar('loginError', "Manque des valeurs");
        }
        return User::sendValues($view);
    }
}

class User {
    public static $username;
    public static $email;
    public static $birthDate;
    public static $gender;
    public static $password;
    public static $confirmPassword;
    public static $login;

    public function __construct()
    {
        User::$username = HttpHelper::getParam("username");
        User::$email = HttpHelper::getParam("email");
        User::$birthDate = HttpHelper::getParam("birth-date");
        User::$gender = HttpHelper::getParam("gender");
        User::$password = HttpHelper::getParam("password");
        User::$confirmPassword = HttpHelper::getParam("confirm-password");
        User::$login = HttpHelper::getParam("login"); 
    }

    public static function sendValues($view) {
        $view->setVar('username', User::$username);
        $view->setVar('email', User::$email);
        $view->setVar('birthDate', User::$birthDate);
        $view->setVar('gender', User::$gender);
        $view->setVar('password', User::$password);
        $view->setVar('confirmPassword', User::$confirmPassword);
        return $view;
    }

}