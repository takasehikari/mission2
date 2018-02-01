<?php
try{
	$PDO = new PDO('DB名', 'ユーザー名', 'パスワード');//接続

	//新規テーブル作成
	$sql = 'CREATE TABLE profile0215 (
	    no01 INT(3) AUTO_INCREMENT,
		name01 CHAR(20),
		like01 CHAR(30),
		datatime01 DATETIME,
		pass01 CHAR(20),
		fname TEXT CHARACTER SET utf8 COLLATE utf8_general_ci , 
		kakutyosi TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
		data LONGBLOB,
		PRIMARY KEY(no01)
        
			); ENGINE = InnoDB';

	$result=$PDO->query($sql);
}
catch(PDOException $e) {

	echo $e->getMessage();
	die();
}

$PDO = null;
?>

