<?php
namespace controllers;

use services\StatsService;
use yasmf\View;

class StatsController {

    private $statsService;

    public function __construct()
    {
        $this->statsService = StatsService::getDefaultStatsService();
    }

    public function index($pdo) {
        session_start();
        $view = new View("CheckYourMood/codeCYM/views/Stats");
        $MaxHum = $this->statsService->getMaxHumeur($pdo);
        $MaxValHum = $this->statsService->getNumberOfHumForMaxHumeur($pdo);
        $AllHumeur = $this->statsService->getAllHumeur($pdo);
        $AllHumeurTotal = $this->statsService->getNumberOfHumeurInTotal($pdo);
        $AllHumeurData = $this->statsService->getAllHumeurDate($pdo);
        $view->setVar('MaxHumeur', $MaxHum);
        $view->setVar('MaxValHum', $MaxValHum);
        $view->setVar('AllHumeur', $AllHumeur);
        $view->setVar('TotalOfHumeur', $AllHumeurTotal);
        $view->setVar('AllHumeurData', $AllHumeurData);
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        }
        return $view;
    }

    public function historyVal($pdo) {
        session_start();
        $view = new View("CheckYourMood/codeCYM/views/history");
        $resultats = $this->statsService->getHistorique($pdo);
        $allRow = $this->statsService->getAllRow($pdo);
        $view->setVar('resultats',$resultats);
        $view->setVar('allRow',$allRow);
        return $view;
    }

}