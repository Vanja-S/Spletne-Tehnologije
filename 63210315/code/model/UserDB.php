<?php

require_once "DBInit.php";

class UserDB
{

    // Returns true if a valid combination of a username and a password are provided.
    public static function validLoginAttempt($email, $password)
    {
        $dbh = DBInit::getInstance();

        $query = $dbh->prepare("SELECT COUNT(id) FROM user WHERE email = :email AND password_hash = :password_hash");
        $query->bindParam(":email", $email);
        $password_hash = hash("sha256", $password);
        $query->bindParam(":password_hash", $password_hash);
        $query->execute();

        return $query->fetchColumn(0) == 1;
    }

    public static function insertUser($name, $surname, $email, $password)
    {
        $dbh = DBInit::getInstance();
        $query = $dbh->prepare("INSERT INTO user (name, surname, email, password_hash) VALUES (:name, :surname, :email, :password_hash)");

        $query->bindParam(":name", $name);
        $query->bindParam(":surname", $surname);
        $query->bindParam(":email", $email);
        $password_hash = hash("sha256", $password);
        $query->bindParam(":password_hash", $password_hash);

        $query->execute();
    }

    public static function getUser($email, $password, $password_h = null)
    {
        $db = DBInit::getInstance();

        $query = $db->prepare("SELECT * FROM user WHERE email = :email AND password_hash = :password_hash");
        $query->bindParam(":email", $email);
        $password_hash = hash("sha256", $password);
        if($password_h == null)
            $query->bindParam(":password_hash", $password_hash);
        else
            $query->bindParam(":password_hash", $password_h);
        $query->execute();

        $user = $query->fetch();

        if ($user != null) {
            return $user;
        } else {
            throw new InvalidArgumentException("No record with user email $email");
        }
    }

    public static function getUserBalance($id)
    {
        $db = DBInit::getInstance();

        $query = $db->prepare("SELECT * FROM account WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();

        $detail = $query->fetch();

        return $detail;
    }

    public static function updateUser($data, $password)
    {
        $db = DBInit::getInstance();

        $query = $db->prepare("UPDATE `user` SET name = :name, surname = :surname, email = :email, phone_number = :phone, address_postcode = :postcode, address_city = :city, address_street = :street WHERE email = :email AND password_hash = :password_hash");
        $query->bindParam(":name", $data["name"]);
        $query->bindParam(":surname", $data["surname"]);
        $query->bindParam(":email", $data["email"]);
        $query->bindParam(":phone", $data["phone"]);
        $query->bindParam(":postcode", $data["postcode"]);
        $query->bindParam(":city", $data["city"]);
        $query->bindParam(":street", $data["street"]);
        $query->bindParam(":password_hash", $password);
        $query->execute();
    }

    public static function createAccount($id) {
        $db = DBInit::getInstance();

        $query = $db->prepare("INSERT INTO account (id) VALUES (:id)");
        $query->bindParam(":id", $id);
        $query->execute();
    }

    public static function getAccountBalance($id) {
        $db = DBInit::getInstance();

        $query = $db->prepare("SELECT assets FROM `account` WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->fetchColumn(0);
    }

    public static function updateAccountBalance($id, $balance) {
        $db = DBInit::getInstance();

        $query = $db->prepare("UPDATE `account` SET assets = assets + :adding WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->bindParam(":adding", $balance);
        $query->execute();

        $query = $db->prepare("SELECT assets FROM `account` WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->fetchColumn(0);
    }

    public static function getAccountTransactions($id) {
        $db = DBInit::getInstance();

        $query = $db->prepare("SELECT * FROM `transaction` WHERE receiver_id = :id OR sender_id = :id");
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->fetchAll();
    }

    public static function makeTransfer($id_r, $id_s, $transfer) {
        $db = DBInit::getInstance();

        $query = $db->prepare("INSERT INTO `transaction`(`receiver_id`, `sender_id`, `amount`, `date`) VALUES (:id_r, :id_s, :transfer, :date)");
        $query->bindParam(":id_r", $id_r);
        $query->bindParam(":id_s", $id_s);
        $query->bindParam(":transfer", $transfer);
        $date = date('Y-m-d');
        $query->bindParam(":date", $date);

        $query->execute();

        $query = $db->prepare("UPDATE `account` SET assets = assets + :adding WHERE id = :id_r");
        $query->bindParam(":id_r", $id_r);
        $query->bindParam(":adding", $transfer);
        $query->execute();

        $query = $db->prepare("UPDATE `account` SET assets = assets - :adding WHERE id = :id_s");
        $query->bindParam(":id_s", $id_s);
        $query->bindParam(":adding", $transfer);
        $query->execute();
    }
}