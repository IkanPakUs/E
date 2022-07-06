<?php
require_once "../helpers/DB.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST)) {
    $data = validation();

    if ($data["status"]) {
        $_SESSION["user"] = $data["data"];

        $_SESSION['wishlist'] = DB::table('user_wishlist')->where('user_id', '=', $_SESSION['user']['id'])->get();

        header("location:../index.php");
    } else {
        header("location:../login.php?message=" . $data["message"]);
    }
}

function validation() {
    $data = $_POST;

    $user = DB::table('users')->where('email', '=', $data["email"])->get();

    if ($user) {
        $user = $user[0];
        
        if (password_verify($data["password"], $user["password"])) {
            return ["status" => true, "data" => $user];
        }
    }

    return ["status" => false, "message" => "email or password wrong"];
}
