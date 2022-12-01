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
        $view = new View("CheckYourMood/codeCYM/views/Stats");
        $resultats = $this->statsService->getHistorique($pdo);
        $MaxHum = $this->statsService->getMaxHumeur($pdo);
        $MaxValHum = $this->statsService->getNumberOfHumForMaxHumeur($pdo);
        $view->setVar('resultats',$resultats);
        $view->setVar('MaxHumeur', $MaxHum);
        $view->setVar('MaxValHum', $MaxValHum);
        return $view;
    }

}