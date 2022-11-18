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
        // Connexion à la BDD
        $pdo=new PDO($dsn,$user,$pass,$options);
        // à modifier : CODE_User, Humeur_Description
        if (isset($_POST["humeurs-liste"])) {
            $libele = htmlspecialchars($_POST['humeurs-liste']);
            $smiley = "";
            $stmt = $pdo->prepare("INSERT INTO `humeur`(`CODE_User`, `Humeur_Libelle`, `Humeur_Emoji`, `Humeur_Time`, `Humeur_Description`) 
                                      VALUES (1,:libele,:smiley,CURRENT_TIMESTAMP,'')");
            $stmt->bindParam("libele", $libele);
			$stmt->bindParam("smiley", $smiley);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        // Toute exception est renvoyé ici
        echo "<h1>Erreur BD ".$e->getMessage();
    }

    try{
        $nomficTypes="./humeurs.csv" ;
        if ( !file_exists($nomficTypes) ) {
            throw new Exception('Fichier '.$nomficTypes.' non trouvé.');
        }
        $listeHumeurs = file($nomficTypes, FILE_IGNORE_NEW_LINES);
    } catch ( Exception $e ) {}
    ?>
    <header-component></header-component>
    <div class="container">
        <div class="d-flex d-row justify-content-center">
            <span id="time"></span>
        </div>
        <form class="humeurs-container" action="#" method="post">
            <div class="row border-form">
                <div class="col col-md-8 col-9">
                    <input class="humeurs-liste" list="humeurs-liste" name="humeurs-liste" onchange="getSmiley(this)">
                    <datalist id="humeurs-liste" >
                        <?php
                            foreach ($listeHumeurs as $i) {
								echo "<option value='".$i."'></option>";
							}
                        ?>
                    </datalist>
                </div>
                <div class="col col-md-2 col-3 smiley-zone">
                    <p name="smiley" id="smiley"></p>
                </div>
                <div class="col col-md-2 col-12 envoyer-zone">
                    <button class="bouton-envoyer"><i class="fa-solid fa-location-arrow"></i></button>
                </div>
            </div>
        </form>
    </div>
</body>
<script>
    function refreshTime() {
        const timeDisplay = document.getElementById("time");
        const dateString = new Date().toLocaleTimeString();
        timeDisplay.textContent = dateString;
    }
    setInterval(refreshTime, 1000);

    function getSmiley(element) {
        var saisie = (element.value || element.options[element.selectedIndex].value); 
        switch ((""+saisie).toLowerCase()) {
            case 'admiration': smiley = "😊"; break;
            case 'adoration': smiley = "🤤"; break;
            case 'appréciation esthétique': smiley = "🖼️"; break;
            case 'amusement': smiley = "🥳"; break;
            case 'colère': smiley = "😠"; break;
            case 'anxiété': smiley = "😰"; break;
            case 'emerveillement': smiley = "🤩"; break;
            case 'malaise (embarrassement)': smiley = "😖"; break;
            case 'ennui': smiley = "🥱"; break;
            case 'calme (sérénité)': smiley = "😐"; break;
            case 'confusion': smiley = "😕"; break;
            case 'envie (craving)': smiley = "🥵"; break;
            case 'dégoût': smiley = "🤢"; break;
            case 'douleur empathique': smiley = "💔"; break;
            case 'intérêt étonné, intrigué': smiley = "🤔"; break;
            case 'excitation (montée d’adrénaline)': smiley = "🤪"; break;
            case 'peur': smiley = "😨"; break;
            case 'horreur': smiley = "😱"; break;
            case 'intérêt': smiley = "🧐"; break;
            case 'joie': smiley = "😄"; break;
            case 'nostalgie': smiley = "🎆"; break;
            case 'soulagement': smiley = "😌"; break;
            case 'romance': smiley = "🌹"; break;
            case 'tristesse': smiley = "😥"; break;
            case 'satisfaction': smiley = "👍"; break;
            case 'désir sexuel': smiley = "😏"; break;
            case 'surprise': smiley = "🙀"; break;
            default:
                smiley = "🚫";
        }
        document.getElementById('smiley').innerText = smiley;
    }
</script>
</html>