<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/TransactionController.php');
	$Transaction = new TransactionController;
	$Transaction->show();

	$transaction_active = "active";
    $page_title = "Transaction";
	$menu = ["Transaction" => "transaction.php", "Detail" => "detail-transaction.php"];
    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | Transaction Detail</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main id="transaction_detail">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

            <div id="table-content">
				<div class="card">
					<div class="card-body">
						<h3 class="box-title">Transaction</h3>
					</div>
					<div class="card-body">
						<div class="transaction-info">
							<div class="table-wrap">
								<table class="table">
									<tbody>
										<tr>
											<td>Code</td>
											<td>: <?= $Transaction->transactions["code"] ?></td>
										</tr>
										<tr>
											<td>Transaction Created</td>
											<td>: <?= $Transaction->transactions["created_at"] ?></td>
										</tr>
										<tr>
											<td>Transaction Updated</td>
											<td>: <?= $Transaction->transactions["updated_at"] ?></td>
										</tr>
										<tr>
											<td>User</td>
											<td>: <?= $Transaction->transactions["user"]["name"] ?></td>
										</tr>
										<tr>
											<td>User Email</td>
											<td>: <?= $Transaction->transactions["user"]["email"] ?></td>
										</tr>
										<tr>
											<td>Contact</td>
											<td>: <?= $Transaction->transactions["address"]["phone_no"] ?></td>
										</tr>
										<tr>
											<td>Status</td>
											<td>: <?= $Transaction->transactions["name"] ?></td>
										</tr>
										<tr>
											<td>Address</td>
											<td>: <?= implode(", ", [$Transaction->transactions["address"]["address"], $Transaction->transactions["address"]["city"], $Transaction->transactions["address"]["postal_code"]]) ?></td>
										</tr>
									</tbody>
								</table>

								<table class="table">
									<thead>
										<tr>
											<th class="serial">#</th>
											<th>Name</th>
											<th>Quantity</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($Transaction->transactions["details"] as $key => $detail) : ?>
										<tr>
											<td><?= ++$key ?></td>
											<td><?= $detail["name"] ?></td>
											<td><?= $detail["quantity"] ?></td>
											<td><?= $detail["subtotal"] ?></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
									<tbody style="border-top: 1px solid var(--primary-color);">
										<tr>
											<td colspan="3" style="text-align: right;" >Subtotal :</td>
											<td><?= $Transaction->transactions["grand_total"] - ($Transaction->transactions["tax"] + $Transaction->transactions["shipping_fee"]) ?></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align: right;" >Tax :</td>
											<td><?= $Transaction->transactions["tax"] ?></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align: right;" >Shipping fee :</td>
											<td><?= $Transaction->transactions["shipping_fee"] ?></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align: right;" >Grandtotal :</td>
											<td><?= $Transaction->transactions["grand_total"] ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="action-btn">
								<form action="../helpers/TransactionDomain.php" method="post">
									<input type="hidden" name="code" value="<?= $Transaction->transactions["code"] ?>">
									
									<a href="transaction.php">Back to transaction</a>
									<?php if(!in_array($Transaction->transactions["status"],[3, 4])) : ?>
									<button type="submit" name="action" value="cancel" class="btn cancel-btn">Cancel</button>
									<?php endif ?>
									<?php if($Transaction->transactions["status"] == 2) : ?>
									<button type="submit" name="action" value="confirm" class="btn confirm-btn">Confirm</button>
									<?php endif ?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</section>

    <?php include_once('../layouts/admin-layouts/scriptLink.html') ?>

</body>
</html>