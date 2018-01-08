 <?php 
 session_start(); 
 //ログアウト
 echo "<input type='submit' value='ログアウト' name='logout'/>";
 echo "</form>";
 ?>
 
<!--投稿-->
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>オススメグルメ</title>
</head>
<body>
  <form action="mission_3.php" enctype="multipart/form-data" method="post">
  <p>ようこそ！<?=htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>さん</p>
  　<h2>投稿</h2>
  オススメの食べ物やコンビニスイーツ、お菓子などを投稿してください!<br />
  　名前：<br />
  　<input type="text" name="name" size="30" value='<?php echo $_SESSION["NAME"]; ?>' /><br />  
  	<?php
		if (isset($_POST['sousin'])) {
			if(empty($_POST["name"])){
				echo "ユーザー名が未入力です！". "<br />\n";
				}
			}
	?>
  　本文：<br />
  　<textarea name="comment" cols="30" rows="5"></textarea><br />
  　画像/動画:<br /> 
    <input type="file" name="upfile"><br /> 
	パスワード：<br />
  　<input type="password" name="password" size="30" value="" /><br /> 
 	 <?php
		if (isset($_POST['sousin'])) {
			if(empty($_POST["password"])){
				echo "パスワードが未入力です！". "<br />\n";
				}
			}
	?>
  　<input type="submit" value="送信する" name="sousin"/>  
　</form>
</body>
</html>

<!--削除-->
<html>
<head>
　<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
　<form action="mission_3.php" method="post">
　　<h3>削除対象番号入力</h3>
  　削除対象番号：<br />
  　<input type="text" name="delete" size="30" value="" /><br /> 
  <?php
		if (isset($_POST['sakuzyo'])) {
			if(empty($_POST["delete"])){
				echo "削除対象番号が未入力です！". "<br />\n";
				}
			}
	?>
    パスワード：<br />
    <input type="password" name="password1" size="30" value="" /><br /> 
	<?php
		if (isset($_POST['sakuzyo'])) {
			if(empty($_POST["password1"])){
				echo "パスワードが未入力です！". "<br />\n";
				}
			}
	?>
  　<input type="submit" value="削除する" name="sakuzyo"/>
　</form>
</body>
</html>

<!--編集-->
<html>
<head>
　<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
　<form action="mission_3.php" method="post">
　　<h3>編集対象番号入力</h3>
　　1.編集したい番号を入力してください<br />
  　編集対象番号：<br />
  　<input type="text" name="edit" size="30" value="" /><br /> 
  <?php
		if (isset($_POST['hensyu'])) {
			if(empty($_POST["edit"])){
				echo "編集対象番号が未入力です！". "<br />\n";
				}
			}
	?>
  　パスワード：<br />
  　<input type="password" name="password2" size="30" value="" /><br /> 
  	<?php
		if (isset($_POST['hensyu'])) {
			if(empty($_POST["password2"])){
				echo "パスワードが未入力です！". "<br />\n";
				}
			}
	?>
  　<input type="submit" value="編集する" name="hensyu"/>
　</form>
</body>
</html>


<?php
if (isset($_POST['sousin'])) {

if(!empty($_POST["password"]) && !empty($_POST["name"])){

	//値を変数に格納
	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続
	$sql = $PDO -> prepare("INSERT INTO profile0215 (no01, name01, like01, datatime01, pass01, fname, kakutyosi, data) VALUES (:no01, :name01, :like01, :datatime01, :pass01, :fname, :kakutyosi, :data)");//入力場所を作る


	if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
            //エラーチェック
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK: // OK
				echo "ok!";
                    break;
                case UPLOAD_ERR_NO_FILE:   // 未選択
                    throw new RuntimeException('ファイルが選択されていません', 400);
					echo "1!";
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                    throw new RuntimeException('ファイルサイズが大きすぎます', 400);
					echo "2!";
                default:
                    throw new RuntimeException('その他のエラーが発生しました', 500);
					echo "3!";
            }
		}


	//値を変数に格納
	$no = NULL;
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$comment = str_replace("\r\n", '', $comment);//commentを一列にする
	$datatime=date("Y/m/d G:i:s"); 
	$password = $_POST["password"];
	echo "a";

