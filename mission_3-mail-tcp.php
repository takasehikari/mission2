<?php
try{
	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

	//新規テーブル作成
	$sql = 'CREATE TABLE mail (
	    mno INT(3) NOT NULL AUTO_INCREMENT,
		mail VARCHAR(50) NOT NULL,
		urltoken VARCHAR(128) NOT NULL,
		date DATETIME NOT NULL,
		flag TINYINT(1) NOT NULL DEFAULT 0,
		PRIMARY KEY(mno)

			);ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';

	$result=$PDO->query($sql);
}
catch(PDOException $e) {

	echo $e->getMessage();
	die();
}

$PDO = null;
?>
