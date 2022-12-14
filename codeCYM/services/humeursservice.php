<?php

namespace services;

use PDOException;

class HumeursService
{

    // Singleton d'instanciation
    private static $defaultHumeursService;
    public static function getDefaultHumeursService()
    {
        if (HumeursService::$defaultHumeursService == null) {
            HumeursService::$defaultHumeursService = new HumeursService();
        }
        return HumeursService::$defaultHumeursService;
    }

    /**
     * Permet d'obtenir la liste des humeurs depuis un fichier externes
     * @return liste contenant toutes les humeurs 
     */
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

    /**
     * Permet l'insertion de l'humeur d'un utilisateur
     * @param $pdo \PDO the pdo object
     * @param $humeur libellé de l'humeur
     * @param $smiley smiley associé à l'humeur
     * @param $description commentaire que peut saisir un utilisateur (facultatif)
     */
    public function setHumeur($pdo, $humeur, $smiley, $description) {
        if ($humeur != "") {
            $liste = self::getListeHumeurs();
            foreach ((array) $liste as $i) {
                if (strcasecmp($i, $humeur) == 0) {
                    $libelle = htmlspecialchars($humeur);
                    $id = $_SESSION['UserID'];
                    $requete = $pdo->prepare("INSERT INTO `humeur`(`CODE_User`, `Humeur_Libelle`, `Humeur_Emoji`, `Humeur_Time`, `Humeur_Description`) 
                                                VALUES (:id,:libelle,:smiley,CURRENT_TIMESTAMP,:description)");
                    $requete->bindParam("id", $id);
                    $requete->bindParam("libelle", $libelle);
                    $requete->bindParam("smiley", $smiley);
                    $requete->bindParam("description", $description);
                    $requete->execute();
                }
            }
        }
    }
}