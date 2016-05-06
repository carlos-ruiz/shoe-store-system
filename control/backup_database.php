<?php
	exec('C:\xampp\mysql\bin\mysqldump --user=root --password= --host=127.0.0.1 --databases controlbom > '.dirname(__FILE__).DIRECTORY_SEPARATOR.'assets/database_backups/db_'.date('Y-m-d').'.sql');
	