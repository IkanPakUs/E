<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once('helpers/DB.php');

    $_SESSION["root_path"] =  "http://" . $_SERVER['HTTP_HOST'] . "/" . basename(dirname(__FILE__)) . "/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euphoria</title>

    <?php include_once('layouts/app-layouts/styleLink.html') ?>
<body>
    <div class="container">
        <div class="nav-wrap">
            <?php include_once('layouts/app-layouts/navbar.php') ?>
        </div>

        <div id="home" class="content">
            <div class="thumbnail-content">
                <div class="bg-thumbnail__up-img">
                    <div class="text">
                        <h4>a retro look</h4>
                        <h1>COMFY SOFAS</h1>
                        <a href="catalog.php">Shop Now</a>
                    </div>
                    <img src="src/img/thumbnail/big-chair.jpg" alt="sofa">
                </div>
                <div class="bg-thumbnail__mid-img">
                    <div class="mid-img__left-side">
                        <div class="text">
                            <a href="catalog.php?filter[category]=1">Chair</a>
                        </div>
                        <img src="src/img/thumbnail/chair.jpg" alt="Chair">
                    </div>
                    <div class="mid-img__right-side">
                        <div class="right-side__up-side">
                            <div class="up-side__left-img">
                                <div class="text">
                                    <a href="catalog.php?filter[category]=3">Table</a>
                                </div>
                                <img src="src/img/thumbnail/table.jpg" alt="table">
                            </div>
                            <div class="up-side__right-img">
                                <div class="text">
                                    <a href="catalog.php?filter[category]=2">Lamp</a>
                                </div>
                                <img src="src/img/thumbnail/lamp.jpg" alt="lamp">
                            </div>
                        </div>
                        <div class="right-side__bot-side">
                            <div class="text">
                                <a href="catalog.php?filter[category]=4">Sofa</a>
                            </div>
                            <img src="src/img/thumbnail/Sofas.jpg" alt="sofa">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('layouts/app-layouts/footer.html') ?>
    </div>

    <?php include_once('layouts/app-layouts/scriptLink.html') ?>
</body>
</html>