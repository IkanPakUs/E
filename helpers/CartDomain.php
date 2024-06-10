<?php

require_once('./DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CartDomain
{
    public $user, $role, $wishlist;

    public function __construct()
    {
        $user = $_SESSION["user"] ?? null;

        if (!isset($user)) {
            echo json_encode(['status' => 0, 'message' => 'User not authorized', 'code' =>  401]);
        }
        
        $this->user = $user;
    }

    public function callMethod() {
        $method = $_GET["method"];
        $this->$method();
    }

    protected function addCart() {
        $user = $this->user;

        if (isset($user)) {
            $product_id = $_GET["id"];
            $product = DB::table('products')->select('id', 'name', 'price', 'image_url')->find($product_id);
            $cart = DB::table('user_cart')->where('user_id', '=', $user["id"])->where('product_id', '=', $product["id"])->get();
            $quantity = 1;
    
            if ($cart) {
                $cart = $cart[0];
                $quantity += $cart["quantity"];
            }
    
            $subtotal = $product["price"] * $quantity;
            $data = ["user_id" => $user["id"], "product_id" => $product["id"], "quantity" => $quantity, "subtotal" => $subtotal];
    
            if ($cart) {
                DB::table('user_cart')->where('id', '=', $cart["id"])->update($data);
            } else {
                DB::table('user_cart')->insert($data);
            }
    
            $cart_list = DB::table('user_cart')->where('user_id', '=', $user["id"])->get();
            $_SESSION['cart'] = DB::table('user_cart')->where('user_id', '=', $user["id"])->get();
            
            if ($cart_list) {
                $cart_list = array_map(function ($v) {
                    $product_id = $v["product_id"];
                    $v["product"] = DB::table('products')->find($product_id);
                    return $v;
                }, $cart_list);
                
            }
            
            echo json_encode(["type" => "addCart", "data" => $cart_list]);
        }
    }

    protected function removeCart() {
        $user = $this->user;
        $product_id = $_GET["id"];

        if (isset($user)) {
            DB::table('user_cart')->where('user_id', '=', $user["id"])->where('product_id', '=', $product_id)->delete();
    
            $cart_list = DB::table('user_cart')->where('user_id', '=', $user["id"])->get();
            $_SESSION['cart'] = DB::table('user_cart')->where('user_id', '=', $user["id"])->get();
            
            if ($cart_list) {
                $cart_list = array_map(function ($v) {
                    $product_id = $v["product_id"];
                    $v["product"] = DB::table('products')->find($product_id);
                    return $v;
                }, $cart_list);
                
            }
    
            echo json_encode(["type" => "removeCart", "data" => $cart_list]);
        }
    }

    protected function wishlist() {
        $user = $this->user;
        $product_id = $_GET["id"];

        if (isset($user)) {
            $wishlist = DB::table('user_wishlist')->where('user_id', '=', $user['id'])->where('product_id', '=', $product_id)->get();
    
            if($wishlist) {
                $this->removeWishlist();
            } else {
                $this->addWishlist();
            }
        }
    }

    protected function addWishlist() {
        $user = $this->user;

        $product_id = $_GET["id"];
        $user_id = $user["id"];

        $data = ["user_id" => $user_id, "product_id" => $product_id];

        DB::table('user_wishlist')->insert($data);

        $_SESSION["wishlist"] = DB::table('user_wishlist')->where('user_id', '=', $_SESSION['user']['id'])->get();

        echo json_encode(["type" => "addWishlist"]);
    }

    protected function removeWishlist() {
        $user = $this->user;
        $product_id = $_GET["id"];

        DB::table('user_wishlist')->where('user_id', '=', $user["id"])->where('product_id', '=', $product_id)->delete();
        
        $_SESSION["wishlist"] = DB::table('user_wishlist')->where('user_id', '=', $_SESSION['user']['id'])->get();

        echo json_encode(["type" => "removeWishlist"]);
    }
}

if (isset($_GET["method"])) {
    $Cart = new CartDomain();
    $Cart->callMethod();
}
