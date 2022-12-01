<?php
namespace controllers;

use services\AccountsService;
use yasmf\View;

class AccountsController {

    private $accountsService;

    public function __construct()
    {
        $this->accountsService = AccountsService::getDefaultAccountsService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Account");
        $resultats = $this->accountsService->getProfile($pdo);
        $view->setVar('resultats',$resultats);
        return $view;
    }

}