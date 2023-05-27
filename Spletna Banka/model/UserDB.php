<?php

require_once "DBInit.php";

class UserDB {

    // Returns true if a valid combination of a username and a password are provided.
    public static function validLoginAttempt($email, $password) {
        $dbh = DBInit::getInstance();

        $query = $dbh->prepare("SELECT COUNT(id) FROM user WHERE email = :email AND password_hash = :password_hash");
        $query->bindParam(":email", $email);
        $password_hash = hash("sha256", $password);
        $query->bindParam(":password_hash", $password_hash);
        $query->execute();

        return $query->fetchColumn(0) == 1;
    }

    public static function insertUser($name, $surname, $email, $password) {
        echo"Hello";
        $dbh = DBInit::getInstance();
        $query = $dbh->prepare("INSERT INTO user (name, surname, email, password_hash) VALUES (:name, :surname, :email, :password_hash)");

        $query->bindParam(":name", $name);
        $query->bindParam(":surname", $surname);
        $query->bindParam(":email", $email);
        $password_hash = hash("sha256", $password);
        $query->bindParam(":password_hash", $password_hash);
        
        $query->execute();
    }


}
