<?php
session_start(); 
$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

header("Content-type: text/html; charset=utf-8");

//GETデータを変数に入れる
	$urltoken = isset($_GET[urltoken]) ? $_GET[urltoken] : NULL;
	//メール入力判定
	if ($urltoken == ''){
		$errors['urltoken'] = "もう一度登録をやりなおして下さい。";
	}else{
		try{
			//例外処理を投げる（スロー）ようにする
			$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//flagが0の未登録者・仮登録日から24時間以内
			$statement = $PDO->prepare("SELECT mail FROM mail WHERE urltoken=(:urltoken) AND flag =0 ");
			$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$statement->execute();
			
			//レコード件数取得
			$row_count = $statement->rowCount();
			
			//24時間以内に仮登録され、本登録されていないトークンの場合
			if( $row_count ==1){
				$mail_array = $statement->fetch();
				$mail = $mail_array[mail];
				$_SESSION['mail'] = $mail;
			}
			/*else{
				$errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
			}*/
			
			//データベース接続切断
			$PDO = null;
			
		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}



?>

<html>
<head>
<title>会員登録画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>会員登録画面</h1>
 
<?php //if (count($errors) === 0): 
?>
 
<form action="mission_3-check.php" method="post">
 
<p>メールアドレス：<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></p>
<p>ユーザー名：<input type="text" name="user"></p>
<p>パスワード：<input type="password" name="password"></p>
 
<input type="submit" value="確認する" name="touroku">
 
</form>
 
<?php /*elseif(count($errors) > 0): ?> 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}*/
?>
<?php //endif; 
?>

 
</body>
</html>