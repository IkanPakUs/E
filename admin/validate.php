<?php

session_start();

if (isset($_SESSION["user"]) ) {
    if ($_SESSION["user"]["role_id"] != 1) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $return_des = 'location: ' . $_SERVER['HTTP_REFERER'];
        } else {
            $return_des = 'location: ../index.php';
        }
    }

    header(@$return_des);

} else {
    header('location: ../login.php');
}
