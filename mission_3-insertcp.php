<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続
 
//エラーメッセージの初期化
$errors = array();
 
if(isset($_POST['ttouroku'])) {
$mail = $_SESSION['mail'];
$account = $_SESSION['account'];
$password = $_SESSION['password'];
 
//パスワードのハッシュ化
//$password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);
 
//ここでデータベースに登録する
try{
	//例外処理を投げる（スロー）ようにする
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//トランザクション開始
	$PDO->beginTransaction();
	
	//memberテーブルに本登録する
	$statement = $PDO->prepare("INSERT INTO newuser (newname,newpass,mail) VALUES (:newname,:newpass,:mail)");
	//プレースホルダへ実際の値を設定する
	//$statement->bindValue(':newno', $no, PDO::PARAM_INT);
	$statement->bindValue(':newname', $account, PDO::PARAM_STR);
	$statement->bindValue(':newpass', $password, PDO::PARAM_STR);
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->execute();
		
	//pre_memberのflagを1にする
	$statement = $PDO->prepare("UPDATE mail SET flag=1 WHERE mail=(:mail)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->execute();
	
	// トランザクション完了（コミット）
	$PDO->commit();
	
	$stmt='SELECT * FROM newuser ORDER BY newno desc limit 1'; //クエリ 
		$result= $PDO -> query($stmt); //実行・結果取得 

		foreach($result as $row){
			echo "<meta charset='utf-8'>";//文字化け対策
			//表示
			echo "[ID]".$row['newno'].'<br>';
			echo "[名前]".$row['newname'].'<br>';
			echo "[パスワード]".$row['newpass'].'<br>';
			}
		
	//データベース接続切断
	$PDO = null;
	
	//セッション変数を全て解除
	$_SESSION = array();
	
	//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
	if (isset($_COOKIE["PHPSESSID"])) {
    		setcookie("PHPSESSID", '', time() - 1800, '/');
	}
	
 	//セッションを破棄する
 	session_destroy();
 	
 	/*
 	登録完了のメールを送信
 	*/
	
}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$PDO->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
}
} 
?>
 
<html>
<head>
<title>会員登録完了画面</title>
<meta charset="utf-8">
</head>
<body>
 
<?php if (count($errors) === 0): ?>

 
<p>登録完了いたしました！<br />
IDは今後のログインで必要になるので必ず控えておいてください。
<p><a href="http://co-767.it.99sv-coco.com/mission_3-7.php">ログイン画面</a></p>
 
 
 
 
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<?php endif; ?>
 
</body>
</html>