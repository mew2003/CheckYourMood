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
        $insert = $pdo->prepare('INSERT INTO user (User_Name,User_Email,User_BirthDate,User_Gender,User_Password) 
                                 VALUES (:username,:email,:birthDate,:gender,:pswd)');
        $insert->execute(array('username'=>$username,'email'=>$email,'birthDate'=>$birthDate,'gender'=>$gender,'pswd'=>$password));
    }

    public static function getUserId($pdo, $username) {
        $sql = "SELECT `User_ID` FROM `user` WHERE User_Name = :name";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute(['name'=>$username]);
        while ($row = $searchStmt->fetch()) {
            $id = $row->User_ID;
        }
        return $id;
    }
    
}