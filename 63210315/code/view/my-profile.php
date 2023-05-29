
<div class="w-auto d-flex align-items-center justify-content-center" style="margin-top: 10% !important;">

    <form action="<?= BASE_URL ?>home/my-profile/update-profile" method="post">
        <div class="d-flex flex-row align-items-center justify-content-center">
            <img src="<?= IMAGES_URL ?>user.png" alt=""
                style="height: 6rem; margin-left: 7rem !important; margin-right: 7rem !important; margin-bottom: 2rem !important;">
        </div>

        <div class="form-outline mb-4 d-flex flex-column">
            <input type="text" id="Name" name="name" value="<?= $data["name"] ?>" class="form-control form-control-lg"
                placeholder="Name" pattern="[A-ZŠĐČĆŽa-zšđčćž]+" oninput="validateForm()" required />
            <div id="nameError" class="error-message">
                <?= $errors["name"] ?>
            </div>
        </div>

        <div class="form-outline mb-4 d-flex flex-column">
            <input type="text" id="Surname" name="surname" value="<?= $data["surname"] ?>"
                class="form-control form-control-lg" placeholder="Surname" pattern="[A-ZŠĐČĆŽa-zšđčćž]+"
                oninput="validateForm()" required />
            <div id="surnameError" class="error-message">
                <?= $errors["surname"] ?>
            </div>
        </div>

        <div class="form-outline mb-4 d-flex flex-column">
            <input type="text" id="Phone" name="phone" value="<?= $data["phone_number"] ?>"
                class="form-control form-control-lg" placeholder="Phone number" oninput="validateForm()"
                pattern="^(?:\+386|0)\s*(?:[1-7]\d{1}|31)\s*\d{3}\s*\d{3,4}$" required />
            <div id="phoneError" class="error-message">
                <?= $errors["phone"] ?>
            </div>
        </div>

        <div class="form-outline mb-4 d-flex flex-column">
            <input type="email" id="Email" name="email" value="<?= $data["email"] ?>"
                class="form-control form-control-lg" placeholder="Enter a valid email address"
                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" oninput="validateForm()" required />
            <div id="emailError" class="error-message">
                <?= $errors["email"] ?>
            </div>
        </div>


        <div class="d-flex flex-row justify-content-between">
            <div class="form-outline mb-4 d-flex flex-column" style="width: 48%;">
                <input type="text" id="City" name="city" value="<?= $data["address_city"] ?>"
                    class="form-control form-control-lg" placeholder="City" pattern="[A-ZŠĐČĆŽa-zšđčćž]+"
                    oninput="validateForm()" required />
                <div id="cityError" style="width: 100%;" class="error-message">
                    <?= $errors["city"] ?>
                </div>
            </div>

            <div class="form-outline mb-4 d-flex flex-column" style="width: 48%;">
                <input type="number" min="1000" max="9265" id="Postcode" name="postcode" value="<?= $data["address_postcode"] ?>"
                    class="form-control form-control-lg" placeholder="Postcode" pattern="[0-9]+"
                    oninput="validateForm()" required />
                <div id="postcodeError" style="width: 100%;" class="error-message">
                    <?= $errors["postcode"] ?>
                </div>
            </div>
        </div>

        <div class="form-outline mb-4 d-flex flex-column">
            <input type="text" id="Street" name="street" value="<?= $data["address_street"] ?>"
                class="form-control form-control-lg" placeholder="Street" pattern="^[A-ZŠĐČĆŽa-zšđčćž\s+]+\s+\d+[A-ZŠĐČĆŽa-zšđčćž]*$" oninput="validateForm()"
                required />
            <div id="streetError" style="width: 100%;" class="error-message">
                <?= $errors["street"] ?>
            </div>
        </div>

        <div class="text-center align-items-center">
            <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Update</button>
        </div>

    </form>
</div>