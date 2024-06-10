<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/StoreController.php');
	$Store = new StoreController;
    $Store->getCategory();
	
	$store_active = "active";
	$type = isset($_GET['id']) ? "update" : "create";
    $page_title = "My Store";
	$menu = ["Store" => "store.php"];

	if ($type == "update") {
		$menu["Edit"] = "form-product.php?id=" . $_GET['id'];
		$Store->edit();
	} else {
		$menu["Create"] = "form-product.php";
	}

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

            <div class="card">
				<form action="../helpers/StoreDomain.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="method" value="save">
					<?php if(isset($_GET["id"])) : ?>
					<input type="hidden" name="id" value=<?= $_GET["id"] ?> >
					<?php endif ?>

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" value="<?= @$Store->product['name'] ?>" required>
					</div>
					<div class="form-wrap">
						<div class="left-side">
							<div class="image-input">
								<label for="image">Image</label>
								<div class="image-wrap <?= empty(@$Store->product) ? "" : "show" ?>">
									<input type="file" name="image" id="image">
									<img class="img-preview" src="<?= isset($Store->product['image_url']) ? $_SESSION ["root_path"] . "src/img/product/" . $Store->product['image_url'] : "" ?>" loading="lazy">
								</div>
							</div>
						</div>
						<div class="right-side">
							<div class="form-group">
								<label for="price">Price</label>
								<input type="number" name="price" id="price" value="<?= @$Store->product['price'] ?>" required>
							</div>
							<div class="form-group">
								<label for="price">Stock</label>
								<input type="number" name="stock" id="stock" value="<?= @$Store->product['stock'] ?>" required>
							</div>
							<div class="form-group">
								<label for="price">Category</label>
								<select name="category" id="category" required>
									<option value="0">Select category</option>
									<?php foreach ($Store->categories as $category) : ?>
									<option value="<?= @$category['id'] ?>" <?= @$Store->product["category_id"] == $category["id"] ? "selected" : "" ?> ><?= $category['name'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group save-btn">
						<button type="submit" name="action" value="<?= $type ?>">Save</button>
					</div>
				</form>
			</div>
		</main>
	</section>

    <?php include_once('../layouts/admin-layouts/scriptLink.html') ?>

</body>
</html>