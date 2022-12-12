<?php

namespace services;

use PDOException;

class HumeursService
{

    private static $defaultHumeursService;

    public static function getDefaultHumeursService()
    {
        if (HumeursService::$defaultHumeursService == null) {
            HumeursService::$defaultHumeursService = new HumeursService();
        }
        return HumeursService::$defaultHumeursService;
    }

    public function getListeHumeurs() {
        try {
            $nomficTypes= $_SERVER['DOCUMENT_ROOT']."/CheckYourMood/codeCYM/views/humeurs.csv";
            if ( !file_exists($nomficTypes) ) {
                throw new Exception('Fichier '.$nomficTypes.' non trouvé.');
            }
            $liste = file($nomficTypes, FILE_IGNORE_NEW_LINES);
            return $liste;
        } catch ( Exception $e ) {}
    }

    public function setHumeur($pdo, $humeur, $smiley, $description) {
        if ($humeur != "") {
            $liste = self::getListeHumeurs();
            foreach ((array) $liste as $i) {
                if ($i == $humeur) {
                    $libele = htmlspecialchars($humeur);
                    $id = $_SESSION['UserID'];
                    $requete = $pdo->prepare("INSERT INTO `humeur`(`CODE_User`, `Humeur_Libelle`, `Humeur_Emoji`, `Humeur_Time`, `Humeur_Description`) 
                                                VALUES (:id,:libele,:smiley,CURRENT_TIMESTAMP,:description)");
                    $requete->bindParam("id", $id);
                    $requete->bindParam("libele", $libele);
                    $requete->bindParam("smiley", $smiley);
                    $requete->bindParam("description", $description);
                    $requete->execute();
                }
            }
        }
    }
}