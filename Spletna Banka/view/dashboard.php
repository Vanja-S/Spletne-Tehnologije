<div>
    <div class="d-flex" style="flex-direction: column;">
        <?php
        if (!isset($data["balance"])) {
            echo "<div class=\"alert alert-danger\" style=\"width: 70% !important\">
            <strong>Attention!</strong> You need to provide us with other information about you before you can use this account.
          </div>";
            exit;
        }
        ?>
        <div class="d-flex flex-column align-items-center" style="margin-top: 20%;">
            <h1>Balance</h1>
            <h3><b>
                    <?= $data["balance"] ?>&euro;
                </b></h3>
            <form action="<?= BASE_URL ?>home/my-profile/update-balance" method="post" class="d-flex flex-column">
                <div class="form-outline mb-4 d-flex flex-column">
                    <input type="number" min="1" name="top-up-input" class="form-control form-control-lg"
                        placeholder="Top-up" pattern="[0-9]+" />
                </div>
                <button type="submit" name="top-up" class="btn btn-primary btn-lg">Top up</button>
            </form>
        </div>


    </div>
</div>