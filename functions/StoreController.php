<?php

class StoreController
{
    public $product, $categories;

    public function getProduct() {
        $this->product = DB::table('products')->select('products.id as product_id', 'products.name', 'price', 'category_id', 'categories.id as category', 'categories.name as category_name')->leftJoin('categories', 'products.category_id', '=', 'categories.id')->orderBy("products.id", "ASC")->get();
    }

    public function edit() {
        $id = $_GET['id'];
        $this->product = DB::table('products')->find($id);
    }

    public function getCategory() {
        $this->categories = DB::table('categories')->get();
    }
}