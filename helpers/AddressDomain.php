<?php

require_once('./DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AddressDomain
{
    protected $user;

    public function __construct()
    {
        $user = $_SESSION["user"] ?? null;

        if (!isset($user)) {
            header("location:../login.php");
        }
        
        $this->user = $user;
    }

    public function callMethod($request) {
        $method = $request->method ?? $_GET["method"];

        switch ($method) {
            case 'getAddress':
                $this->getAddressList();
                break;

            case "selectAddress":
                $this->selectAdress();
                break;

            case 'editAddress':
                $this->editAddress();
                break;

            case 'saveAddress':
                $this->saveAddress($request);
                break;

            case 'getCountry':
                $this->getCountry();
                break;
        }
    }

    protected function getAddressList() {
        $user = $_SESSION['user'];

        $address_list = DB::table('user_detail')->where('user_id', '=', $user['id'])->get();
        echo json_encode(["status" => 1, "data" => $address_list]);
    }

    protected function selectAdress() {
        $user = $this->user;
        $address_id = $_GET["id"];

        DB::table('user_detail')->where('user_id', '=', $user['id'])->update(["is_main" => 0]);
        DB::table('user_detail')->where('user_id', '=', $user['id'])->where('id', '=', $address_id)->update(["is_main" => 1]); 
    }

    protected function editAddress() {
        $address_id = $_GET['id'];

        $address = DB::table('user_detail')->find($address_id);

        echo json_encode(["status" => 1, "data" => $address]);
    }

    protected function saveAddress($input) {
        $user_id = $this->user["id"];
        $data = (array) json_decode($input->payload);
        $data["user_id"] = $user_id;

        try {
            if (isset($data["address_id"])) {
                $address_id = $data["address_id"];
                unset($data["address_id"]);

                DB::table('user_detail')->where('id', '=', $address_id)->update($data);
            } else {
                DB::table('user_detail')->insert($data);
            }


            $list_address = DB::table('user_detail')->where('user_id', '=', $user_id)->get();
    
            echo json_encode(["status" => 1, "data" => $list_address]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0]);
        }
    }

    protected function getCountry() {
        $country = DB::table('countries')->select('code', 'name')->get();

        echo json_encode(["status" => 1, "country" => $country]);
    }
}

$body = file_get_contents('php://input');
$request = json_decode($body);

if (isset($request->method) || isset($_GET["method"])) {
    $StoreDomain = new AddressDomain();
    $StoreDomain->callMethod($request);
}