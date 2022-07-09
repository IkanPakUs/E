<?php 
	include_once('validate.php');
	require_once('../helpers/DB.php');
    require_once('../functions/OverviewController.php');
	$Overview = new OverviewController();

	$dashboard_active = "active";
    $page_title = "Overview";
	$menu = ["Home" => "overview.php"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | Dashboard</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main id="dashboard">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3><?= $Overview->overview["ov_order"] ?></h3>
						<p>New Order</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3><?= $Overview->overview["ov_visitor"] ?></h3>
						<p>Users</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>Rp. <?= number_format(ceil($Overview->overview["ov_sales"]), 0, 0, ',') ?></h3>
						<p>Total Sales</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-shopping-bag' ></i>
					<span class="text">
						<h3><?= $Overview->overview["ov_product"] ?></h3>
						<p>Sold Product</p>
					</span>
				</li>
			</ul>

			<div id="table-content">
				<div class="card">
					<div class="card-body">
						<h3 class="box-title">Recent Transaction </h3>
					</div>
					<div class="card-body--">
						<div class="table-wrap">
							<table class="table ">
								<thead>
									<tr>
										<th class="serial">#</th>
										<th>Code</th>
										<th>Name</th>
										<th>Grand Total</th>
										<th>Status</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($Overview->transactions) : ?>
									<?php foreach ($Overview->transactions as $key => $transaction) : ?>
									<tr>
										<td class="serial"><?= ++$key ?></td>
										<td><span class="name"><?= $transaction['code'] ?></span></td>
										<td><span class="count"><?= @$transaction['user_name'] ?? "Deleted User" ?></span></td>
										<td><span class="transaction"><?= number_format($transaction['grand_total'], 0, 0, ',') ?></span></td>
										<td><span class="count <?= $transaction['status_name'] ?>"><?= $transaction['status_name'] ?></span></td>
										<td>
											<a href="detail-transaction.php?id=<?= $transaction['id'] ?>">Show</a>
										</td>
									</tr>
									<?php endforeach ?>
									<?php endif ?>
								</tbody>
							</table>
						</div> 
					</div>
				</div> 

				<div class="card card-sm">
					<div class="card-body">
						<h3 class="box-title">Loyal Member </h3>
					</div>
					<div class="card-body--">
						<div class="table-wrap">
							<table class="table ">
								<thead>
									<tr>
										<th class="serial">#</th>
										<th>Name</th>
										<th>Total Spend</th>
										<th>Member since</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($Overview->members) : ?>
									<?php foreach ($Overview->members as $key => $member) : ?>
									<tr>
										<td class="serial"><?= ++$key ?></td>
										<td><span class="name"><?= $member["name"] ?></span> </td>
										<td><span class="product">Rp. <?= number_format($member["spend"], 0, 0, ',') ?></span> </td>
										<td><span class="count"><?= date_format(date_create($member["created_at"]), "Y-m-d") ?></span></td>
									</tr>
									<?php endforeach ?>
									<?php endif ?>
								</tbody>
							</table>
						</div> 
					</div>
				</div>
			</div>
		</main>
	</section>

	<?php include_once('../layouts/admin-layouts/scriptLink.html') ?>

</body>
</html>