<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bank of Slovenia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= CSS_URL ?>landingpage.css">
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg" style="background-color: #e3f2fd;">
        <div class=" container-fluid">
            <img src="<?= IMAGES_URL ?>logo.png" alt="" width="45px" height="42px" style="margin: 0 12px 3px 0">
            <a class="navbar-brand" href="#" style="font-size: 2.3rem; font-weight: 5px;">Bank of Slovenia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto d-flex">
                    <a class="nav-link" aria-current="page" href="login" style="margin-right: 1em;">Login</a>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container background col-12">

        <div class="row align-items-start">
            <div class="container col-6 content about-us">
                <h2>Who are we?</h2>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, blanditiis! Numquam fuga blanditiis
                porro odit. Adipisci voluptas sint nemo laboriosam doloremque excepturi maxime, at aperiam est
                explicabo, deserunt commodi incidunt? Adipisci voluptas sint nemo laboriosam doloremque excepturi
                maxime, at aperiam est
                explicabo, deserunt commodi incidunt? Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Ducimus,
                consequatur. Alias quam quo laborum esse similique harum ipsum officia nobis sint ut ad voluptatum,
                unde
                ea error, repudiandae in deleniti.
            </div>
        </div>
        <div class="row align-items-start">
            <div class="container col-6 content what-can-we-do">
                <h2>What can we do for you?</h2>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ut quidem rem maiores dolore veniam
                sapiente,
                repellendus eaque? Ipsum, alias rerum eos corporis, numquam accusamus quisquam non, dolore error
                voluptatibus sunt. Lorem ipsum dolor sit amet consectetur adipisicing elit. Id consectetur facere
                harum
                hic illum maxime,
                optio necessitatibus pariatur expedita in facilis, perspiciatis, voluptate magni est veritatis sint
                quisquam nostrum suscipit.
                <br>
                <br>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero qui rem porro. Earum non, modi
                dignissimos enim dolorum natus iure ex exercitationem voluptas suscipit, qui quaerat temporibus.
                Distinctio, quidem placeat?
            </div>
        </div>
        <div class="row align-items-start">
            <div class="container col-3 content card">
                <h3>Banking</h3>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Libero qui rem porro.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere earum distinctio!
                <img class="mx-auto" src="<?= IMAGES_URL ?>bank.png" alt="" style="width: 100px; margin-top: 4px;">
            </div>
            <div class="container col-3 content card">
                <h3>Loans</h3>
                Sorem ipsum, dolor sit amet consectetur adipisicing elit. Libero qui rem porro.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere earum distinctio!
                <img class="mx-auto" src="<?= IMAGES_URL ?>personal.png" alt="" style="width: 100px; margin-top: 4px;">
            </div>
            <div class="container col-3 content card">
                <h3>Mortgages</h3>
                Porem ipsum, dolor sit amet consectetur adipisicing elit. Libero qui rem porro.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere earum distinctio!
                <img class="mx-auto" src="<?= IMAGES_URL ?>mortgage-loan.png" alt=""
                    style="width: 100px; margin-top: 4px;">
            </div>
        </div>

    </div>


    <footer class="text-center bg-light text-muted">
        <section>
            <div class="container text-center text-md-start mt-5"
                style="padding-top: 1.7em; margin-top: 0px !important;">
                <div class="row mt-3" style="margin-top: 0px !important;">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Bank of Slovenia
                        </h6>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Labore odio minus deserunt laudantium. Qui praesentium, accusantium assumenda tenetur ratione.
                        </p>
                    </div>

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Products
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Banking</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Loans</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Accounts</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Mortgages</a>
                        </p>
                    </div>

                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Useful links
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Pricing</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Settings</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Locations</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Help</a>
                        </p>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> Ljubljana, Slovenia</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            bank.of@slovenia.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="#!">BankOfSlovenia.com</a>
        </div>
    </footer>
</body>

</html>