<?php

require_once("model/BookDB.php");
require_once("ViewHelper.php");

# Controller for handling books
class BookController
{

    public static function getAll()
    {
        # Reads books from the database
        $variables = ["books" => BookDB::getAll()];
        # Renders the view and sets the $variables array into view's scope
        ViewHelper::render("view/book-list.php", $variables);
    }

    public static function get()
    {
        $variables = ["book" => BookDB::get($_GET["id"])];
        ViewHelper::render("view/book-detail.php", $variables);
    }

    public static function showAddForm(
        $variables = array(
            "author" => "",
            "title" => "",
            "price" => "",
            "year" => ""
        )) {
        ViewHelper::render("view/book-add.php", $variables);
    }

    public static function add()
    {
        $validData = isset($_POST["author"]) && !empty($_POST["author"]) &&
            isset($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["year"]) && !empty($_POST["year"]) &&
            isset($_POST["price"]) && !empty($_POST["price"]);

        if ($validData) {
            BookDB::insert($_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
            ViewHelper::redirect(BASE_URL . "book");
        } else {
            self::showAddForm($_POST);
        }
    }

    # TODO: Implement controlers for searching, editing and deleting books

    public static function showSearchForm($searchText = array(""))
    {
        ViewHelper::render("view/book-search.php", $searchText);
    }

    public static function search()
    {
        $validData = isset($_POST["name"]) && !empty($_POST["name"]);
        if ($validData) {
            $results = ["books" => BookDB::search($_POST["name"])];
            ViewHelper::render("view/book-search.php", $results);
        } else {
            self::showSearchForm($_POST);
        }
    }

    public static function showEditForm()
    {
        $validData = isset($_GET["id"]) && !empty($_GET["id"]);
        if ($validData) {
            $id = $_GET["id"];
            ViewHelper::render("view/book-edit.php", BookDB::get($id));
        } else {
            ViewHelper::error400("Bad book id");
        }
    }

    public static function edit()
    {
        $validData = $validData = isset($_POST["author"]) && !empty($_POST["author"]) &&
            isset($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["year"]) && !empty($_POST["year"]) &&
            isset($_POST["price"]) && !empty($_POST["price"]) &&
            isset($_POST["id"]) && !empty($_POST["id"]);
        if ($validData) {
            BookDB::update($_POST["id"], $_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
            ViewHelper::redirect(BASE_URL);
        } else {
            self::showEditForm();
        }
    }

    public static function delete()
    {
        $validData = isset($_GET["id"]) && !empty($_GET["id"]);
        if ($validData) {
            $id = $_GET["id"];
            BookDB::delete($id);
            ViewHelper::redirect(BASE_URL);
        } else {
            ViewHelper::error400("Bad book id");
        }
    }
}