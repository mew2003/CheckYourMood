<?php
namespace controllers;

use yasmf\HttpHelper;
use services\EditpasswordsService;
use yasmf\View;

class EditpasswordsController {

    private $editpasswordsService;
    private $passwordsService;

    public function __construct()
    {
        $this->editpasswordsService = EditpasswordsService::getDefaultEditpasswordsService();
        $this->passwordsService = EditpasswordsService::getDefaultEditpasswordsService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/editpassword");
        $resultats = $this->editpasswordsService->getPasswords($pdo);
        $view->setVar('resultats',$resultats);
        return $view;
    }

    public function setPassword($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/editpassword");
        $newPassword = HttpHelper::getParam("newPassword") ? : "mouais";
        $resultats = $this->editpasswordsService->getPasswords($pdo);
        $this->passwordsService->editPassword($pdo, $newPassword);
        $view->setVar('resultats',$resultats);
        return $view;
    }

}