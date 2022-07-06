<?php

require_once("../helpers/DB.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST)) {
    $data = validation();
    
    if ($data["status"]) {
        DB::table('users')->insert($data["data"]);
        $user = DB::table('users')->where('email', "=", $data["data"]["email"])->get();
        $user = $user[0];
        
        $_SESSION["user"] = $user;
        header("location:../index.php");
    } else {
        header("location:../register.php?message=" . $data["message"]);
    }
}

function validation() {
    $data = $_POST;
    
    if ($data["password"] == $data["cpassword"]) {
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        $data["role_id"] = 2;
        unset($data["cpassword"]);
    } else {
        return ["status" => false, "message" => "Password not match"];
    }
    
    $user = DB::table('users')->where('email', '=', $data['email'])->get();
    if ($user) {
        return ["status" => false, "message" => "Email already taken"];
    }
    
    return ["status" => true, "data" => $data];
}