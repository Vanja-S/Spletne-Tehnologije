<?php

require_once("ViewHelper.php");
require_once("model/UserDB.php");

class UserController
{

    public static function addUser()
    {
        $rules = [
            "name" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[A-ZŠĐČĆŽa-zšđčćž]+/"]
            ],
            "surname" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[A-ZŠĐČĆŽa-zšđčćž]+/"]
            ],
            "email" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/"]
            ],
            "password" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/"]
            ],

        ];
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["name"] = $data["name"] === false ? "Name must be made up from the Slovenian alphabet" : "";
        $errors["surname"] = $data["surname"] === false ? "Surame must be made up from the Slovenian alphabet" : "";
        $errors["email"] = $data["email"] === false ? "Enter a valid email address" : "";
        $errors["password"] = $data["password"] === false ? "Password must be at least 8 characters long, contain at least one uppercase letter, one digit, and one special character" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            UserDB::insertUser($data["name"], $data["surname"], $data["email"], $data["password"]);
            ViewHelper::redirect(BASE_URL . "home/dashboard");
        } else {
            ViewController::signupPage($data, $errors);
        }
    }

    public static function loginUser()
    {
        $rules = [
            "email" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/"]
            ],
            "password" => [
                "filter" => FILTER_DEFAULT
            ],
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $errors["email"] = $data["email"] === false ? "Enter a valid email address" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            if (!UserDB::validLoginAttempt($data["email"], $data["password"])) {
                $errors["email"] = "Invalid email or password";
                ViewController::loginPage($data, $errors);
                return;
            }
            $data = UserDB::getUser($data["email"], $data["password"]);

            $data["subpage"] = "dashboard";
            $data["account_details"] = false;
            if (isset($data["address_postcode"])) {
                $data["balance"] = UserDB::getAccountBalance($data["id"]);
                $data["account_details"] = true;
            }
            setcookie("userdata", serialize($data), 0, "/index.php/home/");
            ViewHelper::redirect(BASE_URL . "home/dashboard");
        } else {
            ViewController::loginPage($data, $errors);
        }
    }

    public static function updateUser()
    {
        $rules = [
            "name" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[A-ZŠĐČĆŽa-zšđčćž]+/"]
            ],
            "surname" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[A-ZŠĐČĆŽa-zšđčćž]+/"]
            ],
            "phone" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^(?:\+386|0)\s*(?:[1-7]\d{1}|31)\s*\d{3}\s*\d{3,4}$/"]
            ],
            "email" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/"]
            ],
            "city" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/[A-ZŠĐČĆŽa-zšđčćž]+/"]
            ],
            "postcode" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1000, "max_range" => 9265]
            ],
            "street" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[A-ZŠĐČĆŽa-zšđčćž\s+]+\s+\d+[A-ZŠĐČĆŽa-zšđčćž]*$/"]
            ],
        ];
        $data = filter_input_array(INPUT_POST, $rules);
        $errors["name"] = $data["name"] === false ? "Name must be made up from the Slovenian alphabet" : "";
        $errors["surname"] = $data["surname"] === false ? "Surame must be made up from the Slovenian alphabet" : "";
        $errors["email"] = $data["email"] === false ? "Enter a valid email address" : "";
        $errors["phone"] = $data["phone"] === false ? "Enter a valid Slovenian phone number (+386)" : "";
        $errors["city"] = $data["city"] === false ? "Enter a valid city name" : "";
        $errors["postcode"] = $data["postcode"] === false ? "Enter a valid postcode" : "";
        $errors["street"] = $data["street"] === false ? "Enter a valid street" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            $userdata = unserialize($_COOKIE["userdata"]);
            $userdata["name"] = $data["name"];
            $userdata["surname"] = $data["surname"];
            $userdata["email"] = $data["email"];
            $userdata["phone_number"] = $data["phone"];
            $userdata["address_city"] = $data["city"];
            $userdata["address_postcode"] = $data["postcode"];
            $userdata["address_street"] = $data["street"];
            UserDB::updateUser($userdata, $userdata["password_hash"]);
            $user = UserDB::getUser($userdata["email"], null, $userdata["password_hash"]);
            if (!UserDB::getAccountBalance($user["id"]))
                UserDB::createAccount($user["id"]);
            $userdata["balance"] = UserDB::getAccountBalance($user["id"]);

            setcookie("userdata", serialize($userdata), 0, "/index.php/home/");
            ViewHelper::redirect(BASE_URL . "home/my-profile");
        } else {
            $data["subpage"] = "my-profile";
            ViewController::homePage($data, $errors);
        }
    }

    public static function updateBalance($id, $balance)
    {
        $userdata = unserialize($_COOKIE["userdata"]);
        $userdata["balance"] = UserDB::updateAccountBalance($id, $balance);
        setcookie("userdata", serialize($userdata), 0, "/index.php/home/");
        ViewHelper::redirect(BASE_URL . "home/dashboard");
    }


    public static function sendTransfer($data) {
        $rules = [
            "transfer" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1, "max_range" => 10000000000000]
            ],
            "recevier_id" => [
                "filter" => FILTER_DEFAULT,
            ],
        ];
        $recived = filter_input_array(INPUT_POST, $rules);
        $userdata = unserialize($_COOKIE["userdata"]);
        if(UserDB::getAccountBalance($recived["recevier_id"])) {
            echo"<script>alert(\"The receiving user does not have an account\")</script>";
            ViewHelper::redirect(BASE_URL . "home/transactions");
        }
        UserDB::makeTransfer($recived["recevier_id"], $userdata["id"], $recived["transfer"]);
        ViewHelper::redirect(BASE_URL . "home/transactions");
    }
}