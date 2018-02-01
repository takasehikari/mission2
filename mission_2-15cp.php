<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>自己紹介入力</title>
</head>
<body>
  <form action="mission_2-15.php" method="post">
  　<h2>自己紹介入力</h2>
  　名前：<br />
  　<input type="text" name="name" size="30" value="" /><br />  
  　嫌いな食べ物：<br />
  　<textarea name="comment" cols="30" rows="5"></textarea><br />
  　パスワード：<br />
  　<input type="text" name="password" size="30" value="" /><br /> 
  　<input type="submit" value="送信する" name="sousin"/>  
　</form>
</body>
</html>

<html>
<head>
　<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
　<form action="mission_2-15.php" method="post">
　　<h3>自己紹介　削除対象番号入力</h3>
  　削除対象番号：<br />
  　<input type="text" name="delete" size="30" value="" /><br /> 
    パスワード：<br />
    <input type="password" name="password1" size="30" value="" /><br /> 
  　<input type="submit" value="削除する" name="sakuzyo"/>
　</form>
</body>
</html>

<html>
<head>
　<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
　<form action="mission_2-15.php" method="post">
　　<h3>自己紹介　編集対象番号入力</h3>
　　1.編集したい番号を入力してください<br />
  　編集対象番号：<br />
  　<input type="text" name="edit" size="30" value="" /><br /> 
  　パスワード：<br />
  　<input type="password" name="password2" size="30" value="" /><br /> 
  　<input type="submit" value="編集する" name="hensyu"/>
　</form>
</body>
</html>


<?php
if (isset($_POST['sousin'])) {

	//値を変数に格納
	$PDO = new PDO('DB名', 'ユーザー名', 'パスワード');//接続
	$sql = $PDO -> prepare("INSERT INTO profile0215 (no01, name01, like01, datatime01, pass01) VALUES (:no01, :name01, :like01, :datatime01, :pass01)");//入力場所を作る

	//値を変数に格納
	$no = NULL;
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$comment = str_replace("\r\n", '', $comment);//commentを一列にする
	$datatime=date("Y/m/d G:i"); 
	$password = $_POST["password"];

		if (!$PDO) {//接続エラーチェック
			    die('接続失敗です。'.mysql_error());
		}

	//データ入力
	$sql->bindValue(':no01', $no, PDO::PARAM_INT);
	$sql->bindParam(':name01', $name, PDO::PARAM_STR);
	$sql->bindParam(':like01', $comment, PDO::PARAM_STR);
	$sql->bindValue(':datatime01', $datatime, PDO::PARAM_INT);
	$sql->bindParam(':pass01', $password, PDO::PARAM_STR);
    $sql->execute();

}
?>


<?php
if (isset($_POST['sakuzyo'])) {

	$delete=$_POST["delete"];//削除値を$deleteに格納
	$password1=$_POST["password1"];
	$PDO = new PDO('DB名', 'ユーザー名', 'パスワード');//接続

		if (!$PDO) {//接続エラーチェック
			    die('接続失敗です。'.mysql_error());
		}
		
	$dsql='SELECT * FROM profile0215 ORDER BY no01'; //クエリ 
	$dresult= $PDO -> query($dsql); //実行・結果取得 

	foreach ($dresult as $drow) {//dresultをdrow格納して一列ずつ取り出す	
		if($drow['no01']==$delete){//no01と削除番号があっており、かつpass1とパスワードがあっていたら
		if($drow['pass01']==$password1){
			$stmt = "DELETE  FROM profile0215 WHERE no01 = :no01";//delete文を変数に格納
			$ddresult = $PDO->prepare($stmt);//データを取得
			$dparams = array(':no01' => $delete);//削除番号を指定
			$ddresult->execute($dparams);//SQL実行
			}
		else{//どちらかが違っていたら
			echo "削除番号またはパスワードが違います!". "<br />\n";
			}
			}
		}		
}
?>


<?php
if (isset($_POST['hensyu'])) {
	$edit = $_POST["edit"];//編集番号を$editに格納
	$password2 = $_POST["password2"];//削除番号を$password2に格納
	$PDO = new PDO('DB名', 'ユーザー名', 'パスワード');//接続

		if (!$PDO) {//接続エラーチェック
			    die('接続失敗です。'.mysql_error());
		}
		

	$hsql='SELECT * FROM profile0215 ORDER BY no01'; //クエリ 
	$hresult= $PDO -> query($hsql); //実行・結果取得 

	foreach ($hresult as $hrow) {//hresultをhrow格納して一列ずつ取り出す
	//echo $hrow['no01'];

		if($hrow['no01']==$edit){//no01と編集番号があってたら
			if($hrow['pass01']===$password2){//pass1とパスワードがあっていたら
			//echo $hrow['pass01'];
					echo "2.編集内容を入力してください". "<br />\n";
					$edit_num=$hrow['no01'];
					$user=$hrow['name01']; 
					$text=$hrow['like01'];
					$pass=$hrow['pass01'];
							
					echo "<form action=mission_2-15.php method=post>";
					echo "<input name='edit_num' type='hidden' value='$edit_num' />";
					echo "<input name='user' type='text' value='$user' /> ";
					echo "<input name='text' type='text' value='$text' />"; 
					echo "<input name='pass' type='hidden' value='$pass' />";
					echo "<input type='submit' value='書き換える' name='hensyu0'/>";
					echo "</form>";
				}
			else{//パスワードが違っていたら
					echo "編集番号またはパスワードが違います!". "<br />\n";
				}
			}
		}			
}
?>

<?php
if (isset($_POST['hensyu0'])) {
	$edit_num1 = $_POST["edit_num"];
	$user1 = $_POST["user"];
	$text1 = $_POST["text"];
	$pass1 = $_POST["pass"];
	$data1 = date("Y/m/d G:i"); 

	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

		if (!$PDO) {//接続エラーチェック
			    die('接続失敗です。'.mysql_error());
		}
		
	$hhsql='SELECT * FROM profile0215 ORDER BY no01'; //クエリ 
	$hhresult= $PDO -> query($hhsql); //実行・結果取得 

	foreach ($hhresult as $hhrow) {//hhresultをhhrow格納して一列ずつ取り出す	
	
		if($hhrow['no01']==$edit_num1){//no01と編集番号があっていたら
		
			$stmt = "UPDATE profile0215 SET name01 = :name01, like01 = :like01 WHERE no01 = :no01";//update文を変数に格納
			$result = $PDO->prepare($stmt);//データを取得
			$params = array(':name01' => $user1, ':like01' => $text1, ':no01' => $edit_num1);//変更内容と変更対象番号を入力
			$result->execute($params);//SQL実行			
			}
		}
}
?>
	



<?php
$PDO = new PDO('DB名', 'ユーザー名', 'パスワード');//接続

$stmt='SELECT * FROM profile0215 ORDER BY no01'; //クエリ 
$result= $PDO -> query($stmt); //実行・結果取得 

foreach ($result as $row) {	
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//文字化け対策
		//表示
		echo $row['no01'].', ';
		echo $row['name01'].', ';
		echo $row['like01'].', ';
		echo $row['datatime01'].', ';
		echo $row['pass01'].'<br>';
} 
?>
