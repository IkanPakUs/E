<?php
require_once('./DB.php');
include_once('../admin/validate.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AnalyticDomain
{
    protected $month;
    
    public function __construct($request)
    {
        $method = $request->method ?? $_GET["method"];

        $month = [];
        while (count($month) <= 6) {
            $month_date = date_create("-" . count($month) . " month")->format('m');
            $year_date = date_create("-" . count($month) . " month")->format('Y');
            array_push($month, ["year" => $year_date, "month" => $month_date]);
        }

        $this->month = $month;
        $this->$method();
    }

    public function getUsersGrowth() {
        $month = $this->month;

        $users_growth = DB::table('users')->select('YEAR(created_at) as year', 'MONTH(created_at) as month', 'id')->where('role_id', '!=', 1)->where('MONTH(created_at)', 'IN', "(" . implode(", ", array_column($month, 'month')) . ")")->get();
        $users_growth = array_map( function ($date) use($users_growth) {
            return [
                "month" => date_create($date["year"] . "-" . $date["month"] . "-01")->format('F'),
                "value" => count(array_filter($users_growth, function ($user) use($date) {
                    return $user["month"] == $date["month"];
                })),
            ];
        }, $month);

        echo json_encode(["status" => true, "data" => $users_growth]);
    }

    public function getOrderGrowth() {
        $month = $this->month;

        $order_growth = DB::table('transactions')->select('YEAR(created_at) as year', 'MONTH(created_at) as month', 'id')->where('MONTH(created_at)', 'IN', "(" . implode(", ", array_column($month, 'month')) . ")")->get();
        $order_growth = array_map( function ($date) use($order_growth) {
            return [
                "month" => date_create($date["year"] . "-" . $date["month"] . "-01")->format('F'),
                "value" => count(array_filter($order_growth, function ($user) use($date) {
                    return $user["month"] == $date["month"];
                })),
            ];
        }, $month);

        echo json_encode(["status" => true, "data" => $order_growth]);
    }

    public function getCountryOrder() {
        $orderByCountry = DB::raw("SELECT user_detail.country as country_code, count(transactions.id) as total FROM transactions LEFT JOIN user_detail ON user_detail.id = transactions.address_id GROUP BY country_code")->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => true, "data" => $orderByCountry]);
    }
}

$body = file_get_contents('php://input');
$request = json_decode($body);

if (isset($request->method) || isset($_GET["method"])) {
    $Analytic = new AnalyticDomain($request);
}
