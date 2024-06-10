<?php
session_start();

require_once('DB.php');

class StoreDomain
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

                header('location:' . $_SESSION["root_path"] . 'admin/store.php');

                break;
        }

    }

    public function create() {
        $data = [
            "name" => $_POST["name"],
            "price" => $_POST["price"],
            "stock" => $_POST["stock"],
            "image_url" => $_FILES["image"]["name"],
            "category_id" => $_POST["category"]
        ];

        $image_check = $this->imageUpload();

        if ($image_check) {
            DB::table('products')->insert($data);
        }
    }

    public function update() {
        $id = $_POST['id'];

        $data = [
            "name" => $_POST["name"],
            "price" => $_POST["price"],
            "stock" => $_POST["stock"],
            "category_id" => $_POST["category"]
        ];

        if ($_FILES["image"]["name"]  != "") {
            $data["image_url"] = $_FILES["image"]["name"];
        }

        $image_check = $this->imageUpload("update");

        if ($image_check) {
            DB::table('products')->where('id', '=',$id)->update($data);
        }
    }

    protected function destroy() {
        $id = $this->id;

        DB::table('products')->where('id', '=', $id)->delete();
        DB::table('user_cart')->where('product_id', '=', $id)->delete();
        DB::table('user_wishlist')->where('product_id', '=', $id)->delete();
    }

    protected function imageUpload($action = null) {
        if ($_FILES["image"]["name"]  != "") {

            $target_file = '../src/img/product/' . basename($_FILES["image"]["name"]);
            $check = getimagesize($_FILES["image"]["tmp_name"]);
    
            if ($check != false) {
                if (!file_exists($target_file)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        } else if ($action == "update") {
            return true;
        }

        return false;
    }
}

$body = file_get_contents('php://input');
$request = json_decode($body);

if (isset($request->method) || isset($_POST["method"])) {
    $StoreDomain = new StoreDomain();
    $StoreDomain->callMethod($request);
}