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
        $newPassword = HttpHelper::getParam("newPassword");
        $confirmPassword = HttpHelper::getParam("confirmPassword");
        $oldPassword = HttpHelper::getParam("oldPassword");
        while ($ligne = $resultats->fetch()) {
            $password = $ligne->User_Password;
        }
        $testOldPasswords = !empty($oldPassword) && strcmp($password, $oldPassword) == 0;
        $testNewPasswords = !empty($newPassword) && !empty($confirmPassword) && strcmp($newPassword, $confirmPassword) == 0;
        $view->setVar('password',$password);
        if($testOldPasswords && $testNewPasswords) {
            $this->editpasswordsService->editPassword($pdo, $newPassword);
            $view->setVar('test', "Mot de passe modifié");
        } else {
            $view->setVar('test', "Mot de passe non modifié");
        }
        return $view;
    }
}