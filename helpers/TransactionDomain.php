<?php
session_start();

require_once('DB.php');

class TransactionDomain
{
    public function __construct()
    {
        $req_action = $_POST["action"];
        $transaction_id = $_POST["id"];

        if ($req_action == "confirm") {
            $user = @$_SESSION["user"];

            if (@$user["role_id"] != 1) {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }

        switch ($req_action) {
            case 'confirm':
                DB::table('transactions')->where("id", "=", $transaction_id)->update(["transaction_status_id" => 3]);
                break;

            case 'cancel':
                $status_transaction = $this->getTransaction();

                if (!in_array($status_transaction, [3, 4])) {
                    DB::table('transactions')->where("id", "=", $transaction_id)->update(["transaction_status_id" => 4]);
                }
                break;

            case 'waiting':
                DB::table('transactions')->where("id", "=", $transaction_id)->update(["transaction_status_id" => 2]);
                break;
            
            default:
                header("Location:" . $_SERVER['HTTP_REFERER']);
                break;
        }

        header("Location:" . $_SERVER['HTTP_REFERER']);
    }

    protected function getTransaction() {
        $transaction_id = $_POST["id"];
        $transaction = DB::table('transactions')->find($transaction_id);

        return $transaction["transaction_status_id"];
    }
}

$Transaction = new TransactionDomain();