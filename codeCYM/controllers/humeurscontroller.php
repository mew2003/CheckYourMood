<?php
namespace controllers;

use services\HumeursService;
use yasmf\HttpHelper;
use yasmf\View;

class HumeursController {

    private $humeursService;

    public function __construct()
    {
        $this->humeursService = HumeursService::getDefaultHumeursService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Humeurs");
        $listeHumeurs = $this->humeursService->getListeHumeurs();
        $view->setVar('listeHumeurs',$listeHumeurs);
        return $view;
    }

    public function setHumeur($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Humeurs");
        $description = HttpHelper::getParam("description");
        $humeur = HttpHelper::getParam("humeur");
        $smiley = HttpHelper::getParam("smiley");
        $test = $this->humeursService->setHumeur($pdo, $humeur, $smiley, $description);
        $view->setVar('test',$test);
        return $view;
    }

}