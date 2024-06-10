<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user"])) {
        header('location: login.php');
    }

    require_once 'helpers/DB.php';
    require_once 'functions/PaymentController.php';
    
    $Payment = new PaymentController();
    $page = "payment";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euphoria | Payment</title>

    <?php include_once('layouts/app-layouts/styleLink.html') ?>
</head>
<body>
    <div class="container" id="payment-container">
        <?php include_once('layouts/app-layouts/navbar.php') ?>

        <div class="content" id="payment">
            <div class="left-content">
                <h3>Payment Method</h3>
                <div class="card">
                    <div class="payment-option">
                        <div class="payment-title">
                            Bank Transfer
                        </div>
                        <div class="payment-info">
                            <div class="card-no">
                                <label>Bank Account</label>
                                61912823423
                            </div>
                            <div class="info__column">
                                <div class="bank-name">
                                    <label>Bank Name</label>
                                    BCA
                                </div>
                                <div class="card-name">
                                    <label>Recipient Name</label>
                                    Komang Arya
                                </div>
                            </div>
                        </div>
                        <div class="payment-notif">
                            <i class="bi bi-info-circle"></i>
                            <span>Please click "I Already Paid" if you already paid for this order</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-content">
                <h3>Summary</h3>
                <div class="card">
                    <div class="summary-detail">
                        <div class="detail__total">
                            Subtotal
                            <span class="price-bold">Rp. <?= number_format(@$Payment->transaction["subtotal"], 0, 0, ',') ?></span>
                        </div>
                        <div class="detail__tax">
                            Tax
                            <span class="price-bold">Rp. <?= number_format(@$Payment->transaction["tax"], 0, 0, ',') ?></span>
                        </div>
                        <div class="detail__shipping">
                            Shipping Fee
                            <span class="price-bold">Rp. <?= number_format(@$Payment->transaction["shipping_fee"], 0, 0, ',') ?></span>
                        </div>
                        <div class="detail__grand-total">
                            Grandtotal
                            <span class="price-bold">Rp. <?= number_format(@$Payment->transaction["grand_total"], 0, 0, ',') ?></span>
                        </div>
                    </div>
                    <div class="summary-action">
                        <form action="helpers/TransactionDomain.php" method="post">
                            <input type="hidden" name="id" value="<?= $Payment->transaction['id'] ?>">
                            <?php if(!in_array($Payment->transaction["transaction_status_id"], [3, 4])) : ?>
                            <button type="submit" name="action" value="cancel" class="cancel">Cancel Order</button>
                            <?php endif ?>
                            <?php if(!in_array($Payment->transaction["transaction_status_id"], [2, 3, 4])) : ?>
                            <button type="submit" name="action" value="waiting" class="paid">I Already Paid</button>
                            <?php endif ?>
                            <?php if(!in_array($Payment->transaction["transaction_status_id"], [1])) : ?>
                            <div class="status-order <?= $Payment->transaction["name"] ?>">
                                Status : <span><?= $Payment->transaction["name"] ?></span>
                            </div>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('layouts/app-layouts/scriptLink.html') ?>
</body>
</html>