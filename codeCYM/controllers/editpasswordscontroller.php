<?php
namespace controllers;

use services\EditpasswordsService;
use yasmf\View;

class EditpasswordsController {

    private $editpasswordsService;

    public function __construct()
    {
        $this->editpasswordsService = EditpasswordsService::getDefaultEditpasswordsService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/editpassword");
        $resultats = $this->editpasswordsService->getPasswords($pdo);
        $view->setVar('resultats',$resultats);
        return $view;
    }

}