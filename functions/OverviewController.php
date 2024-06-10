<?php

class OverviewController
{
    public $transactions, $members, $overview, $ls_overview;

    public function __construct()
    {
        $this->transactions = DB::table('transactions')
                                ->select('transactions.id', 'transactions.code', 'transactions.user_id as user_name', 'transactions.grand_total', 'transactions.created_at','users.name as user_name', 'transaction_statuses.name as status_name')
                                ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.transaction_status_id')
                                ->orderBy("created_at", "DESC")
                                ->limit(5)
                                ->get();


        $this->members = DB::table('transactions')
                          ->select('users.name as name', 'SUM(grand_total) as spend', 'users.created_at')
                          ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                          ->where('transactions.transaction_status_id', '=', 3)
                          ->groupBy('user_id')
                          ->orderBy("spend", "DESC")
                          ->limit(5)
                          ->get();

        $ov_order = DB::table('transactions')
                      ->where('created_at', '>=', date('Y-m-01'))
                      ->where('created_at', '<=', date('Y-m-t'))
                      ->count();

        $ov_visitor = DB::table('users')
                      ->where('created_at', '>=', date('Y-m-01'))
                      ->where('created_at', '<=', date('Y-m-t'))
                      ->where('role_id', '!=', 1)
                      ->count();

        $ov_sales = DB::table('transactions')
                      ->where('transaction_status_id', '=', 3)
                      ->where('created_at', '>=', date('Y-m-01'))
                      ->where('created_at', '<=', date('Y-m-t'))
                      ->sum('grand_total');
        
        $ov_product = DB::table('transaction_details')
                      ->leftJoin('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
                      ->where('transaction_details.created_at', '>=', date('Y-m-01'))
                      ->where('transaction_details.created_at', '<=', date('Y-m-t'))
                      ->where('transactions.transaction_status_id', '=', 3)
                      ->count('transactions.id');

        $this->overview = [
            "ov_order" => $ov_order,
            "ov_visitor" => $ov_visitor,
            "ov_sales" => $ov_sales,
            "ov_product" => $ov_product
        ];
    }

    public function getLastOverview() {
        $overview = $this->overview;

        $ls_order = DB::table('transactions')
                      ->where('created_at', '>=', date_create("-1 month")->format('Y-m-01'))
                      ->where('created_at', '<=', date_create("-1 month")->format('Y-m-t'))
                      ->count() ?? 0;

        $ls_visitor = DB::table('users')
                    ->where('created_at', '>=', date_create("-1 month")->format('Y-m-01'))
                    ->where('created_at', '<=', date_create("-1 month")->format('Y-m-t'))
                    ->where('role_id', '!=', 1)
                    ->count() ?? 0;

        $ls_sales = DB::table('transaction_details')
                    ->leftJoin('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
                    ->where('transaction_details.created_at', '>=', date_create("-1 month")->format('Y-m-01'))
                    ->where('transaction_details.created_at', '<=', date_create("-1 month")->format('Y-m-t'))
                    ->where('transactions.transaction_status_id', '=', 3)
                    ->sum('subtotal') ?? 0;
        
        $ls_product = DB::table('transaction_details')
                    ->leftJoin('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
                    ->where('transaction_details.created_at', '>=', date_create("-1 month")->format('Y-m-01'))
                    ->where('transaction_details.created_at', '<=', date_create("-1 month")->format('Y-m-t'))
                    ->where('transactions.transaction_status_id', '=', 3)
                    ->count('transaction_details.id') ?? 0;

        $this->ls_overview = [
            "ls_order" => [
                "value" => ($overview['ov_order'] - $ls_order) / ($ls_order == 0 ? 1 : $ls_order ) * 100,
                "gain" => $overview['ov_order'] >= $ls_order,
            ],
            "ls_visitor" => [
                "value" => ($overview['ov_visitor'] - $ls_visitor) / ($ls_visitor == 0 ? 1 : $ls_visitor ) * 100,
                "gain" => $overview['ov_visitor'] >= $ls_visitor,
            ],
            "ls_sales" => [
                "value" => ($overview['ov_sales'] - $ls_sales) / ($ls_sales == 0 ? 1 : $ls_sales ) * 100,
                "gain" => $overview['ov_sales'] >= $ls_sales,
            ],
            "ls_product" => [
                "value" => ($overview['ov_product'] - $ls_product) / ($ls_product == 0 ? 1 : $ls_product ) * 100,
                "gain" => $overview['ov_product'] >= $ls_product,
            ]
        ];
    }
}