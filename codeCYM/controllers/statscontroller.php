<?php
namespace controllers;

use services\StatsService;
use services\HumeursService;
use yasmf\View;
use yasmf\HttpHelper;

class StatsController {

    private $statsService;

    public function __construct()
    {
        session_start();
        $this->statsService = StatsService::getDefaultStatsService();
        $this->humeursService = HumeursService::getDefaultHumeursService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Stats");
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        } else {
            $MaxHumLib = $this->statsService->getMaxHumeurLib($pdo);
            $MaxHumCount = $this->statsService->getMaxHumeurCount($pdo);
            $MaxValHum = $this->statsService->getNumberOfHumForMaxHumeur($pdo);
            $AllHumeur = $this->statsService->getAllHumeur($pdo);
            $AllHumeurTotal = $this->statsService->getNumberOfHumeurInTotal($pdo);
            $AllHumeurData = $this->statsService->getAllHumeurDate($pdo);
            $listeHumeurs = $this->humeursService->getListeHumeurs();
            $view->setVar('listeHumeurs',$listeHumeurs);
            $view->setVar('MaxHumeurLib', $MaxHumLib);
            $view->setVar('MaxHumeurCount', $MaxHumCount);
            $view->setVar('MaxValHum', $MaxValHum);
            $view->setVar('AllHumeur', $AllHumeur);
            $view->setVar('TotalOfHumeur', $AllHumeurTotal);
            $view->setVar('AllHumeurData', $AllHumeurData);
        }
        return $view;
    }

    public function historyVal($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/history");
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        } else {
            $resultats = $this->statsService->getHistorique($pdo);
            $allRow = $this->statsService->getAllRow($pdo);
            $view->setVar('resultats',$resultats);
            $view->setVar('allRow',$allRow);
        }
        return $view;
    }

    /**
     * Option that the user choose for floating graphics and text in stats
     */
    public function optionSelected($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Stats");
        $startDate = HttpHelper::getParam("startDate");
        $endDate = HttpHelper::getParam("endDate");
        $humeurs = HttpHelper::getParam("humeurs");
        $listeHumeurs = $this->humeursService->getListeHumeurs();
        $emojiUsed = $this->statsService->getMostUsed($pdo, $startDate, $endDate, $humeurs);
        if ($emojiUsed == "") {
            $result = "<p>L'humeur n'a jamais été saisie entre le ".$startDate." et le ".$endDate."</p>";
        } else if (count($emojiUsed) == 2) {
            $result = "<p>".$emojiUsed[0]."</p><p> Vous avez eu l'humeur ".$emojiUsed[1]." fois entre le ".$startDate." et le ".$endDate."</p>";
        } else {
            $result = "<p>♾️</p><p>Vous avez utilisé un total de ".$emojiUsed[0]." humeurs entre le ".$startDate." et le ".$endDate."</p>";
        }
        $view->setVar('emojiUsed', $result);
        $view->setVar('listeHumeurs',$listeHumeurs);
        $view->setVar('startDate', $startDate);
        $view->setVar('endDate', $endDate);
        $view->setVar('humeurs', $humeurs);
        return $view;
    }

}