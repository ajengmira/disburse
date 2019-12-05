<?php

class Model
{
    public function lists()
    {
        include("config/Database.php");

        $pdo = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass");

        $stmt = $pdo->prepare("SELECT * FROM disburse"); 
        $stmt->execute(); 
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $list;
    }

    public function detail($transaction_id)
    {
        include("config/Database.php");

        $pdo = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass");

        $query = $pdo->prepare('SELECT * FROM disburse WHERE transaction_id = :transaction_id');
        if (!$query) return false;
        if (!$query->execute(array(':transaction_id' => $transaction_id))) return false;
        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function insert($result)
    {
        include("config/Database.php");

        $pdo = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass");

    	$created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO disburse (transaction_id, amount, status, timestamp, bank_code, account_number, beneficiary_name, remark, receipt, time_served, fee, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $insert = $pdo->prepare($sql)->execute([$result->id, $result->amount, $result->status, $result->timestamp, $result->bank_code, $result->account_number, $result->beneficiary_name, $result->remark, $result->receipt, $result->time_served, $result->fee, $created_at]);

        return $insert;
    }

    public function update($result)
    {
        include("config/Database.php");

        $pdo = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass");

        $sql = "UPDATE disburse SET status=?, receipt=?, time_served=? WHERE transaction_id=?";
        $update = $pdo->prepare($sql)->execute([$result->status, $result->receipt, $result->time_served, $result->id]);
        
        return $update;
    }
}
