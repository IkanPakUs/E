<div class="head-title">
    <div class="left">
        <h1><?= $page_title ?></h1>
        <ul class="breadcrumb">
            <li>
                <a class="disable">Dashboard</a>
            </li>
            <?php foreach ($menu as $name => $link) : ?>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="<?= array_key_last($menu) == $name ? 'active' : '' ?>" <?= array_key_last($menu) == $name ? '' : 'href="' . $link . '"' ?> ><?= $name ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>