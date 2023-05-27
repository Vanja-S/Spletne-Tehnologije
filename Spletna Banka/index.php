<?php

require_once("controller/ViewController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "home" => function () {
        ViewController::homePage();
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
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::addUser();
        } else {
            ViewController::signupPage();
        }
    },
    "user/login" => function () {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
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