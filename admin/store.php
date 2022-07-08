<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/StoreController.php');
	$Store = new StoreController;
	$Store->getCategory();
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
		<main class="page" id="store">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

            <div id="table-content">
				<div class="card">
					<div class="card-body">
						<h3 class="box-title">Product List</h3>
						<div class="create-btn">
							<a href="form-product.php">Create New</a>
						</div>
					</div>
					<div class="card__filter">
						<div class="form-group">
							<label for="name">Search Name</label>
							<input type="text" id="name" class="search">
							<i>* press enter after type keyword you want search</i>
						</div>
						<div class="form-group">
							<label for="category_id">Category</label>
							<select id="category_id" class="search">
								<option value="">All Category</option>
								<?php foreach ($Store->categories as $category) : ?>
									<option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
								<?php endforeach ?>
							</select>
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
										<td><span class="product"><?= number_format($product['price'], 0, 0, ',') ?></span></td>
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
					<div class="card__footer">
						<div class="pagination">
							<div class="pagination__left">
								<i page="<?= $Store->meta["page"] ?>" class="bi bi-chevron-left paginate_nav <?= $Store->meta["page"] <= 1 ? "disable" : "" ?> prev"></i>
							</div>
							<div class="pagination__page-info">
								<ul>
									<?php for ($i=1; $i <= $Store->meta["total"] ; $i++) : ?>
									<li page="<?= $i ?>" class="<?= $i == 1 ? "active" : "" ?> paginate_nav"><?= $i ?></li>
									<?php endfor ?>
								</ul>
							</div>
							<div class="pagination__right">
								<i page="<?= $Store->meta["page"] ?>" class="bi bi-chevron-right paginate_nav  <?= $Store->meta["page"] >= $Store->meta["total"] ? "disable" : "" ?> next"></i>
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