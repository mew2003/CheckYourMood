<?php
namespace controllers;

use yasmf\HttpHelper;
use services\DeleteaccountsService;
use yasmf\View;

class DeleteaccountsController {

    private $accountsService;

    public function __construct()
    {
        $this->DeleteaccountsService = DeleteaccountsService::getDefaultDeleteaccountsService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/deleteaccount");
        $delete = HttpHelper::getParam("delete");
        if(!empty($delete)) {
            $this->DeleteaccountsService->DeleteProfile($pdo);
            $view = new View("CheckYourMood/codeCYM/views/accountdeleted");
            $view->setVar('test', "Compte supprimé");
        } else {
            $view->setVar('test', "Compte non supprimé");
        }
        return $view;
    }

}