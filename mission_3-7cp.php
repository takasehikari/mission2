<?php
// セッション開始
session_start();

// ログインボタンが押された場合
if (isset($_POST["login"])) {
 
    if (isset($_POST["userid"]) && isset($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];
 		$password = $_POST["password"];
		 
        // ユーザIDとパスワードが入力されていたら認証する
        try {
            $PDO = new PDO('DB名', 'ユーザー名', 'パスワード');//接続

            $stmt = $PDO->prepare('SELECT * FROM newuser WHERE newno = ?');
            $stmt->execute(array($userid));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($password === $row['newpass'] ) {
				
				//password_verify($password, $row['newpass'])上のメモ
				
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id = $row['newno'];
                    $sql = "SELECT * FROM newuser WHERE newno = $id";  //入力したIDからユーザー名を取得
                    $stmt = $PDO->query($sql);
                    foreach ($stmt as $ro) {
					    $tid = $ro['newno'];
                        $tname=$ro['newname'];  // ユーザー名
						$tpass = $ro['newpass'];
                    }
                    $_SESSION["NAME"] = $tname;
					$_SESSION["ID"] = $tid;
					$_SESSION["PASS"] = $tpass;
					
                    header("Location: mission_3.php");   //メイン画面へ遷移
					//header("Content-type: text/html; charset=utf-8");
 
//echo "<p>サーバ/セッションIDは " . session_id() ." です。</p>";
//echo "<p>クッキー/セッションIDは " .$_COOKIE['PHPSESSID'] ." です。</p>";
//echo "<p>".$_SESSION['NAME'] ."さん、こんにちは</p>";
                    exit();  // 処理終了
                } 
				else {
                
              		echo "ユーザーIDまたはパスワードに誤りがあります!";
            }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
              		echo "ユーザーIDまたはパスワードに誤りがあります!";
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>

<html>
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>ログイン</title>
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form action="mission_3-7.php" method="POST"> 
		
		<?php
		
	if(empty($_SESSION["ID"]) || isset($_POST["logout"])){
		$_SESSION["ID"] = null;
		$_SESSION["PASS"] = null;
		}
		?>
				
			
                ユーザーID:<br />
				<input type="text" name="userid" size="30" value='<?php echo $_SESSION["ID"]; ?>' />
                <br />
				<?php
					if (isset($_POST['login'])) {
						if(empty($_POST["userid"])){
							echo "IDが未入力です！". "<br />\n";
							}
						}
				?>

                パスワード:<br />
				<input type="password" name="password" size="30" value='<?php echo $_SESSION["PASS"]; ?>'/>
                <br />
				<?php
					if (isset($_POST['login'])) {
						if($_POST["password"] == ''){
							echo "パスワードが未入力です！". "<br />\n";
							}
						}
				?>

                <input type="submit" name="login" value="ログイン" />
				<br />
		</form>
		<form action="mission_3-mail-in.php" method="POST"> 
				ユーザーIDをお持ちでない場合↓<br />
				<input type="submit" name="in" value="新規登録する" />
			
				
        </form>
    </body>
</html>