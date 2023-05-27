"use strict";

function checkPasswordMatch() {
    var password = document.getElementById("Password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var errorDiv = document.getElementById("passwordMatchError");

    if (password !== confirmPassword) {
        errorDiv.textContent = "Passwords do not match";
    } else {
        errorDiv.textContent = "";
    }

}

function validateForm() {
    var nameInput = document.getElementById("Name");
    var surnameInput = document.getElementById("Surname");
    var emailInput = document.getElementById("Email");
    var passwordInput = document.getElementById("Password");
    var nameErrorDiv = document.getElementById("nameError");
    var surnameErrorDiv = document.getElementById("surnameError");
    var emailErrorDiv = document.getElementById("emailError");
    var passwordErrorDiv = document.getElementById("passwordError");

    var namePattern = /^[A-ZŠĐČĆŽa-zšđčćž]+$/;
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

    var isValid = true;

    try {
        if (!namePattern.test(nameInput.value) && nameInput.value != "") {
            nameErrorDiv.textContent = "Name must be made up from the Slovenian alphabet";
            isValid = false;
        } else {
            nameErrorDiv.textContent = "";
        }
    } catch (error) {

    }

    try {
        if (!namePattern.test(surnameInput.value) && surnameInput.value != "") {
            surnameErrorDiv.textContent = "Surname must be made up from the Slovenian alphabet";
            isValid = false;
        } else {
            surnameErrorDiv.textContent = "";
        }
    } catch (error) {

    }

    try {
        if (!emailPattern.test(emailInput.value) && emailInput.value != "") {
            emailErrorDiv.textContent = "Enter a valid email address";
            isValid = false;
        } else {
            emailErrorDiv.textContent = "";
        }
    } catch (error) {

    }

    try {
        if (!passwordPattern.test(passwordInput.value) && passwordInput.value != "") {
            passwordErrorDiv.textContent = "Password must be at least 8 characters long, contain at least one uppercase letter, one digit, and one special character";
            isValid = false;
        } else {
            passwordErrorDiv.textContent = "";
        }
    } catch (error) {

    }

    return isValid;
}

window.addEventListener("load", () => {
    let form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        checkPasswordMatch();
        if (!validateForm()) {
            event.preventDefault();
        }
    });
});
