<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>

    <!-- JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="<?= JS_URL ?>form-validator.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="<?= CSS_URL ?>loginpage.css">
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="d-flex justify-content-center align-items-center col-md-9 col-lg-6 col-xl-5"
                    style="flex-direction: column;">
                    <img src="<?= IMAGES_URL ?>logo.png" style="width:200px;" class="img-fluid" alt="Sample image">
                    <h2>Bank of Slovenia</h2>
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="<?= BASE_URL ?>user/login" method="post">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Welcome</p>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="email" id="Email" name="email" value="<?= $data["email"] ?>"
                                class="form-control form-control-lg" placeholder="Enter a valid email address"
                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" oninput="validateForm()"
                                required />
                            <div id="emailError" class="error-message">
                                <?= $errors["email"] ?>
                            </div>
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" id="Password" name="password" class="form-control form-control-lg"
                                placeholder="Enter password" />
                            <div id="emailError" class="error-message">
                                <?= $errors["password"] ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" id="Remember"
                                    name="remember" />
                                <label class="form-check-label" for="Remember">
                                    Remember me
                                </label>
                            </div>
                            <a href="#!" class="text-body">Forgot password?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="signup"
                                    class="link">Register</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <div class="text-white mb-3 mb-md-0">
                Copyright © Bank of Slovenia 2023. All rights reserved.
            </div>

        </div>
    </section>
</body>

</html>