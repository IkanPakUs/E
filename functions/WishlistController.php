<?php

class WishlistController
{
    public $user, $role, $wishlist;

    public function __construct()
    {   
        if (!isset($_SESSION["user"])) {
            header('location: login.php');
        }
        
        $this->user = $_SESSION["user"];
        $this->role = $this->user["role_id"] ?? null;

        $this->loadWishlist();
    }
    protected function loadWishlist() {
        $user = $this->user;

        $wishlist = DB::table('user_wishlist')->where('user_id', '=', $user['id'])->leftJoin('products', 'products.id', '=', 'user_wishlist.product_id')->get();

        $this->wishlist = $wishlist;
    }

    public function isInCart($product_id) {
        $cart = @$_SESSION["cart"];

        if ($cart) {
            return in_array($product_id, array_column($cart, 'product_id'));
        }

        return false;
    }

}

$Wishlist = new WishlistController();