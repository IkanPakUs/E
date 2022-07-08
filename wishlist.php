<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once 'helpers/DB.php';
    require_once 'functions/WishlistController.php';
    $Wishlist = new WishlistController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euphoria | Wishlist</title>

    <?php include_once('layouts/app-layouts/styleLink.html') ?>
</head>
<body>
    <div class="flash-message">
        <h5 class="message"></h5>
    </div>

    <div class="wishlist-img">
        <img src="src/img/thumbnail/wishlist.jpg" alt="wishlist">
    </div>
    <div class="container">
        <?php include_once('layouts/app-layouts/navbar.php') ?>
        
        <div class="content product-grid" id="wishlist">
            <div class="main-content">
                <h3>Wishlist Item</h3>

                <?php if ($Wishlist->wishlist) : ?>
                <div class="product-list">
                    <?php foreach ($Wishlist->wishlist as $key => $product) : ?>
                    <div class="product" id="wishlist_<?= $product['product_id'] ?>">
                        <div class="img-wrapper">
                            <img src="<?= $_SESSION ["root_path"] . "src/img/product/" . $product["image_url"] ?>" alt="wishlist" loading="lazy">
                            <div class="wrapper__action">
                                <a class="wishlist">
                                    <i class="bi wish-btn bi-heart-fill fill-btn" product_id="<?= $product['product_id'] ?>"></i>
                                </a>
                                <a class="add-cart">
                                    <i class="bi cart-btn <?= $Wishlist->isInCart($product["product_id"]) ? 'bi-cart-check-fill' : 'bi-cart-plus' ?>" product_id="<?= $product['product_id'] ?>"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info">
                            <div class="title">
                                <a href="#"><?= $product["name"] ?></a>
                            </div>
                            <div class="price">
                                <h6>Rp <?= number_format($product["price"], 0, 0, ',') ?></h6>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php else : ?>
                    <div class="non-wishlist">
                        <p>
                            <h1>Hey.. Looks like you doesn't have wishlist product</h1>
                            <span>now you can save your dream product, and it will appear here forever. just click love button in product box</span>
                        </p>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php include_once('layouts/app-layouts/footer.html') ?>
    </div>

    <?php include_once('layouts/app-layouts/scriptLink.html') ?>
</body>
</html>