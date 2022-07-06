<?php

require_once('./DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


class CheckoutDomain
{
    protected $user, $address, $products;

    public function __construct() {
        $request = $_POST;
        
        $this->user = @$_SESSION['user'];
        $this->address = $request["address"];
        $this->products = $request["product_cart"];

        $this->saveTransaction();
    }

    protected function saveTransaction() {
        
        $code = "EU_" . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 6) .  date("y");
        
        $transaction_details = $this->getTransactionDetail($code);
        
        $user_id = $this->user["id"];
        $address_id = $this->address;

        $subtotal = array_reduce($transaction_details, function ($total, $detail) {
            return $total += $detail["subtotal"];
        });

        $tax = $subtotal * 10 / 100;
        $shipping_fee = 200000;

        $status = 1;

        $transaction = [
            "code" => $code,
            "user_id" => $user_id,
            "address_id" => $address_id,
            "grand_total" => ceil($subtotal + $tax + $shipping_fee),
            "tax" => ceil($tax),
            "shipping_fee" => $shipping_fee,
            "status" => $status,
        ];

        try {
            DB::table('transactions')->insert($transaction);
            DB::table('transaction_details')->insert($transaction_details);

            DB::table('user_cart')->where('user_id', '=', $user_id)->delete();
            $_SESSION["cart"] = [];
            
            header('location: ../payment.php?code=' . $code);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    protected function getTransactionDetail($code) {
        $products = $this->products;
        $data_product = DB::table('products')->select('id', 'price')->where('id', 'IN', '(' . implode(',', array_keys($products)) .')')->get();

        $details = array_map( function ($product) use($code, $products, $data_product) {

            $quantity = $products[$product]["quantity"];

            $data_product_key = array_search($product, array_column($data_product, 'id'));
            $subtotal = $data_product[$data_product_key]["price"] * $quantity;

            return [
                "transaction_code" => $code,
                "product_id" => $product,
                "quantity" => $quantity,
                "subtotal" => $subtotal,
            ];

        }, array_keys($products));

        return $details;
    }
}

$Checkout = new CheckoutDomain;