<?php
namespace controllers;

use services\HumeursService;
use yasmf\HttpHelper;
use yasmf\View;

class HumeursController {

    private $humeursService;
    

    public function __construct()
    {
        session_start();
        $this->humeursService = HumeursService::getDefaultHumeursService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Humeurs");
        $listeHumeurs = $this->humeursService->getListeHumeurs();
        $view->setVar('listeHumeurs',$listeHumeurs);
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        }
        if(isset($_SESSION['msgHumeur'])) {
            $view->setVar('msgHumeur', $_SESSION['msgHumeur']);
        }
        return $view;
    }

    public function setHumeur($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Humeurs");
        $description = HttpHelper::getParam("description");
        $humeur = HttpHelper::getParam("humeur");
        $smiley = HttpHelper::getParam("smiley");
        $isOK = $this->humeursService->setHumeur($pdo, $humeur, $smiley, $description);
        if ($isOK) {
            $msgHumeur = "Votre humeur a bien été ajouté.";
        } else {
            $msgHumeur ="L'humeur saisie n'existe pas !!!";
        }
        $_SESSION['msgHumeur'] = $msgHumeur;
        header('Location: ?action=index&controller=humeurs#');
    }

}