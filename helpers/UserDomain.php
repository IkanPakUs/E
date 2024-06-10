<?php
session_start();

require_once('DB.php');

class UserDomain
{
    protected $id;

    public function callMethod($request) {
        $method = $request->method ?? $_POST["method"];
        $this->id = @$request->id;

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


        switch ($method) {
            case 'delete':
                $this->destroy();
                break;

            case 'save':
                if ($_POST["action"] == "create") {
                    $this->create();
                }

                if ($_POST["action"] == "update") {
                    $this->update();
                }

                header('location:' . $_SESSION["root_path"] . 'admin/user.php');

                break;
        }

    }

    public function create() {
        $data = [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
            "role_id" => $_POST["role_id"],
        ];

        DB::table('users')->insert($data);
    }

    public function update() {
        $id = $_POST['id'];
        $user = @$_SESSION["user"];

        if (isset($_POST["role_id"]) && @$_POST["role_id"] == 1) {
            $set_user = DB::table('users')->find($id);

            $role = $user["role_id"] == 1 ?  $_POST["role_id"] : $set_user["role_id"];
        }

        $data = [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "role_id" => @$role ?? $_POST["role_id"],
        ];

        if (isset($_POST["password"]) && $_POST["password"] != "") {
            $data["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }
        
        DB::table('users')->where('id', '=',$id)->update($data);
    }

    protected function destroy() {
        $id = $this->id;
        $user = @$_SESSION["user"];

        if ($id != $user["id"]) {
            DB::table('users')->where('id', '=', $id)->delete();
            DB::table('user_addresses')->where('user_id', '=', $id)->delete();

            echo json_encode(["message" => "ok", "code" => 200]);
        } else {
            echo json_encode(["message" => "User Not Authorized", "code" => 403]);
        }

    }
}

$body = file_get_contents('php://input');
$request = json_decode($body);

if (isset($request->method) || isset($_POST["method"])) {
    $UserDomain = new UserDomain();
    $UserDomain->callMethod($request);
}