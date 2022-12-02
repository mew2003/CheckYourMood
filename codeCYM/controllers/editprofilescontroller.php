<?php
namespace controllers;

use yasmf\HttpHelper;
use services\EditprofilesService;
use yasmf\View;

class EditprofilesController {

    private $editMailsService;
    private $editUsernamesService;

    public function __construct()
    {
        $this->editMailsService = EditprofilesService::getDefaultEditprofilesService();
        $this->editUsernamesService = EditprofilesService::getDefaultEditprofilesService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/editprofile");
        $email = HttpHelper::getParam("email");
        $username = HttpHelper::getParam("pseudo");	
        if(!empty($email) && !empty($username)) {
            $this->editMailsService->editMail($pdo, $email);
            $this->editUsernamesService->editUsername($pdo, $username);
            $view->setVar('test', "Profil modifié");
        } else {
            $view->setVar('test', "Profil non modifié");
        }
        return $view;
    }
}