<?php
session_start();

require_once('DB.php');

class TransactionDomain
{
    public function __construct()
    {
        $req_action = $_POST["action"];
        $code = $_POST["code"];

        if ($req_action == "confirm") {
            $user = @$_SESSION["user"];

            if (@$user["role_id"] != 1) {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }

        switch ($req_action) {
            case 'confirm':
                DB::table('transactions')->where("code", "=", $code)->update(["status" => 3]);
                DB::table('transaction_details')->where("transaction_code", "=", $code)->update(["status" => 3]);
                $this->updateSpend();
                break;

            case 'cancel':
                $status_transaction = $this->getTransaction();

                if (!in_array($status_transaction, [3, 4])) {
                    DB::table('transactions')->where("code", "=", $code)->update(["status" => 4]);
                    DB::table('transaction_details')->where("transaction_code", "=", $code)->update(["status" => 4]);
                }
                break;

            case 'waiting':
                DB::table('transactions')->where("code", "=", $code)->update(["status" => 2]);
                DB::table('transaction_details')->where("transaction_code", "=", $code)->update(["status" => 2]);
                break;
            
            default:
                header("Location:" . $_SERVER['HTTP_REFERER']);
                break;
        }

        header("Location:" . $_SERVER['HTTP_REFERER']);
    }

    protected function updateSpend() {
        $code = $_POST["code"];
        $transaction = DB::table('transactions')->where('code', '=', $code)->get();
        $user_spend = DB::table('user_spend')->where('user_id', '=', $transaction[0]['user_id'])->get();

        if ($user_spend) {
            DB::table('user_spend')->where('id', '=', $user_spend[0]["id"])->update(["spend" => $user_spend[0]["spend"] + $transaction[0]["grand_total"]]);
        } else {
            DB::table('user_spend')->insert(["user_id" => $transaction[0]["user_id"], "spend" => $transaction[0]["grand_total"] - ($transaction[0]["tax"] + $transaction[0]["shipping_fee"])]);
        }
    }

    protected function getTransaction() {
        $code = $_POST["code"];
        $transaction = DB::table('transactions')->where('code', '=', $code)->get()[0];

        return $transaction["status"];
    }
}

$Transaction = new TransactionDomain();