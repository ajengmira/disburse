# Disburse Service

A simple disburse service.

## Quick Run Project
1. First clone https://github.com/ajengmira/disburse or copy source on folder htdocs xampp/wamp then go to disburse folder.
2. Open config/Database.php, setting your username & password host your database.  
3. Open config/Core.php to setting your secret_key.
4. Open terminal or command promt
5. cd to disburse folder
6. For migrate db, execute 
	php migration.php

## Execute via terminal
1. To post data : 
	> php controllers/DisburseCreate.php [bank_code] [account_number] [amount] [remark]
	* example 
	> php controllers/DisburseCreate.php bni 1234567890 10000 sample%20remark
2. To update data :
	> php controllers/DisburseUpdate.php [transaction_id]
	* example :
	> php controllers/DisburseUpdate.php 2147483647

## Execute via browser or Postman
1. Get List : 
	http://localhost/disburse/?flip=list
2. Create Transaction :	
	http://localhost/disburse/?flip=create&bank_code=bni&account_number=1234567890&amount=10000&remark=sample remark
3. Update Transaction :	
	http://localhost/disburse/?flip=update&transaction_id=262136255
```
