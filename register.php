<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION["user"])) {
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Europhia | Register</title>

   <?php include_once('layouts/app-layouts/styleLink.html') ?>
</head>
<body>
    <div class="container">
        <?php if(isset($_GET["message"])) : ?>
        <div class="alert alert-danger alert-dismissible fade show float-alert" role="alert">
            <?= $_GET["message"] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif ?>
        <div id="register" class="content">
            <div class="left-content">
                <h1>REGISTER</h1>
                <form action="functions/register.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" id="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
                    </div>
                    <div class="form-group reg-button">
                        <button>Register</button>
                    </div>
                </form>
                Already have an account ? <a href="login.php" class="rl-link">Sign in</a>
            </div>
            <div class="right-content">
                <div class="bubble" id="bubble-1"></div>
                <div class="bubble" id="bubble-2"></div>
                <div class="img-wrapper">
                    <img src="src/img/thumbnail/register-chair.png" alt="Register">
                </div>
            </div>
        </div>
    </div>
</body>
</html>