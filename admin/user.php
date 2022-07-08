<?php 
    require_once('../helpers/DB.php');
	include_once('validate.php');
    require_once('../functions/UserController.php');
	$User = new UserController;
	$User->getRoles();
	$User->getUser();

	$user_active = "active";
    $page_title = "My User";
	$menu = ["User" => "user.php"];
    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Euphoria Admin | user</title>

    <?php include_once('../layouts/admin-layouts/styleLink.html') ?>
</head>
<body>

	<?php include_once('../layouts/admin-layouts/sidebar.php') ?>

	<section id="content">
		<main class="page" id="user">
			<?php include_once('../layouts/admin-layouts/breadcrummb.php') ?>

            <div id="table-content">
				<div class="card">
					<div class="card-body">
						<h3 class="box-title">User List</h3>
                        <div class="create-btn">
							<a href="form-user.php">Create New</a>
						</div>
					</div>
					<div class="card__filter">
						<div class="form-group">
							<label for="name">Search Name</label>
							<input type="text" id="name" class="search">
							<i>* press enter after type keyword you want search</i>
						</div>
						<div class="form-group">
							<label for="role_id">Role</label>
							<select id="role_id" class="search">
								<option value="">All Role</option>
								<?php foreach ($User->roles as $role) : ?>
									<option value="<?= $role["id"] ?>"><?= $role["name"] ?></option>
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
										<th>Email</th>
										<th>Role</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php if ($User->user) : ?>
                                    <?php foreach($User->user as $user) : ?>
                                    <tr user_id="<?= $user['id'] ?>">
                                        <td><?= $no++ ?></td>
                                        <td><?= $user['name'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['role_name'] ?></td>
                                        <td>
											<a href="form-user.php?id=<?= $user['id'] ?>">Edit</a> 
											/ 
											<a href="#" class="delete-btn" user_id="<?= $user['id'] ?>">Delete</a>
										</td>
                                    </tr>    
                                    <?php endforeach ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="6">You dont have any user yet</td>
                                    </tr>
                                    <?php endif ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card__footer">
						<div class="pagination">
							<div class="pagination__left">
								<i class="bi bi-chevron-left"></i>
							</div>
							<div class="pagination__page-info">
								<ul>
									<li class="active">1</li>
								</ul>
							</div>
							<div class="pagination__right">
								<i class="bi bi-chevron-right"></i>
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