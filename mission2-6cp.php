<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自己紹介入力</title>
</head>
<body>
<form action="mission2-6.php" method="post">
<h2>自己紹介入力</h2>
  名前：<br />
  <input type="text" name="name" size="30" value="" /><br />
  
  好きな食べ物：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  
  パスワード：<br />
  <input type="text" name="password" size="30" value="" /><br />
  <br />
  
  <input type="submit" value="送信する" name="sousin"/>
  
</form>
</body>
</html>

<?php
if (isset($_POST['sousin'])) {
$name = $_POST["name"];
$comment = $_POST["comment"];
$comment = str_replace("\r\n", '', $comment);//commentを一列にする
$password = $_POST["password"];


$filename = 'mission2-6.txt';
//echo $filename;

$fp = fopen( $filename, 'ab' );//2-6のテキストファイルを追記で開く
$file = file( $filename );//1列ずつ配列に格納
$count = count($file);//列を数える
$a = 1 + $count;

fwrite($fp, $a);
fwrite($fp, "<>");
fputs($fp, $name);
fwrite($fp, "<>");
fputs($fp, $comment);
fwrite($fp, "<>");
fputs($fp, $password);
fwrite($fp, "<>");
fwrite($fp, date("Y/m/d G:i")."\n");


fclose($fp);
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="mission2-6.php" method="post">

<h3>自己紹介　削除対象番号入力</h3>
  削除対象番号：<br />
  <input type="text" name="delete" size="30" value="" /><br /> 
  パスワード：<br />
  <input type="password" name="password1" size="30" value="" /><br /> 
  <input type="submit" value="削除する" name="sakuzyo"/>
</form>
</body>
</html>

<?php
if (isset($_POST['sakuzyo'])) {
$delete = $_POST["delete"];//削除番号を$deleteに格納
$password1 = $_POST["password1"];//削除番号を$passwordに格納
$filename = 'mission2-6.txt';//$filenameにテキストファイルを格納;
$dfile = file( $filename );//dfileにテキストファイルの配列を格納
$fp = fopen( $filename, 'w+' );//内容を消して開く

foreach($dfile as $line){
	$data = explode('<>', $line);//$dataに<>で区切った文字を格納
		if($data[0] != $delete){//消す番号ではない場合
		fputs($fp, $line);//上書き
		}
		else{
			if($data[3] == $password1){//消す番号かつパスワード一致の場合
			  fwrite($fp, ' '."<br />\n");//空白を上書き
			  }
			else{//消す番号かつパスワード不一致の場合
			  echo "削除番号またはパスワードが違います". "<br />\n";
			  fputs($fp, $line);//上書き
			  }
		}
}

fclose($fp);
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>
<form action="mission2-6.php" method="post">

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
if (isset($_POST['hensyu'])) {
$edit = $_POST["edit"];//編集番号を$editに格納
$password2 = $_POST["password2"];//削除番号を$passwordに格納
$filename = 'mission2-6.txt';//$filenameにテキストファイルを格納;
$hfile = file( $filename );//hfileにテキストファイルの配列を格納
$fp = fopen( $filename, 'w+' );//mission_2-6.phpの内容を削除して書き込む

foreach($hfile as $line_h){
	$data1 = explode('<>', $line_h);//<>で区切る

		if($data1[0] != $edit){//$data1[0]と$editが違ったら
			fputs($fp, $line_h);
		}

		else{//$data1[0]と$editが同じだったら

			if($data1[3] == $password2){//消す番号かつパスワード一致の場合
				echo "2.編集内容を入力してください". "<br />\n";
				$edit_num=$data1[0];
				$user=$data1[1]; 
				$text=$data1[2];
				$pass=$data1[3];
				fputs($fp, $line_h);
				
				echo "<form action=mission2-6.php method=post>";
				echo "<input name='edit_num' type='hidden' value='$edit_num' />";
				echo "<input name='user' type='text' value='$user' /> ";
				echo "<input name='text' type='text' value='$text' />"; 
				echo "<input name='pass' type='hidden' value='$pass' />";
				echo "<input type='submit' value='書き換える' name='hensyu0'/>";
				echo "</form>";
				
			 }
			else{//消す番号かつパスワード不一致の場合
				echo "＊削除番号またはパスワードが違います". "<br />\n";
				fputs($fp, $line_h);//上書き
			}

		}
}
fclose($fp);
}
?>

<?php
if (isset($_POST['hensyu0'])) {
$edit_num1 = $_POST["edit_num"];
$user1 = $_POST["user"];
$text1 = $_POST["text"];
$pass1 = $_POST["pass"];
$data1 = date("Y/m/d G:i"); 
$filename = 'mission2-6.txt';
$hhfile = file( $filename );//hhfileに格納
$fp = fopen( $filename, 'w+' );// 空にして開く

foreach($hhfile as $line_hh){//配列から1つずつ取り出す
$data2 = explode("<>", $line_hh);//<>で切って配列に 

if($data2[0] == $edit_num1){// 同じなら括弧 中処理
fwrite($fp, $edit_num1);
fwrite($fp, "<>");
fputs($fp, $user1);
fwrite($fp, "<>");
fputs($fp, $text1);
fwrite($fp, "<>");
fputs($fp, $pass1);
fwrite($fp, "<>");
fputs($fp, $data1."\n");
// 編集した1行をファイルに追記
} 
else{ // 一致しない時 元 データをそ まま書き込み 
fputs($fp, $line_hh);// 元 1行をファイルに追記
} 

}

fclose($fp); //ファイルを閉じる 
}
?>

<?php
$file = file('mission2-6.txt');
$file_a = explode("<>", $file);//<>で区切って格納

foreach ($file as $file_num => $file) {// 配列をループ

echo nl2br("\n"); 

$file_a = explode("<>", $file);
if(empty($file_a[1])){//空にした行があったら詰める

}
else{
    echo $file_a[0]. "<br />\n";
	echo $file_a[1]. "<br />\n";
	echo $file_a[2]. "<br />\n";
	echo $file_a[3]. "<br />\n";
	echo $file_a[4]. "<br />\n";
	echo nl2br("\n");
} 
}
?>