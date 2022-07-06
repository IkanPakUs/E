<?php
session_start();

require_once('DB.php');

class UserDomain
{
    protected $id;

    public function callMethod($request) {
        $method = $request->method ?? $_POST["method"];
        $this->id = @$request->id;

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

        $data = [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "role_id" => $_POST["role_id"],
        ];

        if (isset($_POST["password"]) && $_POST["password"] != "") {
            $data["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }
        
        DB::table('users')->where('id', '=',$id)->update($data);
    }

    protected function destroy() {
        $id = $this->id;

        DB::table('users')->where('id', '=', $id)->delete();
    }
}

$body = file_get_contents('php://input');
$request = json_decode($body);

if (isset($request->method) || isset($_POST["method"])) {
    $UserDomain = new UserDomain();
    $UserDomain->callMethod($request);
}