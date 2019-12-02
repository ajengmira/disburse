<?php

function update(){

	//$transaction_id = 2147483647;
	$transaction_id = $_SERVER['argv'];

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://nextar.flip.id/disburse/".$transaction_id[1],
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_SSL_VERIFYHOST => 0,
	  CURLOPT_SSL_VERIFYPEER => 0,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "Accept: */*",
	    "Accept-Encoding: gzip, deflate",
	    "Authorization: Basic SHl6aW9ZN0xQNlpvTzduVFlLYkc4TzRJU2t5V25YMUp2QUVWQWh0V0tadW1vb0N6cXA0MTo=",
	    "Cache-Control: no-cache",
	    "Connection: keep-alive",
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
		
		$sql = "UPDATE disburse SET status=?, receipt=?, time_served=? WHERE id=?";
		$update = $pdo->prepare($sql)->execute([$result->status, $result->receipt, $result->time_served, $result->id]);

		print_r($result->id. " Updated");
		exit();
	}
}

update();

?>