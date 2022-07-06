<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/TransactionController.php');
	$Transaction = new TransactionController;
	$Transaction->getTransactions();

	$transaction_active = "active";
    $page_title = "Transaction";
	$menu = ["Transaction" => "transaction.php"];
    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | Transaction</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main id="transaction">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

            <div id="table-content">
				<div class="card">
					<div class="card-body">
						<h3 class="box-title">Transaction List</h3>
					</div>
					<div class="card-body--">
						<div class="table-wrap">
							<table class="table ">
								<thead>
									<tr>
										<th class="serial">#</th>
										<th>Code</th>
										<th>Name</th>
										<th>Grandtotal</th>
										<th>Status</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if($Transaction->transactions) : ?>
                                    <?php foreach ($Transaction->transactions as $transaction) : ?>
									<tr transaction_id="<?= $transaction['id'] ?>">
										<td class="serial"><?= $no++ ?></td>
										<td><span class="name"><?= $transaction['code'] ?></span></td>
										<td><span class="count"><?= $transaction['user_name'] ?></span></td>
										<td><span class="transaction"><?= number_format($transaction['grand_total'], 0, ',') ?></span></td>
										<td><span class="count <?= $transaction['status_name'] ?>"><?= $transaction['status_name'] ?></span></td>
										<td><span class="count"><?= $transaction['created_at'] ?></span></td>
										<td>
											<a href="detail-transaction.php?id=<?= $transaction['id'] ?>">Show</a>
										</td>
									</tr>
                                    <?php endforeach ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6">You dont have any transaction yet</td>
                                        </tr>
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