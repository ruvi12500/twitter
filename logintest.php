<?php

//さっき変更した場合はこちらも変更する
//$salt = "mwefCMEP28DjwdW3lwdS239vVS";

//セッション開始
session_start();

$mysqli = new mysqli('localhost', 'takumi_asai', 'asataku', 'twitter');

$status = "none";

//セッションにセットされていたらログイン済み
if(isset($_SESSION["username"]))
  $status = "logged_in";
else if(!empty($_POST["username"]) && !empty($_POST["password"])){
  //ユーザ名、パスワードが一致する行を探す
  //$password = md5($_POST["password"] . $salt);
  $stmt = $mysqli->prepare("SELECT * FROM user WHERE MailAddress = ? AND PassWord = ?");
  $stmt->bind_param('ss', $_POST["username"], $_POST["password"]);
  $stmt->execute();

  //結果を保存
  $stmt->store_result();
  //結果の行数が1だったら成功
  if($stmt->num_rows == 1){
    $status = "ok";
    //セッションにユーザ名を保存
    $_SESSION["username"] = $_POST["username"];
  }else
    $status = "failed";
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>ログイン</title>
  </head>
  <body>
    <h1>ログイン</h1>
    <?php if($status == "logged_in"): ?>
      <p>ログイン済み</p>
    <?php elseif($status == "ok"): ?>
      <p>ログイン成功</p>
    <?php elseif($status == "failed"): ?>
      <p>ログイン失敗</p>
    <?php else: ?>
      <form method="POST" action="">
        ユーザ名：<input type="text" name="username" />
        パスワード：<input type="password" name="password" />
        <input type="submit" value="ログイン" />
      </form>
    <?php endif; ?>
  </body>
</html>