<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user"])) {
        header('location: login.php');
    }

    require_once 'helpers/DB.php';
    require_once 'functions/CartController.php';

    $Cart = new CartController();
    $Cart->getAddressDetail();
    $Cart->getAddressList();
    $Cart->getTransactionSummary();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euphoria | Checkout</title>

    <?php include_once('layouts/app-layouts/styleLink.html') ?>
</head>
<body>
    <div class="flash-message">
        <h5 class="message"></h5>
    </div>

    <div class="cart-img">
        <img src="src/img/thumbnail/cart.jpg" alt="catalog">
    </div>
    <div class="container">
        <?php include_once('layouts/app-layouts/navbar.php') ?>
        
        <h2 id="checkout-title">Checkout</h2>

        <form action="helpers/CheckoutDomain.php" method="post" id="cart-form">  
            <input id="address_input" type="hidden" name="address" value="<?= @$Cart->address['id'] ?? '' ?>">

            <div class="content" id="shopping-cart">
                <div class="content__left">
                    <h5>Destination</h5>
                    <div class="information-list">
                        <?php if (isset($Cart->address)) : ?>
                        <div class="info">
                            <div class="name-guest">
                                <span><?= $Cart->address["recipient"] ?></span> (<?= $Cart->address["title_address"] ?>)
                            </div>
                            <div class="address">
                                <p><?= implode(", ", [$Cart->address["address"], $Cart->address['city'], $Cart->address['postal_code']]) ?></p>
                            </div>
                            <div class="phone-no">
                                Contact - <?= $Cart->address["phone_no"] ?>
                            </div>
                        </div>
                        <?php endif ?>
                        <div class="action-btn">
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#address-modal">
                                Setting address
                            </button>

                            <div class="modal fade" id="address-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Address Setting</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="address-list-add">
                                                <button type="button" class="btn add-address">Add New Address</button>
                                            </div>
                                            <div class="address-list">
                                                <?php if (@$Cart->address_list) : ?>
                                                <?php foreach ($Cart->address_list as $address) : ?>
                                                <div class="address-card">
                                                    <div class="address__info">
                                                        <div class="name-guest">
                                                            <span><?= $address["recipient"] ?></span> (<?= $address["title_address"] ?>)
                                                        </div>
                                                        <div class="phone-no">
                                                            <?= $address["phone_no"] ?>
                                                        </div>
                                                        <div class="address">
                                                            <p><?= implode(", ", [$address["address"], $address['city'], $address['postal_code']]) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="address__action">
                                                        <a href="#" class="edit-address" address_id="<?= $address["id"] ?>">Edit address</a>
                                                        <?php if (!$address["is_main"]) : ?>
                                                        <span></span>
                                                        <a href="#" class="select-address" address_id="<?= $address["id"] ?>">Select this address</a>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <?php endforeach ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="list-cart">
                        <?php if($Cart->cart_list) : ?>
                        <div class="header">
                            <h5 class="cart__product">Products</h5>
                            <h5 class="cart__quantity">Quantity</h5>
                            <h5 class="cart__subtotal">Subtotal</h5>
                        </div>
                        <?php foreach ($Cart->cart_list as $cart) : ?>
                        <div class="body card-cart" product_id="<?= $cart["product_id"] ?>">
                            <input type="hidden" class="input-product" id="product_input_<?= $cart['product_id'] ?>" name="product_cart[<?= $cart['product_id'] ?>][quantity]" value="<?= $cart['quantity'] ?>"> 
                            
                            <div class="cart__product cart__product-info">
                                <div class="product__img-wrap">
                                    <img src="<?= $_SESSION ["root_path"] . "src/img/product/" . $cart["image_url"] ?>">
                                </div>
                                <div class="product__right-side">
                                    <div class="title"><?= $cart["name"] ?></div>
                                    <div class="right__action-btn">
                                        <a href="#" class="wish-link wishlist">
                                            <i class="bi wish-btn <?= $Cart->isWishlist($cart["product_id"]) ? 'bi-heart-fill fill-btn' : 'bi-heart love-btn' ?>" product_id="<?= $cart["product_id"] ?>"></i>
                                        </a>
                                        <span></span>
                                        <div class="remove-btn">
                                            <i class="bi bi-trash3 remove-cart" product_id="<?= $cart["product_id"] ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart__quantity">
                                <div class="total-btn">
                                    <div class="down-btn">
                                        <i class="bi bi-dash-circle min-btn" product_id="<?= $cart["product_id"] ?>"></i>
                                    </div>
                                    <span id="quantity_<?= $cart["product_id"] ?>" product_id="<?= $cart["product_id"] ?>"><?= $cart["quantity"] ?></span>
                                    <div class="up-btn">
                                        <i class="bi bi-plus-circle max-btn" product_id="<?= $cart["product_id"] ?>"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="cart__subtotal">
                                <div class="price" id="price_<?= $cart["product_id"] ?>" price="<?= $cart["price"] ?>">Rp. <?= number_format($cart["subtotal"], 0, ',') ?></div>
                            </div>
                        </div>
                        <?php endforeach ?>
                        <?php else : ?>
                            <div class="non-checkout">
                                <h1>C'mon get the product you like, and came back here later</h1>
                                <span>You can click cart button in product box</span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="content__right">
                    <div class="right__card">
                        <div class="title">
                            Transaction Summary
                        </div>
                        <div class="price-detail">
                            <div class="detail__title">
                                Price Details
                            </div>
                            <div class="detail__total">
                                Subtotal
                                <span class="price-bold">Rp. <?= number_format($Cart->summary["subtotal"], 0, ',') ?></span>
                            </div>
                            <div class="detail__tax">
                                Tax
                                <span class="price-bold">Rp. <?= number_format($Cart->summary["tax"], 0, ',') ?></span>
                            </div>
                            <div class="detail__shipping">
                                Shipping Fee
                                <span class="price-bold">Rp. <?= number_format($Cart->summary["shipping"], 0, ',') ?></span>
                            </div>

                            <div class="detail__grand-total">
                                Rp. <?= number_format($Cart->summary["grand_total"], 0, ',') ?>
                            </div>
                        </div>
                        <div class="checkout-btn">
                            <button class="btn proceed-btn" type="submit" <?= $Cart->cart_list && isset($Cart->address) ? "" : "disabled" ?>>Proceed Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <?php include_once('layouts/app-layouts/footer.html') ?>
    </div>

    <?php include_once('layouts/app-layouts/scriptLink.html') ?>
</body>
</html>