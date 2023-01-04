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
        $startDate = HttpHelper::getParam("startDate");
        $endDate = HttpHelper::getParam("endDate");
        $humeurs = HttpHelper::getParam("humeurs");
        if (!isset($_SESSION['UserID'])) {
            $view = new View("CheckYourMood/codeCYM/views/Register");
        } else {
            $MaxHum = $this->statsService->getMaxHumeur($pdo);
            $MaxHum2 = $this->statsService->getMaxHumeur($pdo);
            $listeHumeurs = $this->humeursService->getListeHumeurs();
            $view->setVar('listeHumeurs',$listeHumeurs);
            $view->setVar('MaxHumeur', $MaxHum);
            $view->setVar('MaxHumeur2', $MaxHum2);
            $AllValue1 = $this->statsService->getAllValue($pdo);
            $AllValue2 = $this->statsService->getAllValue($pdo);
            $AllValue3 = $this->statsService->getAllValue($pdo);
            $AllValue4 = $this->statsService->getAllValue($pdo);
            $view->setVar('allValue1', $AllValue1);
            $view->setVar('allValue2', $AllValue2);
            $view->setVar('allValue3', $AllValue3);
            $view->setVar('allValue4', $AllValue4);
            $valueByDate1 = $this->statsService->getHumeurByTime($pdo, $startDate, $endDate, $humeurs);
            $valueByDate2 = $this->statsService->getHumeurByTime($pdo, $startDate, $endDate, $humeurs);
            $view->setVar('valueByDate1', $valueByDate1);
            $view->setVar('valueByDate2', $valueByDate2);
            $view->setVar('humeurSelected', $humeurs);
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
        if ($endDate == "" || $startDate == "") {
            $result = "<p>Veuillez selectionner la date de début ainsi que la date de fin.</p><p class='smiley'>🚫</p>";
        } else if ($endDate < $startDate) {
            $result = "<p>La date de début doit être antérieure à la date de fin.</p><p class='smiley'>🚫</p> ";
        } else if ($emojiUsed == "") {
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
        
        $MaxHum = $this->statsService->getMaxHumeur($pdo);
        $view->setVar('MaxHumeur', $MaxHum);
        $MaxHum2 = $this->statsService->getMaxHumeur($pdo);
        $view->setVar('MaxHumeur2', $MaxHum2);
        $AllValue1 = $this->statsService->getAllValue($pdo);
        $AllValue2 = $this->statsService->getAllValue($pdo);
        $AllValue3 = $this->statsService->getAllValue($pdo);
        $AllValue4 = $this->statsService->getAllValue($pdo);
        $view->setVar('allValue1', $AllValue1);
        $view->setVar('allValue2', $AllValue2);
        $view->setVar('allValue3', $AllValue3);
        $view->setVar('allValue4', $AllValue4);
        $valueByDate1 = $this->statsService->getHumeurByTime($pdo, $startDate, $endDate, $humeurs);
        $valueByDate2 = $this->statsService->getHumeurByTime($pdo, $startDate, $endDate, $humeurs);
        $view->setVar('valueByDate1', $valueByDate1);
        $view->setVar('valueByDate2', $valueByDate2);
        $view->setVar('humeurSelected', $humeurs);
        return $view;
    }

    /**
     * permet de récupérer les données quantitatives sur une ou plusieurs humeurs
     * affiche le nombre de saisies d'une humeur par rapport au nombre total
     * de saisies de toutes les humeurs, ainsi qu'un pourcentage de saisie
     * de cette humeur
     */
    public function donneesQuantitatives($pdo) {
        $view = new View("CheckYourMood/codeCYM/views/Stats");
        $nombreTotHumeursSaisies = $this->statsService->getNombreTotalHumeursSaisies($pdo);
        $tabHumeurs = $this->statsService->getListeHumeurs($pdo);
        $view->setVar('tabHumeurs',$tabHumeurs);
        return $view;
    }

}