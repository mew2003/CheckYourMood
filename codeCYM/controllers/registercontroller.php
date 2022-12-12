<?php
namespace controllers;

use services\RegisterService;
use yasmf\HttpHelper;
use yasmf\View;

class RegisterController {

    private $registerService;

    public function __construct()
    {
        $this->registerService = RegisterService::getDefaultRegisterService();
    }

    public function index($pdo) {
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
        $view->setVar('username', $username);
        $view->setVar('email', $email);
        $view->setVar('birthDate', $birthDate);
        $view->setVar('gender', $gender);
        $view->setVar('password', $password);
        $view->setVar('confirmPassword', $confirmPassword);
        if ($username != "" && $email != "" && $birthDate != "" && $gender != "Choisissez votre genre" && $password != "") {
            $this->testService->insertUserValues($pdo, $username, $email, $birthDate, $gender, $password);
        } else if ($username != null && $password != null && $login == 1) {
            session_start();

            $result = $this->registerService->getUserId($pdo, $username);
            $_SESSION['UserID'] = $result; // ATTENTION VERIFIER QUE LE MOT DE PASSE SOIT LE BON, POUR LE MOMENT AUCUNE VERIF CONNECTE DIRECTEMENT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
        return $view;
    }
}