<?php

class StoreController
{
    public $product, $categories, $meta;

    public function getProduct() {
        $limit = 10;
        $this->product = DB::table('products')->select('products.id as product_id', 'products.name', 'price', 'category_id', 'categories.id as category', 'categories.name as category_name')->leftJoin('categories', 'products.category_id', '=', 'categories.id')->orderBy("products.id", "ASC")->limit($limit)->offset(0)->get();
        
        $product_count = DB::table('products')->count();
                                
        $this->meta["total"] = ceil($product_count / $limit);
        $this->meta["page"] = 1;

    }

    public function edit() {
        $id = $_GET['id'];
        $this->product = DB::table('products')->find($id);
    }

    public function getCategory() {
        $this->categories = DB::table('categories')->get();
    }
}