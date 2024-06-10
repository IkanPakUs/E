<?php

class CartController
{
    public $user, $role, $cart_list, $oo_stock, $address, $address_list, $summary;

    public function __construct() {

        $user = @$_SESSION['user'];

        if (isset($user)) {
            $cart_list = DB::table('user_cart')->select('products.*', 'user_cart.quantity', 'user_cart.subtotal')->where('user_id', '=', $user["id"])->leftJoin("products", "products.id", "=", "user_cart.product_id")->where('products.stock', '>', 0)->get();
            $oo_stock = DB::table('user_cart')->select('products.*', 'user_cart.quantity', 'user_cart.subtotal')->where('user_id', '=', $user["id"])->leftJoin("products", "products.id", "=", "user_cart.product_id")->where('products.stock', '=', 0)->get();

            $this->user = $user;
            $this->role = $user["role_id"];
            $this->cart_list = $cart_list;
            $this->oo_stock = $oo_stock;
        }
    }

    public function getAddressDetail() {
        $user = $_SESSION['user'];

        $address = DB::table('user_addresses')->where('user_id', '=', $user['id'])->where('is_main', '=', 1)->get();
        $this->address = @$address[0];
    }

    public function getAddressList() {
        $user = $_SESSION['user'];

        $address_list = DB::table('user_addresses')->where('user_id', '=', $user['id'])->get();
        $this->address_list = $address_list;
    }

    public function getTransactionSummary() {
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
}