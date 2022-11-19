<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humeurs</title>
    <link rel="stylesheet" href="../third-party/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../CSS/humeurs.css">
    <link rel="stylesheet" href="../third-party/fontawesome-free-6.2.0-web/css/all.css">
    <script src="../JS/header-component.js" defer></script>
    <script src="../JS/humeurs.js"></script>
</head>
<body>
    <?php 
    
    $host='localhost';	// Serveur de BD
	$db='cym';		// Nom de la BD
	$user='root';		// User 
	$pass='root';		// Mot de passe
	$charset='utf8mb4';	// charset utilisé

    // Constitution variable DSN
    $dsn="mysql:host=$host;dbname=$db;charset=$charset";
    
    // Réglage des options
    $options=[																				 
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES=>false];


    try {
        $nomficTypes="./humeurs.csv" ;
        if ( !file_exists($nomficTypes) ) {
            throw new Exception('Fichier '.$nomficTypes.' non trouvé.');
        }
        $listeHumeurs = file($nomficTypes, FILE_IGNORE_NEW_LINES);
    } catch ( Exception $e ) {}

    try {
        // Connexion à la BDD
        $pdo=new PDO($dsn,$user,$pass,$options);
        if (isset($_POST["humeur"]) && $_POST["humeur"] != "") {
            foreach ($listeHumeurs as $humeur) {
                if ($humeur == $_POST["humeur"]) {
                    $libele = htmlspecialchars($_POST['humeur']);
                    $smiley = $_POST["smiley"];
                    if (isset($_POST["description"])) $description = htmlspecialchars($_POST['description']);
                    else $description = "";
                    // /!\ NE PAS OUBLIER DE CHANGER CODE_USER PAR LE CODE SESSION
                    $requete = $pdo->prepare("INSERT INTO `humeur`(`CODE_User`, `Humeur_Libelle`, `Humeur_Emoji`, `Humeur_Time`, `Humeur_Description`) 
                                              VALUES (1,:libele,:smiley,CURRENT_TIMESTAMP,:description)");
                    $requete->bindParam("libele", $libele);
                    $requete->bindParam("smiley", $smiley);
                    $requete->bindParam("description", $description);
                    $requete->execute();
                }
            }
        }
    } catch (PDOException $e) {
        // Toute exception est renvoyé ici
        echo "<h1>Erreur BD ".$e->getMessage();
    }
    ?>
    <header-component></header-component>
    <div class="container">
        <div class="d-flex d-row justify-content-center">
            <span id="time"></span>
        </div>
        <form class="humeurs-container" action="#" method="post">
            <div class="row border-form">
                <div class="col col-12 description-zone">
                    <textarea name="description" placeholder="Décrivez un contexte actuel (ex. Je viens de remporter l'euro million !)"></textarea>
                </div>
                <div class="col col-md-8 col-9">
                    <input class="humeurs-liste" list="humeurs-liste" name="humeur" oninput="getSmiley(this)" placeholder="Saisissez votre humeur (ex. Joie)">
                    <datalist id="humeurs-liste" >
                        <?php
                            foreach ($listeHumeurs as $i) {
								echo "<option value='".$i."'></option>";
							}
                        ?>
                    </datalist>
                </div>
                <div class="col col-md-2 col-3 smiley-zone">
                    <input name="smiley" id="smiley" readonly placeholder="❔">
                </div>
                <div class="col col-md-2 col-12 envoyer-zone">
                    <button class="bouton-envoyer"><i class="fa-solid fa-location-arrow"></i></button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>