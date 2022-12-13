<?php

namespace services;

use PDOException;

class RegisterService
{

    private static $defaultRegisterService;

    public static function getDefaultRegisterService()
    {
        if (RegisterService::$defaultRegisterService == null) {
            RegisterService::$defaultRegisterService = new RegisterService();
        }
        return RegisterService::$defaultRegisterService;
    }

    public static function getVerifyAlreadyUsed($pdo) {
        $verif = ($pdo->query('SELECT User_Name, User_Email FROM user'));
        return $verif;

    }

    public static function insertUserValues($pdo, $username, $email, $birthDate, $gender, $password) {
        try {
            $insert = $pdo->prepare('INSERT INTO user (User_Name,User_Email,User_BirthDate,User_Gender,User_Password) 
                                    VALUES (:username,:email,:birthDate,:gender,:pswd)');
            $insert->execute(array('username'=>$username,'email'=>$email,'birthDate'=>$birthDate,'gender'=>$gender,'pswd'=>$password));
            return "";
        } catch (PDOException $e) {
            $errorMessage = "Ce nom d'utilisateur ou cette adresse mail est déjà utilisé";
            return $errorMessage;
        }
    }

    public static function getLoginIn($pdo, $username, $password) {
        $sql = "SELECT `User_ID` FROM `user` WHERE User_Name = :name AND User_Password = :pass";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute(['name'=>$username, 'pass'=>$password]);
        $id = null;
        while ($row = $searchStmt->fetch()) {
            $id = $row->User_ID;
        }
        if ($id == null) {
            return "Login invalide, identifiant ou mot de passe incorrect !";
        }
        return $id;
    }
    
}