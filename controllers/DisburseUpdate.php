<?php

    function index()
    {
        include_once("config/Core.php");
        include_once("libraries/Curl.php");
        include_once("models/Model.php");

        $curl = new Curl();
        $model = new Model();

        $transaction_id = $_SERVER['argv'];

        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic $secret_key",
        );

        $url = 'https://nextar.flip.id/disburse/'.$transaction_id[1];

        $result = $curl->http_get($url, $header);
        $result = json_decode($result);
        
        $msg = "Failed to updated";
        if(!empty($result)){
          if ($model->update($result)) {
              $detail = $model->detail($result->id);
              $msg = "Transaction ".$result->id. " has been updated. \n";              
              $msg .= json_encode($detail);
          } 
        }

        echo $msg;
        exit();
    }

    index();
