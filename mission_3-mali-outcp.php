<?php
if (isset($_POST['sousin'])) {
session_start();
header("Content-type: text/html; charset=utf-8");
	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続
			//値を変数に格納
		//$mno = NULL;
		//$mail = $_POST["mail"];
		
	$errors = array();
	$mail = $_POST['mail'];

 //メール入力判定
if(empty($_POST['mail'])) {
	$errors['mail'] = "メールが入力されていません。";
	}
else if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			$errors['mail_check'] = "メールアドレスの形式が正しくありません。";
	}
 
if (count($errors) === 0){
	
	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "http://co-767.it.99sv-coco.com/mission_3-mail-in2.php"."?urltoken=".$urltoken;
	
	//ここでデータベースに登録する
	try{
		//例外処理を投げる（スロー）ようにする
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$statement = $PDO->prepare("INSERT INTO mail (mail,urltoken,date) VALUES (:mail,:urltoken,now() )");
		
		//プレースホルダへ実際の値を設定する
		$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
		$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
		$statement->execute();
			
		//データベース接続切断
		$PDO = null;	
		
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	
	//メールの宛先
	$mailTo = $mail;
 
	//Return-Pathに指定するメールアドレス
	$returnMail = 'r201504171ul@jindai.jp';
 
	$name = "おすすめグルメ";
	$mail = 'r201504171ul@jindai.jp';
	$subject = "会員登録用URLのお知らせ";
 
$body = <<< EOM
下記のURLからご登録下さい。
{$url}
EOM;
 
	mb_language('ja');
	mb_internal_encoding('UTF-8');
 
	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';
 
	if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {
	
	 	//セッション変数を全て解除
		$_SESSION = array();
	
		//クッキーの削除
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time() - 1800, '/');
		}
	
 		//セッションを破棄する
 		session_destroy();
 	
 		$message = "メールをお送りしました。メールに記載されたURLからご登録下さい。";
 	
	 } else {
		$errors['mail_error'] = "メールの送信に失敗しました。";
	}	
}
} 
?>

<html>
<head>
<title>メール確認画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>メール確認画面</h1>
 
<?php if (count($errors) === 0): ?>
 
<p><?=$message?></p>
 
<p>↓このURLが記載されたメールが届きます。</p>
<a href="<?=$url?>"><?=$url?></a>
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<input type="button" value="戻る" onClick="history.back()">
 
<?php endif; ?>
 
</body>
</html> 
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php 
/*start	if(!empty($password) && !empty($name)){	
		//echo $password;
		//echo $name;
		$sql = $PDO -> prepare("INSERT INTO newuser (newno, newname, newpass) VALUES (:newno, :newname, :newpass)");//入力場所を作る
		//データ入力
		$sql->bindValue(':newno', $no, PDO::PARAM_INT);
		$sql->bindParam(':newname', $name, PDO::PARAM_STR);
		$sql->bindParam(':newpass', $password, PDO::PARAM_STR);
    	$sql->execute();
	
		$_SESSION['NAME'] = $name;
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//文字化け対策
		echo "登録が完了しました。"."<br>";

			
		$stmt='SELECT * FROM newuser ORDER BY newno desc limit 1'; //クエリ 
		$result= $PDO -> query($stmt); //実行・結果取得 

		foreach($result as $row){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//文字化け対策
			//表示
			echo "[ID]".$row['newno'].'<br>';
			echo "[名前]".$row['newname'].'<br>';
			echo "[パスワード]".$row['newpass'].'<br>';
			}
		
		$hoge='mission_3-7.php';
		print '<input type="button" value="ログインページに移行" onClick="location.href=\''.$hoge.'\'">';
	}
	else{
	if(empty($_POST["name"])){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//文字化け対策
	echo "名前が未入力です！"."<br>";
	}
	if(empty($_POST["password"])){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//文字化け対策
	echo "パスワードが未入力です！"."<br>";
	}
	$re='mission_3-in.php';
	print '<input type="button" value="戻る" onClick="location.href=\''.$re.'\'">';
	 } 
}
*/
?>