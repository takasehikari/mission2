<?php
try{
	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

	//新規テーブル作成
	$sql = 'CREATE TABLE newuser (
	    newno INT(3) NOT NULL AUTO_INCREMENT,
		newname CHAR(20) NOT NULL,
		newpass CHAR(20) NOT NULL,
		mail CHAR(50) NOT NULL,
		flag TINYINT(1) NOT NULL DEFAULT 1,
		PRIMARY KEY(newno)

			);ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';

	$result=$PDO->query($sql);
}
catch(PDOException $e) {

	echo $e->getMessage();
	die();
}

$PDO = null;
?>
