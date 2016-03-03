<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
	<title>Twitter Login</title>
</head>
<body>
<?php

//セッション開始
session_start();

//接続
$mysqli = new mysqli('localhost', 'takumi_asai', 'asataku', 'twitter');
$status = "none";

if(isset($_SESSION["mailaddress"])){
  $status = "logged_in";
}else if(!empty($_POST["mailaddress"]) && !empty($_POST["password"])){

	//プリペアドステートメント
	$stmt = $mysqli->prepare("SELECT * FROM user WHERE MailAddress = ? AND PassWord = ?");
	$stmt->bind_param('ss', $_POST["mailaddress"], $_POST["password"]);
	$stmt->execute();

	//結果を保存
	$stmt->store_result();
	//結果の行数が1だったら成功
	if($stmt->num_rows == 1){
		$status = "login";
		//セッションにメールアドレスを保存
		$_SESSION["mailaddress"] = $_POST["mailaddress"];
	}else{
		$status = "failed";
	}
}


?>
<h1>ログインページ</h1>
    <?php if($status == "logged_in"){ ?>
    	<p>ログイン済みです。</p>
    <?php 
		}else if($status == "login"){
	    	header('location:tweet.php');
			exit();	
    	}elseif($status == "failed"){ ?>
    		<p>メールアドレスもしくはパスワードが違います。</p>
    <?php 
    	}else{ 
    ?>
		<form action="" method="POST">

		MAILADDRESS:<input type="text" name="mailaddress"><br>
		PASSWORD:<input type="password" name="password"><br>
		<input type="submit" value="ログイン">

	</form>
    <?php 
    	}
    ?>
</body>
</html>
