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
            $MaxHum = $this->statsService->getMaxHumeur($pdo);
            $listeHumeurs = $this->humeursService->getListeHumeurs();
            $view->setVar('listeHumeurs',$listeHumeurs);
            $view->setVar('MaxHumeur', $MaxHum);
            $AllValue1 = $this->statsService->getAllValue($pdo);
            $AllValue2 = $this->statsService->getAllValue($pdo);
            $view->setVar('allValue1', $AllValue1);
            $view->setVar('allValue2', $AllValue2);
        }
        return $view;
    }

    public function historyVal($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/history");
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        } else {
            $sort = "";
            if (!empty(HttpHelper::getParam("sortHumeur"))) $sort = HttpHelper::getParam("sortHumeur");
            else if (!empty(HttpHelper::getParam("sortHumeurDesc"))) $sort = HttpHelper::getParam("sortHumeurDesc");
            else if (!empty(HttpHelper::getParam("sortDate"))) $sort = HttpHelper::getParam("sortDate");
            else if (!empty(HttpHelper::getParam("sortDateDesc"))) $sort = HttpHelper::getParam("sortDateDesc");
            $resultats = $this->statsService->getHistorique($pdo, $sort);
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
            $result = "<p class='smiley'>".$emojiUsed[0]."</p><p> Vous avez eu l'humeur ".$emojiUsed[1]." fois entre le ".$startDate." et le ".$endDate."</p>";
        } else {
            $result = "<p class='smiley'>♾️</p><p>Vous avez utilisé un total de ".$emojiUsed[0]." humeurs entre le ".$startDate." et le ".$endDate."</p>";
        }
        $view->setVar('emojiUsed', $result);
        $view->setVar('listeHumeurs',$listeHumeurs);
        $view->setVar('startDate', $startDate);
        $view->setVar('endDate', $endDate);
        $view->setVar('humeurs', $humeurs);
        return $view;
    }

}