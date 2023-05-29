<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="<?= JS_URL ?>form-validator.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="<?= CSS_URL ?>homepage.css">
</head>

<body>
    <div>
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <h2 href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none"
                        style="margin-top: 1em !important;">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </h2>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="dashboard" class="nav-link align-middle px-0">
                                <img src="<?= IMAGES_URL ?>dashboard.png" alt=""><span
                                    class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="transactions" class="nav-link px-0 align-middle">
                                <img src="<?= IMAGES_URL ?>transactions.png" alt=""> <span
                                    class="ms-1 d-none d-sm-inline">Transactions</span>
                            </a>
                        </li>
                        <li>
                            <a href="my-profile" class="nav-link px-0 align-middle ">
                                <img src="<?= IMAGES_URL ?>user.png" alt="" style="height: 30px !important;"> <span
                                    class="ms-1 d-none d-sm-inline">My Profile</span>
                            </a>
                        </li>
                    </ul>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-sm-inline mx-1">
                                <?= $data["name"] . " " . $data["surname"] ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="<?= BASE_URL?>home/signout">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <?php
                if (strcmp($data["subpage"], "dashboard") == 0) {
                    include("view/dashboard.php");
                } else if (strcmp($data["subpage"], "transactions") == 0) {
                    include("view/transactions.php");
                } else if (strcmp($data["subpage"], "my-profile") == 0) {
                    include("view/my-profile.php");
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>