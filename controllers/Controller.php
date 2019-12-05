<?php

class Controller
{
    public $curl;
    public $model;
  
    public function __construct()
    {
        
    }

    public function list_data()
    {
        include("models/Model.php");

        $model = new Model();

        $list = $model->lists();

        if (!empty($list)) {
            http_response_code(200);
            echo json_encode($list, JSON_PRETTY_PRINT);
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Empty datas."), JSON_PRETTY_PRINT);
        }
    }

    public function create()
    {
        include("config/Core.php");
        include("libraries/Curl.php");
        include("models/Model.php");

        $curl = new Curl();
        $model = new Model();

        if (empty($_GET['bank_code']) || empty($_GET['account_number']) || empty($_GET['amount']) || empty($_GET['remark'])) {
            echo "Please input bank code, account number, amount & remark.";
            exit();
        }

        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic $secret_key",
        );

        $url = 'https://nextar.flip.id/disburse';

        $param = [
          "bank_code" => $_GET['bank_code'],
          "account_number" => $_GET['account_number'],
          "amount" => $_GET['amount'],
          "remark" => $_GET['remark'],
        ];

        $result = $curl->http_post($param, $url, $header);
        $result = json_decode($result);

        if (!empty($result)) {
            if ($model->insert($result)) {
                http_response_code(200);
                $detail = $model->detail($result->id);
                echo json_encode($detail, JSON_PRETTY_PRINT);
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Failed created."), JSON_PRETTY_PRINT);
            }
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Failed."), JSON_PRETTY_PRINT);
        }
    }

    public function update()
    {
        include("config/Core.php");
        include("libraries/Curl.php");
        include("models/Model.php");

        $curl = new Curl();
        $model = new Model();

        $transaction_id = $_GET['transaction_id'];

        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic $secret_key",
        );

        $url = 'https://nextar.flip.id/disburse/'.$transaction_id;

        $result = $curl->http_get($url, $header);
        $result = json_decode($result);
        
        if (!empty($result)) {
            if ($model->update($result)) {
                http_response_code(200);

                $detail = $model->detail($result->id);
                echo json_encode($detail, JSON_PRETTY_PRINT);
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Failed updated."), JSON_PRETTY_PRINT);
            }
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Failed."), JSON_PRETTY_PRINT);
        }
    }
}
