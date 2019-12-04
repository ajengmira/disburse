# Disburse Service

A simple disburse service.

## Quick Run Project
1. First clone https://github.com/ajengmira/disburse or copy source on folder htdocs xampp/wamp then go to disburse folder.
2. Open config.php, setting your username & password host your database.  
3. Open terminal or command promt
4. cd to disburse folder
5. For migrate db, execute 
php migration.php
6. To post data : 
* php disburse_post.php [bank_code] [account_number] [amount] [remark]
* example : 
* php disburse_post.php bni 1234567890 10000 sample%20remark
7. To update data :
* php disburse_update.php [transaction_id]
* example :
* php disburse_update.php 2147483647
```
