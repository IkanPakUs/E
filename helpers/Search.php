<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./DB.php";

class Search
{
    public $products, $type, $value;

    public function __construct()
    {
        $this->getProducts();
        $this->productResponse();
    }

    protected function getProducts() {
        if (isset($_GET['filter']) || (isset($_GET['category']) && $_GET['category'] != '')) {

            if (isset($_GET["filter"])) {
                $products = DB::table('products')->where('name', 'like', "%" . $_GET["filter"] . "%")->get();
                $type = "name";
                $value = $_GET["filter"];
            }

            if (isset($_GET["category"])) {
                $products = DB::table('products')->where('category_id', '=', $_GET['category'])->get();
                $type = "category";
                $value = $_GET["category"];
            }

        } else {
            $products = DB::table('products')->get();
            $type = '';
            $value = '';       
        }

        $this->products = $products;
        $this->type = $type;
        $this->value = $value;
    }

    protected function productResponse() {
        $user = @$_SESSION["user"];
        $products = $this->products;
        $type = $this->type;
        $value = $this->value;
        $wishlist = $_SESSION["wishlist"];

        if(isset($user)) {
            $user_cart = DB::table('user_cart')->where('user_id', '=', $user["id"])->get();
        }

        if ($products) {
            if ($wishlist) {
                $products = array_map(function($product) use($wishlist) {
                    $product['wishlist'] = in_array($product['id'], array_column($wishlist, 'product_id'));
                    
                    return $product;
                }, $products);
            }

            if ($user_cart) {
                $products = array_map(function($product) use($user_cart) {
                    $product["in_cart"] = in_array($product['id'], array_column($user_cart, 'product_id'));
                    
                    return $product;
                }, $products);
            }

            $data = [
                "status" => true,
                "message" => "",
                "data" => json_encode($products),
                "filter" => [
                    "type" => $type,
                    "value" => $value
                ],
            ];
        
        } else {
            $data = [
                "status" => false,
                "message" => "Data not found",
                "data" => [],
                "filter" => [
                    "type" => $type,
                    "value" => $value
                ],
            ];
        }
        
        echo json_encode($data);
    }
}

new Search();