if($_FILES["upfile"]["name"] != ""){
	$upfile = $_FILES["upfile"];
		$fname = $_FILES['upfile']['tmp_name'].$datatime;
	//echo $fname;
	$img = file_get_contents($_FILES['upfile']['tmp_name']);//$upfileを取得
	$tmp = pathinfo($_FILES["upfile"]["name"]);
    $extension = $tmp["extension"];
	//$extension = pathinfo($upfile, PATHINFO_EXTENSION);$upfileの拡張子を取得

	if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
                $extension = "jpeg";
            }
            elseif($extension === "png" || $extension === "PNG"){
                $extension = "png";
            }
            elseif($extension === "gif" || $extension === "GIF"){
                $extension = "gif";
            }
            elseif($extension === "mp4" || $extension === "MP4"){
                $extension = "mp4";
				echo "mp4";
            }
            else{
                echo "非対応ファイルです．<br/>";
				exit();  // 処理終了
            }
		}

	//データ入力
	echo "q";
	$sql->bindValue(':no01', $no, PDO::PARAM_INT);
	$sql->bindParam(':name01', $name, PDO::PARAM_STR);
	$sql->bindParam(':like01', $comment, PDO::PARAM_STR);
	$sql->bindValue(':datatime01', $datatime, PDO::PARAM_INT);
	$sql->bindParam(':pass01', $password, PDO::PARAM_STR);
	$sql->bindValue(':fname', $fname, PDO::PARAM_STR);
	$sql->bindValue(':kakutyosi', $extension, PDO::PARAM_STR);
    $sql->bindValue(':data', $img, PDO::PARAM_STR);
    $sql->execute();

}
}
?>


<?php
if (isset($_POST['sakuzyo'])) {

	$delete=$_POST["delete"];//削除値を$deleteに格納
	$password1=$_POST["password1"];
	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

		if (!$PDO) {//接続エラーチェック
			    die('接続失敗です。'.mysql_error());
		}
		
	$dsql='SELECT * FROM profile0215 ORDER BY no01'; //クエリ 
	$dresult= $PDO -> query($dsql); //実行・結果取得 

	foreach ($dresult as $drow) {//dresultをdrow格納して一列ずつ取り出す	
		if($drow['no01']==$delete){//no01と削除番号があっており、かつpass1とパスワードがあっていたら
		if($drow['pass01']===$password1){
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
	$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

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
$PDO = new PDO('mysql:dbname=co_767_it_3919_com;host=localhost;charset=utf8mb4', 'co-767.it.3919.c', 'Mnu9BUd');//接続

//表示
$stmt='SELECT * FROM profile0215 ORDER BY no01'; //クエリ 
$result= $PDO -> query($stmt); //実行・結果取得 

foreach ($result as $row) {	
		//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//文字化け対策
		//echo "<form action='mission_3.php' enctype='multipart/form-data' method='post'>";
		//$img = $stmt->fetchObject();
		//表示
		echo $row['no01'].', ';
		echo $row['name01'].', ';
		echo $row['datatime01'].'<br>';
		echo $row['like01'].'<br>';
	    
		$target = $row['fname'];
		if($row["kakutyosi"] == "mp4"){
            echo ("<video src='import_media.php?target=$target' width='426' height='240' controls></video>");
			echo "<br />\n";
        }
        elseif($row["kakutyosi"] == "jpeg" || $row["kakutyosi"] == "png" || $row["kakutyosi"] == "gif"){
            echo ("<img src='import_media.php?target=$target' width='135' height='193'>");
			echo "<br />\n";
        }		
		//echo $row['pass01'].'<br>';
} 
?>
