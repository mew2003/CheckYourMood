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
        return $view;
    }

    public function insertUserValuesController($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Register");
        $username = HttpHelper::getParam("username");
        $email = HttpHelper::getParam("email");
        $birthDate = HttpHelper::getParam("birth-date");
        $gender = HttpHelper::getParam("gender");
        $password = HttpHelper::getParam("password");
        $verifList = $this->registerService->getVerifyAlreadyUsed($pdo);
        $this->registerService->insertUserValues($pdo, $username, $email, $birthDate, $gender, $password);
        $view->setVar('verifList', $verifList);
        return $view;
    }
}