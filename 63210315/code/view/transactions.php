<?php
require_once("model/UserDB.php");
?>

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

        <form action="<?= BASE_URL ?>home/transactions/transfer" method="post"
            class="d-flex flex-column w-50 align-items-center">
            <div class="form-outline mb-4 d-flex flex-column">
                <input type="number" min="1" name="transfer" class="form-control form-control-lg" placeholder="Amount"
                    pattern="[0-9]+" />
                <input type="number" name="recevier_id" class="form-control form-control-lg" placeholder="Recevier Id"
                    pattern="[0-9]+" />
            </div>
            <button type="submit" name="top-up" class="btn btn-primary btn-lg">Send</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Receiver ID</th>
                    <th>Sender ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $transactions = UserDB::getAccountTransactions($data["id"]);
                foreach ($transactions as $tran): ?>
                    <tr>
                        <td>
                            <?php echo $tran['id']; ?>
                        </td>
                        <td>
                            <?php echo $tran['receiver_id']; ?>
                        </td>
                        <td>
                            <?php echo $tran['sender_id']; ?>
                        </td>
                        <td>
                            <?php echo $tran['amount'] . "&euro;"; ?>
                        </td>
                        <td>
                            <?php echo $tran['date']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>