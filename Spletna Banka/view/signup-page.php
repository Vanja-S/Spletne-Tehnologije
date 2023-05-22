<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= CSS_URL ?>signuppage.css">
</head>

<body>
    <section>
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <form>
                        <div class="d-flex flex-row align-items-center justify-content-center">
                            <center>
                                <p class="lead fw-normal mb-0 me-3">Ready for a <br> new banking experience?</p>
                            </center>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="Name" class="form-control form-control-lg" placeholder="Name"
                                pattern="[A-ZŠĐČĆŽa-zšđčćž]+" required />
                            <div id="nameError" class="error-message"></div>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="Surname" class="form-control form-control-lg" placeholder="Surname"
                                pattern="[A-ZŠĐČĆŽa-zšđčćž]+" required />
                            <div id="nameError" class="error-message"></div>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="email" id="Email" class="form-control form-control-lg"
                                placeholder="Enter a valid email address"
                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required />
                            <div id="emailError" class="error-message"></div>
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" id="password" class="form-control form-control-lg"
                                placeholder="Make up a password"
                                pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" required />
                            <div id="passwordError" class="error-message"></div>
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" id="confirmPassword" class="form-control form-control-lg"
                                placeholder="Confirm the password again" oninput="checkPasswordMatch()" required />
                            <div id="passwordMatchError" style="color: red;"></div>
                        </div>

                        <script>
                            function checkPasswordMatch() {
                                var password = document.getElementById("password").value;
                                var confirmPassword = document.getElementById("confirmPassword").value;
                                var errorDiv = document.getElementById("passwordMatchError");

                                if (password !== confirmPassword) {
                                    errorDiv.textContent = "Passwords do not match";
                                } else {
                                    errorDiv.textContent = "";
                                }

                            }

                            function validateForm() {
                                var nameInput = document.getElementById("name");
                                var emailInput = document.getElementById("email");
                                var passwordInput = document.getElementById("password");
                                var nameErrorDiv = document.getElementById("nameError");
                                var emailErrorDiv = document.getElementById("emailError");
                                var passwordErrorDiv = document.getElementById("passwordError");

                                var namePattern = /^[A-ZŠĐČĆŽa-zšđčćž]+$/;
                                var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                                var passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

                                var isValid = true;

                                if (!namePattern.test(nameInput.value)) {
                                    nameErrorDiv.textContent = "Name or surname must be made up from the Slovenian alphabet";
                                    isValid = false;
                                } else {
                                    nameErrorDiv.textContent = "";
                                }

                                if (!emailPattern.test(emailInput.value)) {
                                    emailErrorDiv.textContent = "Enter a valid email address";
                                    isValid = false;
                                } else {
                                    emailErrorDiv.textContent = "";
                                }

                                if (!passwordPattern.test(passwordInput.value)) {
                                    passwordErrorDiv.textContent = "Password must be at least 8 characters long, contain at least one uppercase letter, one digit, and one special character";
                                    isValid = false;
                                } else {
                                    passwordErrorDiv.textContent = "";
                                }

                                return isValid;
                            }

                            var form = document.querySelector("form");
                            form.addEventListener("submit", function (event) {
                                checkPasswordMatch();
                                if (!validateForm()) {
                                    event.preventDefault();
                                }
                            });
                        </script>

                        <div class="text-center align-items-center ">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>


    <footer class="text-md-start  py-4 px-4 px-xl-5 bg-primary">
        <div class="text-white mb-md-0">
            Copyright © Bank of Slovenia 2023. All rights reserved.
        </div>
    </footer>
</body>

</html>