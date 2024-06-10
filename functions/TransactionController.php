<?php

class TransactionController
{
    public $transactions, $statuses, $meta;

    public function getTransactions() {
        $limit = 10;
        $this->statuses = DB::table('transaction_statuses')->get();

        $transactions = DB::table('transactions')
                                ->select('transactions.id', 'transactions.code', 'transactions.user_id as user_name', 'transactions.grand_total', 'transactions.created_at','users.name as user_name', 'transaction_statuses.name as status_name')
                                ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.transaction_status_id')
                                ->orderBy('transactions.created_at', 'DESC')
                                ->limit($limit)->offset(0)
                                ->get();

        $transaction_count = DB::table('transactions')->count();
                                
        $this->transactions = $transactions;

        $this->meta["total"] = ceil($transaction_count / $limit);
        $this->meta["page"] = 1;

    }

    public function show() {
        $id = $_GET["id"];

        $transactions = DB::table('transactions')
                          ->select('transactions.*', 'transaction_statuses.name')
                          ->where('transactions.id', '=', $id)
                          ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.transaction_status_id')
                          ->get();

        $transactions = $transactions[0];
        $transactions["details"] = DB::table('transaction_details')
                                     ->where('transaction_details.transaction_id', '=', $transactions["id"])
                                     ->leftJoin('products', 'products.id', '=', 'transaction_details.product_id')
                                     ->get();

        $transactions["address"] = DB::table('user_addresses')->find($transactions["address_id"]);
        
        $transactions["user"] = DB::table('users')->find($transactions["user_id"]);

        $this->transactions = $transactions;
    }
}