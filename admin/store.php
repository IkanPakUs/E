<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/StoreController.php');
	$Store = new StoreController;
	$Store->getProduct();
	
	$store_active = "active";
    $page_title = "My Store";
	$menu = ["Store" => "store.php"];
    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | My Store</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main id="store">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

            <div id="table-content">
				<div class="card">
					<div class="card-body">
						<h3 class="box-title">Product List</h3>
						<div class="create-btn">
							<a href="form-product.php">Create New</a>
						</div>
					</div>
					<div class="card-body--">
						<div class="table-wrap">
							<table class="table ">
								<thead>
									<tr>
										<th class="serial">#</th>
										<th>Name</th>
										<th>Price</th>
										<th>Category</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php if($Store->product) : ?>
                                    <?php foreach ($Store->product as $product) : ?>
									<tr product_id="<?= $product['product_id'] ?>">
										<td class="serial"><?= $no++ ?></td>
										<td><span class="name"><?= $product['name'] ?></span></td>
										<td><span class="product"><?= number_format($product['price'], 0, ',') ?></span></td>
										<td><span class="count"><?= $product['category_name'] ?></span></td>
										<td>
											<a href="form-product.php?id=<?= $product['product_id'] ?>">Edit</a> 
											/ 
											<a href="#" class="delete-btn" product_id="<?= $product['product_id'] ?>">Delete</a>
										</td>
									</tr>
                                    <?php endforeach ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6">You dont have product yet</td>
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