<?php

function post(){

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://nextar.flip.id/disburse",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_SSL_VERIFYHOST => 0,
	  CURLOPT_SSL_VERIFYPEER => 0,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "bank_code=bni&account_number=1234567890&amount=10000&remark=sample%20remark",
	  CURLOPT_HTTPHEADER => array(
	    "Accept: */*",
	    "Authorization: Basic SHl6aW9ZN0xQNlpvTzduVFlLYkc4TzRJU2t5V25YMUp2QUVWQWh0V0tadW1vb0N6cXA0MTo=",
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
		
		$pdo = new PDO("mysql:dbname=flip;host=localhost", "root", "" );
		
		$sql = "INSERT INTO disburse (id, amount, status, timestamp, bank_code, account_number, beneficiary_name, remark, receipt, time_served, fee) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		$insert = $pdo->prepare($sql)->execute([$result->id,$result->amount,$result->status,$result->timestamp,$result->bank_code,$result->account_number,$result->beneficiary_name, $result->remark, $result->receipt, $result->time_served, $result->fee]);

		print_r($result->id. "Created");
		exit();
	}
}

post();

?>