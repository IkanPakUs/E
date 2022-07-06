<?php 
    require_once 'functions/CartController.php';
?>
<div class="nav">
    <div class="left-content">
        <?php if(@$page != "payment") : ?>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="catalog.php">Shop</a></li>
            <li><a href="service.php">Service</a></li>
        </ul>
        <?php endif ?>
    </div>
    <div class="middle-content">
        <a href="index.php">EUPHORIA</a>
    </div>
    <div class="right-content">
        <?php if(@$page != "payment") : ?>
        <div class="icon search-form">
            <div class="form-group">
                <i class="bi bi-search search-icon"></i> 
                <input type="text" class="search">
            </div>
        </div>
        <?php if (isset($Cart->user)) : ?>
        <div class="icon">
            <a href="wishlist.php">
                <i class="bi bi-heart hover-text" data-hover="Wishlisst"></i>
            </a>
        </div>
        <?php if($Cart->role == 1) : ?>
            <div class="icon">
                <a href="admin/overview.php">
                    <i class="bi bi-journals hover-text" data-hover="Admin dashboard"></i>
                </a>
            </div>
        <?php endif ?>
        <div class="icon">
            <i class="bi bi-bag hover-text cart-icon" data-hover="Cart" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if(isset($Cart->cart_list) && $Cart->cart_list) : ?>
                <span></span>
                <?php endif ?>
            </i>
            <ul class="dropdown-menu">
                <li>
                    <div class="cart-hover">
                        <div class="select-items">
                            <?php if (isset($Cart->cart_list) && $Cart->cart_list) : ?>
                            <?php foreach ($Cart->cart_list as $key => $cart) : ?>
                            <div class="cart">
                                <div class="cart__left-side">
                                    <img src="<?= $_SESSION["root_path"] . 'src/img/product/' . $cart["image_url"] ?>" alt="">
                                </div>
                                <div class="cart__right-side">
                                    <div class="right-side__price">
                                        <h6>Rp. <?= number_format($cart["price"], 0, ',') ?> x <?= $cart["quantity"] ?></h6>
                                        <h5><?= $cart["name"] ?></h5>
                                    </div>
                                    <div class="right_side__cart-remove">
                                        <a class="btn-close remove-cart" product_id="<?= $cart["product_id"] ?>"></a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <div class="checkout-btn">
                            <a href="shopping-cart.php">
                                Checkout
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <?php endif ?>
        <div class="icon dd-user hover-text" data-hover="Account">
            <?php if(isset($Cart->user)) : ?>
            <i class="bi bi-person" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu">
                <li><label>Role :
                        <?= $Cart->role == 1 ? "admin" : "member" ?>
                    </label></li>
                <hr>
                <li><a href="functions/logout.php">Log out</a></li>
            </ul>
            <?php else : ?>
            <a href="login.php"><i class="bi bi-person"></i></a>
            <?php endif ?>
        </div>
        <?php endif ?>
    </div>
</div>