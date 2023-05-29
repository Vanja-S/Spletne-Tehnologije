<?php

require_once("controller/ViewController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "home/dashboard" => function () {
        if (isset($_COOKIE["userdata"])) {
            $data = unserialize($_COOKIE["userdata"]);
            ViewController::homePage($data);
        } else
            ViewHelper::redirect(BASE_URL . "login");
    },
    "home/my-profile" => function () {
        if (isset($_COOKIE["userdata"])) {
            $data = unserialize($_COOKIE["userdata"]);
            $data["subpage"] = "my-profile";
            ViewController::homePage($data);
        } else
            ViewHelper::redirect(BASE_URL . "login");
    },
    "home/transactions" => function () {
        if (isset($_COOKIE["userdata"])) {
            $data = unserialize($_COOKIE["userdata"]);
            $data["subpage"] = "transactions";
            ViewController::homePage($data);
        } else
            ViewHelper::redirect(BASE_URL . "login");
    },
    "home/my-profile/update-profile" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::updateUser();
        } else
            ViewHelper::redirect(BASE_URL . "home/my-profile");
    },
    "home/my-profile/update-balance" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = unserialize($_COOKIE["userdata"]);
            UserController::updateBalance($data["id"], intval($_POST["top-up-input"]));
        } else
            ViewHelper::redirect(BASE_URL . "home/dashboard");
    },
    "home/transactions/transfer" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = unserialize($_COOKIE["userdata"]);
            UserController::sendTransfer($data["id"]);
        } else
            ViewHelper::redirect(BASE_URL . "home/transactions");
    },
    "home/signout" => function () {
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }
        ViewHelper::redirect(BASE_URL . "welcome");
    },
    "welcome" => function () {
        ViewController::index();
    },
    "login" => function () {
        ViewController::loginPage();
    },
    "signup" => function () {
        ViewController::signupPage();
    },
    "user/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::addUser();
        } else {
            ViewController::signupPage();
        }
    },
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::loginUser();
        } else {
            ViewController::loginPage();
        }
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "welcome");
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    ViewHelper::error404();
}