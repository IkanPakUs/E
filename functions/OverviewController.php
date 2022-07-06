<?php

class OverviewController
{
    public $transactions, $members, $overview, $ls_overview;

    public function __construct()
    {
        $this->transactions = DB::table('transactions')
                                ->select('transactions.id', 'transactions.code', 'transactions.user_id as user_name', 'transactions.grand_total', 'transactions.status as status_name', 'transactions.created_at','users.name as user_name', 'transaction_statuses.name as status_name')
                                ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                ->leftJoin('transaction_statuses', 'transaction_statuses.id', '=', 'transactions.status')
                                ->orderBy("created_at", "DESC")
                                ->limit(5)
                                ->get();


        $this->members = DB::table('user_spend')
                          ->leftJoin('users', 'users.id', '=', 'user_spend.user_id')
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

        $ov_sales = DB::table('transaction_details')
                      ->where('created_at', '>=', date('Y-m-01'))
                      ->where('created_at', '<=', date('Y-m-t'))
                      ->where('status', '=', 3)
                      ->sum('subtotal');
        
        $ov_product = DB::table('transaction_details')
                      ->where('created_at', '>=', date('Y-m-01'))
                      ->where('created_at', '<=', date('Y-m-t'))
                      ->where('status', '=', 3)
                      ->count();

        $this->overview = [
            "ov_order" => $ov_order,
            "ov_visitor" => $ov_visitor,
            "ov_sales" => $ov_sales,
            "ov_product" => $ov_product
        ];
        

        if ($this->getLastPathSegment() == 'analytic.php') {
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
                        ->where('created_at', '>=', date_create("-1 month")->format('Y-m-01'))
                        ->where('created_at', '<=', date_create("-1 month")->format('Y-m-t'))
                        ->where('status', '=', 3)
                        ->sum('subtotal') ?? 0;
            
            $ls_product = DB::table('transaction_details')
                        ->where('created_at', '>=', date_create("-1 month")->format('Y-m-01'))
                        ->where('created_at', '<=', date_create("-1 month")->format('Y-m-t'))
                        ->where('status', '=', 3)
                        ->count() ?? 0;

            $this->ls_overview = [
                "ls_order" => [
                    "value" => ($ov_order - $ls_order) / ($ls_order == 0 ? 1 : $ls_order ) * 100,
                    "gain" => $ov_order >= $ls_order,
                ],
                "ls_visitor" => [
                    "value" => ($ov_visitor - $ls_visitor) / ($ls_visitor == 0 ? 1 : $ls_visitor ) * 100,
                    "gain" => $ov_visitor >= $ls_visitor,
                ],
                "ls_sales" => [
                    "value" => ($ov_sales - $ls_sales) / ($ls_sales == 0 ? 1 : $ls_sales ) * 100,
                    "gain" => $ov_sales >= $ls_sales,
                ],
                "ls_product" => [
                    "value" => ($ov_product - $ls_product) / ($ls_product == 0 ? 1 : $ls_product ) * 100,
                    "gain" => $ov_product >= $ls_product,
                ]
            ];
        }
    }

    protected function getLastPathSegment() {
        $url = $_SERVER['REQUEST_URI'];

        $path = parse_url($url, PHP_URL_PATH);
        $pathTrimmed = trim($path, '/');
        $pathTokens = explode('/', $pathTrimmed); 

        return end($pathTokens);
    }
}

$Overview = new OverviewController();