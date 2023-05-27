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
            //ViewHelper::redirect(BASE_URL . "home");
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
            ViewController::homePage($data, $errors);
        } else {
            ViewController::loginPage($data, $errors);
            return;
        }
    }
}