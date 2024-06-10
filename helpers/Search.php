<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./DB.php";

class Search
{
    public static $products, $type, $value;

    public static function productFilter() {
        self::getProducts();
        self::productResponse();
    }

    public static function transaction() {
        $parameter_search = array_filter($_GET["transaction"], function ($query) {
            return $query != "";
        });

        $like_search = ["code", "name"];
        $limit = 10;
        $offset = ($_GET["meta"]["page"] * $limit) - $limit;

        $transactions = DB::table('transactions')
                          ->select('transactions.id', 'transactions.code', 'transactions.user_id as user_name', 'transactions.grand_total', 'transactions.transaction_status_id', 'transactions.created_at','users.name as user_name', 'transaction_statuses.name as status_name');
        
        foreach ($parameter_search as $key => $value) {
            if (in_array($key, $like_search)) {
                $transactions = $transactions->where('transactions.' . $key, 'LIKE', "%" . $value . "%");
            } else {
                $transactions = $transactions->where('transactions.' . $key, '=', $value);
            }
        }

        $transactions = $transactions->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                     ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.transaction_status_id')
                                     ->orderBy('transactions.created_at', 'DESC')
                                     ->limit($limit)->offset($offset)
                                     ->get();
        
        $transaction_count = DB::table('transactions');

        foreach ($parameter_search as $key => $value) {
            if (in_array($key, $like_search)) {
                $transaction_count = $transaction_count->where($key, 'LIKE', "%" . $value . "%");
            } else {
                $transaction_count = $transaction_count->where($key, '=', $value);
            }
        }

        $transaction_count = $transaction_count->count();
        
        $data = [
            "status" => true,
            "data" => $transactions,
            "meta" => [
                "total" => ceil($transaction_count / $limit),
                "page" => $_GET["meta"]["page"]
            ]
        ];

        echo json_encode($data);
    }

    public static function user() {
        $parameter_search = array_filter($_GET["user"], function ($query) {
            return $query != "";
        });

        $like_search = ["name"];
        $limit = 10;
        $offset = ($_GET["meta"]["page"] * $limit) - $limit;

        $users = DB::table('users')->select('users.id', 'users.name', 'users.role_id', 'users.email', 'roles.name as role_name');

        foreach ($parameter_search as $key => $value) {
            if (in_array($key, $like_search)) {
                $users = $users->where('users.' . $key, 'LIKE', "%" . $value . "%");
            } else {
                $users = $users->where('users.' . $key, '=', $value);
            }
        }

        $users = $users->leftJoin('roles', 'roles.id', '=', 'users.role_id')->orderBy('users.id', 'ASC')->limit($limit)->offset($offset)->get();

        $user_count = DB::table('users');

        foreach ($parameter_search as $key => $value) {
            if (in_array($key, $like_search)) {
                $user_count = $user_count->where($key, 'LIKE', "%" . $value . "%");
            } else {
                $user_count = $user_count->where($key, '=', $value);
            }
        }

        $user_count = $user_count->count();
        
        $data = [
            "status" => true,
            "data" => $users,
            "meta" => [
                "total" => ceil($user_count / $limit),
                "page" => $_GET["meta"]["page"]
            ]
        ];

        echo json_encode($data);
    }

    public static function store() {
        $parameter_search = array_filter($_GET["store"], function ($query) {
            return $query != "";
        });

        $like_search = ["name"];
        $limit = 10;
        $offset = ($_GET["meta"]["page"] * $limit) - $limit;

        $products = DB::table('products')->select('products.id as product_id', 'products.name', 'price', 'category_id', 'categories.id as category', 'categories.name as category_name');

        foreach ($parameter_search as $key => $value) {
            if (in_array($key, $like_search)) {
                $products = $products->where('products.' . $key, 'LIKE', "%" . $value . "%");
            } else {
                $products = $products->where('products.' . $key, '=', $value);
            }
        }

        $products = $products->leftJoin('categories', 'products.category_id', '=', 'categories.id')->orderBy("products.id", "ASC")->limit($limit)->offset($offset)->get();

        $product_count = DB::table('products');

        foreach ($parameter_search as $key => $value) {
            if (in_array($key, $like_search)) {
                $product_count = $product_count->where($key, 'LIKE', "%" . $value . "%");
            } else {
                $product_count = $product_count->where($key, '=', $value);
            }
        }

        $product_count = $product_count->count();
        
        $data = [
            "status" => true,
            "data" => $products,
            "meta" => [
                "total" => ceil($product_count / $limit),
                "page" => $_GET["meta"]["page"]
            ]
        ];

        echo json_encode($data);
    }

    protected static function getProducts() {
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

        self::$products = $products;
        self::$type = $type;
        self::$value = $value;
    }

    protected static function productResponse() {
        $user = @$_SESSION["user"];
        $products = self::$products;
        $type = self::$type;
        $value = self::$value;
        $wishlist = @$_SESSION["wishlist"];

        if(isset($user)) {
            $user_cart = DB::table('user_cart')->where('user_id', '=', $user["id"])->get();
        }

        if ($products) {
            if (isset($wishlist) && $wishlist) {
                $products = array_map(function($product) use($wishlist) {
                    $product['wishlist'] = in_array($product['id'], array_column($wishlist, 'product_id'));
                    
                    return $product;
                }, $products);
            }

            if (isset($user_cart) && $user_cart) {
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

if (isset($_GET["page"])) {
    $page = $_GET["page"];
    Search::$page();
} else {
    Search::productFilter();
}