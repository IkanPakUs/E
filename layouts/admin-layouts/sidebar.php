<!-- SIDEBAR -->
<section id="sidebar">
    <a href="<?= $_SESSION["root_path"] ?>" class="brand">
        <span class="text">Euphoria</span>
    </a>

    <ul class="side-menu top">
        <li class="<?= @$dashboard_active ?>">
            <a href="overview.php">
                <i class='bx uil uil-estate'></i>
                <span class="text">Overview</span>
            </a>
        </li>
        <li class="<?= @$analytic_active ?>">
            <a href="analytic.php">
                <i class='bx uil uil-chart'></i>
                <span class="text">Analytics</span>
            </a>
        </li>
        <li class="<?= @$store_active ?>">
            <a href="store.php">
                <i class='bx uil uil-files-landscapes'></i>
                <span class="text">My Store</span>
            </a>
        </li>
        <li class="<?= @$transaction_active ?>">
            <a href="transaction.php">
                <i class="bx uil uil-wallet"></i>
                <span class="text">Transaction</span>
            </a>
        </li>
        <li class="<?= @$user_active ?>">
            <a href="user.php">
                <i class="bx uil uil-user"></i>
                <span class="text">User</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu top">
        <li class="bottom"></li>
        <li>
            <a href="../functions/logout.php" class="logout">
                <i class='bx uil uil-signout'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>