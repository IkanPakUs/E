<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/UserController.php');
	$User = new UserController;
	$User->getRoles();
    
	$user_active = "active";
	$type = isset($_GET['id']) ? "update" : "create";
    $page_title = "My user";
	$menu = ["User" => "user.php"];

	if ($type == "update") {
		$menu["Edit"] = "form-user.php?id=" . $_GET['id'];
		$User->edit();
	} else {
		$menu["Create"] = "form-user.php";
	}

	$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | User Management</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main id="user">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

            <div class="card">
				<form action="../helpers/UserDomain.php" method="post">
					<input type="hidden" name="method" value="save">
					<?php if(isset($_GET["id"])) : ?>
					<input type="hidden" name="id" value=<?= $_GET["id"] ?> >
					<?php endif ?>

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" value="<?= @$User->user['name'] ?>" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" value="<?= @$User->user['email'] ?>" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" value="<?= @$User->user['password'] ?>" autocomplete="new-password">
						<?php if ($type == "update") : ?>
                        <i>* Fill this input if you want change the password</i>
						<?php endif ?>
					</div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role_id" id="role" required>
                            <option value="0">Select user role</option>
                            <?php foreach ($User->roles as $role) : ?>
                            <option value="<?= @$role['id'] ?>" <?= @$User->user["role_id"] == $role["id"] ? "selected" : "" ?> ><?= $role['name'] ?></option>
                            <?php endforeach ?>
                        </select>
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