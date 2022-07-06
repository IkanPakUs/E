<?php

class TransactionController
{
    public $transactions;

    public function getTransactions() {
        $this->transactions = DB::table('transactions')
                                ->select('transactions.id', 'transactions.code', 'transactions.user_id as user_name', 'transactions.grand_total', 'transactions.status as status_name', 'transactions.created_at','users.name as user_name', 'transaction_statuses.name as status_name')
                                ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.status')
                                ->get();
    }

    public function show() {
        $id = $_GET["id"];
        $transactions = DB::table('transactions')
                          ->where('transactions.id', '=', $id)
                          ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.status')
                          ->get();
        $transactions = $transactions[0];
        $transactions["details"] = DB::table('transaction_details')
                                     ->where('transaction_details.transaction_code', '=', $transactions["code"])
                                     ->leftJoin('products', 'products.id', '=', 'transaction_details.product_id')
                                     ->get();
        $transactions["address"] = DB::table('user_detail')->find($transactions["address_id"]);
        
        $transactions["user"] = DB::table('users')->find($transactions["user_id"]);

        $this->transactions = $transactions;
    }
}