<?php
session_start();
require_once("BookDB.php");
?>
<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="UTF-8">
<title>Library</title>

<h1>A PHP bookstore</h1>

<div id="main">
    <?php foreach (BookDB::getAll() as $book): ?>
        <div class="book">
            <form action="manage-cart.php" method="post">
                <input type="hidden" name="cart_action" value="add">
                <input type="hidden" name="id" value="<?= $book["id"] ?>">
                <p>
                    <?= $book["title"] ?>
                </p>
                <p>
                    <?= $book["author"] ?>,
                    <?= $book["year"] ?>
                </p>
                <p>
                    <?= number_format($book["price"], 2) ?> EUR<br>
                    <button>Add to cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php

$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

if (!empty($cart)): ?>
    <div class="cart">
        <h3>Shopping cart</h3>
        <?php
        $total = 0; foreach ($cart as $id => $quantity): ?>
            <form action="manage-cart.php" method="post">
                <input type="hidden" name="cart_action" value="edit">
                <input type="hidden" name="id" value="<?= $id ?>">
                <label for="number-input" style="display: flex; flex-direction: row; align-items: center">
                    <input type="number" name="number-input" style="width: 30px; height:15px" id="number-input" value="<?= $quantity ?>">
                    <p style="margin-left: 3px">x <?= BookDB::get($id)["title"]; ?></p>
                </label>
            </form>
            <?php $total += BookDB::get($id)["price"] * $quantity; ?>
        <?php endforeach; ?>
        <p>Total: <b>
                <?= $total ?> EUR
            </b></p>


        <form action="manage-cart.php" method="post">
            <input type="hidden" name="cart_action" value="purge_cart">
            <p><button>Purge cart</button></p>
        </form>
    </div>
    <?php
endif;