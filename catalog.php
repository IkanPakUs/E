<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once 'helpers/DB.php';
    require_once 'functions/CatalogController.php';

    $Catalog = new CatalogController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euphoria | Catalog</title>

    <?php include_once('layouts/app-layouts/styleLink.html') ?>
</head>
<body>
    <div class="flash-message">
        <h5 class="message"></h5>
    </div>

    <div class="catalog-img">
        <img src="src/img/thumbnail/catalog.jpg" alt="catalog">
    </div>
    <div class="container">
        <?php include_once('layouts/app-layouts/navbar.php') ?>
        
        <div class="content product-grid" id="catalog">
            <div class="left-content">
                <div class="title">
                    <h5>Product categories</h5>
                </div>
                <ul>
                    <li><a category="" class="category-list <?= isset($_GET["filter"]["category"]) ? "" : "active" ?>">All</a></li>
                    <?php foreach ($Catalog->categories as $key => $category) : ?>
                    <li><a category="<?= $category['id'] ?>" class="category-list <?= @$_GET["filter"]["category"] == $category["id"] ? "active" : "" ?>"><?= $category["name"] ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="main-content">
                <?php if ($Catalog->catalog) : ?>
                <div class="query-info">
                    Showing <?= $Catalog->catalog_count ?> of <?= $Catalog->catalog_count ?> results
                </div>
                <div class="product-list">
                    <?php foreach ($Catalog->catalog as $key => $product) : ?>
                    <div class="product">
                        <div class="img-wrapper">
                            <img src="<?= $_SESSION ["root_path"] . "src/img/product/" . $product["image_url"] ?>" alt="catalog" loading="lazy">
                            <div class="wrapper__action">
                                <a class="wishlist">
                                    <i class="bi wish-btn <?= $Catalog->isWishlist($product["id"]) ? 'bi-heart-fill fill-btn' : 'bi-heart love-btn' ?>" product_id="<?= $product['id'] ?>"></i>
                                </a>
                                <a class="add-cart">
                                    <i class="bi cart-btn <?= $Catalog->isInCart($product["id"]) ? 'bi-cart-check-fill' : 'bi-cart-plus' ?>" product_id="<?= $product['id'] ?>"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info">
                            <div class="title">
                                <a href="#"><?= $product["name"] ?></a>
                            </div>
                            <div class="price">
                                <h6>Rp <?= number_format($product["price"], 0, ',') ?></h6>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php else : ?>
                    <div class="query-info">
                        Showing 0 of 0 results
                    </div>
                    <div class="non-product">
                        <h1>Sorry, the product you search not available yet</h1>
                        <span>Maybe you can find another similiar product with filter by category in left section</span>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php include_once('layouts/app-layouts/footer.html') ?>
    </div>

    <?php include_once('layouts/app-layouts/scriptLink.html') ?>
</body>
</html>