<?php

function post(){

	include("config.php");
	
	$args = $_SERVER['argv'];

	$bank_code 		= $args[1]; 
	$account_number	= $args[2];
	$amount			= $args[3];
	$remark			= $args[4];

	if (empty($bank_code) || empty($account_number) || empty($amount)) {
		print_r("Please input bank code, account number & amount");
		exit();
	}

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://nextar.flip.id/disburse",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 300,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_SSL_VERIFYHOST => 0,
	  CURLOPT_SSL_VERIFYPEER => 0,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "bank_code=$bank_code&account_number=$account_number&amount=$amount&remark=$remark",
	  CURLOPT_HTTPHEADER => array(
	    "Accept: */*",
	    "Authorization: Basic $token",
	    "Cache-Control: no-cache",
	    "Connection: keep-alive",
	    "Content-Length: 75",
	    "Content-Type: application/x-www-form-urlencoded",
	    "Host: nextar.flip.id"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  	echo "cURL Error #:" . $err;
	} else {
		$result = json_decode($response);
		
		$pdo = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass" );
		
		$sql = "INSERT INTO disburse (id, amount, status, timestamp, bank_code, account_number, beneficiary_name, remark, receipt, time_served, fee) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		$insert = $pdo->prepare($sql)->execute([$result->id,$result->amount,$result->status,$result->timestamp,$result->bank_code,$result->account_number,$result->beneficiary_name, $result->remark, $result->receipt, $result->time_served, $result->fee]);

		print_r($result->id. "Created");
		exit();
	}
}

post();

?>