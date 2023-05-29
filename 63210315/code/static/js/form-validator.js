"use strict";

function checkPasswordMatch() {
    let password = document.getElementById("Password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let errorDiv = document.getElementById("passwordMatchError");

    if (password !== confirmPassword) {
        errorDiv.textContent = "Passwords do not match";
    } else {
        errorDiv.textContent = "";
    }

}

function validateForm() {
    let nameInput = document.getElementById("Name");
    let surnameInput = document.getElementById("Surname");
    let emailInput = document.getElementById("Email");
    let phoneInput = document.getElementById("Phone");
    let passwordInput = document.getElementById("Password");
    let cityInput = document.getElementById("City");
    let postcodeInput = document.getElementById("Postcode");
    let streetInput = document.getElementById("Street");


    let nameErrorDiv = document.getElementById("nameError");
    let surnameErrorDiv = document.getElementById("surnameError");
    let emailErrorDiv = document.getElementById("emailError");
    let phoneErrorDiv = document.getElementById("phoneError");
    let passwordErrorDiv = document.getElementById("passwordError");
    let postcodeErrorDiv = document.getElementById("postcodeError");
    let cityErrorDiv = document.getElementById("cityError");
    let streetErrorDiv = document.getElementById("streetError");

    let namePattern = /^[A-ZŠĐČĆŽa-zšđčćž]+$/;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let phonePattern = /^(?:\+386|0)\s*(?:[1-7]\d{1}|31)\s*\d{3}\s*\d{3,4}$/;
    let passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
    let streetPattern = /^[A-ZŠĐČĆŽa-zšđčćž\s+]+\s+\d+[A-ZŠĐČĆŽa-zšđčćž]*$/;

    let isValid = true;

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
        if (!phonePattern.test(phoneInput.value) && phoneInput.value != "") {
            phoneErrorDiv.textContent = "Enter a valid Slovenian phone number (+386)";
            isValid = false;
        } else {
            phoneErrorDiv.textContent = "";
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

    try {
        if (!namePattern.test(cityInput.value) && cityInput.value != "") {
            cityErrorDiv.textContent = "Enter a valid city name";
            isValid = false;
        } else {
            cityErrorDiv.textContent = "";
        }
    } catch (error) {

    }

    try {
        if ((postcodeInput.value < 1000 || postcodeInput.value > 9265) && postcodeInput.value != "") {
            postcodeErrorDiv.textContent = "Enter a valid postcode";
            isValid = false;
        } else {
            postcodeErrorDiv.textContent = "";
        }
    } catch (error) {

    }

    try {
        if (!streetPattern.test(streetInput.value) && streetInput.value != "") {
            streetErrorDiv.textContent = "Enter a valid street";
            isValid = false;
        } else {
            streetErrorDiv.textContent = "";
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
