<?php

class StoreController
{
    public $product, $categories;

    public function __construct() {

        if ($this->getLastPathSegment() == 'store.php') {
            $this->getProduct();
        } else {

            if (isset($_GET['id'])) {
                $this->edit();
            }

            $this->getCategory();
        }
    }

    protected function getProduct() {
        $this->product = DB::table('products')->select('products.id as product_id', 'products.name', 'price', 'category_id', 'categories.id as category', 'categories.name as category_name')->leftJoin('categories', 'products.category_id', '=', 'categories.id')->orderBy("products.id", "ASC")->get();
    }

    protected function edit() {
        $id = $_GET['id'];
        $this->product = DB::table('products')->find($id);
    }

    protected function getCategory() {
        $this->categories = DB::table('categories')->get();
    }

    protected function getLastPathSegment() {
        $url = $_SERVER['REQUEST_URI'];

        $path = parse_url($url, PHP_URL_PATH);
        $pathTrimmed = trim($path, '/');
        $pathTokens = explode('/', $pathTrimmed); 

        return end($pathTokens);
    }
}

$Store = new StoreController;