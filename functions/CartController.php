<?php

class CartController
{
    public $user, $role, $cart_list, $address, $address_list, $summary;

    public function __construct() {

        $user = @$_SESSION['user'];

        if (isset($user)) {        

            $cart_list = DB::table('user_cart')->where('user_id', '=', $user["id"])->leftJoin("products", "products.id", "=", "user_cart.product_id")->get();

            $this->user = $user;
            $this->role = $user["role_id"];
            $this->cart_list = $cart_list;

            if ($this->getLastPathSegment() == 'shopping-cart.php') {
                $this->getAddressDetail();
                $this->getAddressList();
                $this->getTransactionSummary();
            }

        }
    }

    protected function getAddressDetail() {
        $user = $_SESSION['user'];

        $address = DB::table('user_detail')->where('user_id', '=', $user['id'])->where('is_main', '=', 1)->get();
        $this->address = @$address[0];
    }

    protected function getAddressList() {
        $user = $_SESSION['user'];

        $address_list = DB::table('user_detail')->where('user_id', '=', $user['id'])->get();
        $this->address_list = $address_list;
    }

    protected function getTransactionSummary() {
        $cart_list = $this->cart_list;

        $subtotal = 0;
        $tax = 0;
        $shipping_fee = 0;

        if ($cart_list) {
            $subtotal = array_reduce($cart_list, function ($total, $item) {
                return $total += $item["subtotal"];
            });
    
            $tax = $subtotal * 10 / 100;
    
            $shipping_fee = 200000;
        }

        $this->summary["subtotal"] = $subtotal;
        $this->summary["tax"] = $tax;
        $this->summary["shipping"] = $shipping_fee;
        $this->summary["grand_total"] = $subtotal + $tax + $shipping_fee;
    }

    public function isWishlist($product_id) {
        $wishlist = @$_SESSION["wishlist"];

        if ($wishlist) {
            return in_array($product_id, array_column($wishlist, 'product_id'));
        }
    
        return false;
    }

    protected function getLastPathSegment() {
        $url = $_SERVER['REQUEST_URI'];

        $path = parse_url($url, PHP_URL_PATH);
        $pathTrimmed = trim($path, '/');
        $pathTokens = explode('/', $pathTrimmed); 

        return end($pathTokens);
    }
}

$Cart = new CartController();