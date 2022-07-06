<?php

class CatalogController
{
    public $user, $role, $categories, $catalog, $catalog_count;

    public function __construct()
    {
        $this->user = $_SESSION["user"] ?? null;
        $this->role = $this->user["role_id"] ?? null;

        $this->loadCategory();
        $this->loadCatalog();
    }
    
    protected function loadCategory() {
        $categories = DB::table('categories')->get();

        $this->categories = $categories;
    }
    
    protected function loadCatalog() {
        $filter = @$_GET["filter"];
        
        $catalog = DB::table('products');

        if (isset($filter)) {
            $catalog = $catalog->where("category_id", "=", $filter["category"]);
        }

        $catalog = $catalog->get();

        $this->catalog = $catalog;
        $this->catalog_count = count($catalog);
    }

    public function isWishlist($product_id) {
        $wishlist = @$_SESSION["wishlist"];

        if ($wishlist) {
            return in_array($product_id, array_column($wishlist, 'product_id'));
        }
    
        return false;
    }

    public function isInCart($product_id) {
        $cart = @$_SESSION["cart"];

        if ($cart) {
            return in_array($product_id, array_column($cart, 'product_id'));
        }

        return false;
    }

}