<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="/CheckYourMood/codeCYM/third-party/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="/CheckYourMood/codeCYM/CSS/editpassword.css" rel="stylesheet"/>
    <script src="/CheckYourMood/codeCYM/JS/header-component.js" defer></script>
    <title>Modification du mot de passe</title>
</head>
<body>
    <?php
        spl_autoload_extensions(".php");
        spl_autoload_register();
    ?>
    <header-component></header-component>
    <div class="container">
        <div class="row">
            <form class="main" method="post">
                <?php
                    while($row = $resultats->fetch()) {
                        $trueOldPassword = $row->User_Password;
                    }
                    $envoyer = $_POST['envoyer'];
                    if(isset($_POST['oldPassword']) && !empty($_POST['oldPassword'])) {
                        $oldPassword = $_POST['oldPassword'];
                    } else {
                        $oldPassword = "";
                    }
                    if(isset($_POST['newPassword']) && !empty($_POST['newPassword'])) {
                        $newPassword = $_POST['newPassword'];
                    } else {
                        $newPassword = "";
                    }
                    if(isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])) {
                        $confirmPassword = $_POST['confirmPassword'];
                    } else {
                        $confirmPassword = "";
                    }
                    if(isset($_POST['envoyer']) && $oldPassword = "") {
                        echo '<input class="form-control enRouge" type="text" name="oldPassword" placeholder="Veuillez mettre votre ancien mot de passe value='.$oldPassword.'"></input>';
                    } else {
                        echo '<input class="form-control" type="text" name="oldPassword" placeholder="Ancien mot de passe"></input>';
                    }
                    echo '<input class="form-control" type="text" name="newPassword" placeholder="Nouveau mot de passe"></input>';
                    echo '<input class="form-control" type="text" name="confirmPassword" placeholder="Confirmez votre mot de passe"></input>';
                    echo '<input class="button" name="envoyer" type="submit" value="Confirmer"></input>';
                    $testOldPasswords = strcmp($trueOldPassword, $oldPassword) > 0;
                    $testNewPasswords = strcmp($newPassword, $confirmPassword) < 0;
                    echo "true old mdp :";
                    echo var_dump($trueOldPassword);
                    echo "</br>";
                    echo "old mdp :";
                    echo var_dump($oldPassword);
                    echo "</br>";
                    echo "new mdp :";
                    echo var_dump($newPassword);
                    echo "</br>";
                    echo "confirm mdp :";
                    echo var_dump($confirmPassword);
                    echo "</br>";
                    echo "test old mdp 2 correct : ";
                    echo var_dump($testOldPasswords);
                    echo "</br>";
                    echo "test new mdp 2 correct :";
                    echo var_dump($testNewPasswords);
              
                    if($envoyer == TRUE && $testOldPasswords == TRUE && $testNewPasswords == TRUE) {
                        $stmt = $pdo->prepare("UPDATE user SET User_Password = :newPassword WHERE User_ID = 2");
                        $stmt->bindParam("newPassword", $newPassword);
                        $stmt->execute();
                        echo "coucou";
                    }
                ?>
            </form>
        </div>
    </div>
</body>
</html>