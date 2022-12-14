<?php
namespace controllers;

use services\StatsService;
use yasmf\View;

class StatsController {

    private $statsService;

    public function __construct()
    {
        session_start();
        $this->statsService = StatsService::getDefaultStatsService();
    }

    public function index($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Stats");
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        } else {
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

}