<?php

 
    function index()
    {
        include_once("config/Core.php");
        include_once("libraries/Curl.php");
        include_once("models/Model.php");

        $curl = new Curl();
        $model = new Model();

        $args = $_SERVER['argv'];

        if (empty($args)) {
            echo "Please input bank code, account number, amount & remark.";
            exit();
        }

        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic $secret_key",
        );

        $url = 'https://nextar.flip.id/disburse';

        $param = [
          "bank_code" => $args[1],
          "account_number" => $args[2],
          "amount" => $args[3],
          "remark" => $args[4],
        ];

        $result = $curl->http_post($param, $url, $header);
        $result = json_decode($result);

        $msg = "Failed to created";
        if(!empty($result)){
          if ($model->insert($result)) {
              $detail = $model->detail($result->id);
              $msg = "Transaction ".$result->id. " has been created. \n";
              $msg .= json_encode($detail);
          } 
        }

        echo $msg;
        exit();
    }

    index();