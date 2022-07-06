<?php 
	include_once('validate.php');
	require_once('../helpers/DB.php');
    require_once('../functions/OverviewController.php');

	$analytic_active = "active";
    $page_title = "Analytic";
	$menu = ["Analytic" => "analytic.php"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | Analytic</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main id="analytic">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

			<div class="top-content">
                <div class="card-wrap">
                    <div class="card">
                        <div class="card__left-content">
                            <div class="title">
                                Order
                            </div>
                            <div class="value">
                                <?= number_format($Overview->overview["ov_order"], 0, '.') ?>
                            </div>
                            <div class="stats">
                                <span class="<?= $Overview->ls_overview["ls_order"]["gain"] ? "up" : "down" ?>"><?= $Overview->ls_overview["ls_order"]["value"] ?>%</span> Since last month
                            </div>
                        </div>
                        <div class="card__right-content">
                            <i class='bx bxs-calendar-check' ></i>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__left-content">
                            <div class="title">
                                Users
                            </div>
                            <div class="value">
                                <?= number_format($Overview->overview["ov_visitor"], 0, '.') ?>
                            </div>
                            <div class="stats">
                                <span class="<?= $Overview->ls_overview["ls_visitor"]["gain"] ? "up" : "down" ?>"><?= $Overview->ls_overview["ls_visitor"]["value"] ?>%</span> Since last month
                            </div>
                        </div>
                        <div class="card__right-content">
                            <i class='bx bxs-group' ></i>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__left-content">
                            <div class="title">
                                Sales
                            </div>
                            <div class="value">
                                Rp. <?= number_format(ceil($Overview->overview["ov_sales"]), 0, ',') ?>
                            </div>
                            <div class="stats">
                                <span class="<?= $Overview->ls_overview["ls_sales"]["gain"] ? "up" : "down" ?>"><?= $Overview->ls_overview["ls_sales"]["value"] ?>%</span> Since last month
                            </div>
                        </div>
                        <div class="card__right-content">
                            <i class='bx bxs-dollar-circle' ></i>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__left-content">
                            <div class="title">
                                Sold
                            </div>
                            <div class="value">
                                <?= number_format($Overview->overview["ov_product"], 0, '.') ?>
                            </div>
                            <div class="stats">
                                <span class="<?= $Overview->ls_overview["ls_product"]["gain"] ? "up" : "down" ?>"><?= $Overview->ls_overview["ls_product"]["value"] ?>%</span> Since last month
                            </div>
                        </div>
                        <div class="card__right-content">
                            <i class='bx bxs-shopping-bag' ></i>
                        </div>
                    </div>
                </div>

                <div class="user-grow-wrap">
                    <canvas id="user-growth"></canvas>
                </div>
            </div>

            <div class="bottom-content">
                <div class="bottom__left-content">
                    <canvas id="order-chart"></canvas>
                </div>
                <div class="bottom__right-content">
                    <div id="geo-chart"></div>
                </div>
            </div>
		</main>
	</section>

    <?php include_once('../layouts/admin-layouts/scriptLink.html') ?>

</body>
</html>