<!DOCTYPE html>
<html>
<head>
	<title>Twitter</title>
</head>
<body>
<?php
//セッション開始
session_start();
//接続
$mysqli = new mysqli('localhost', 'takumi_asai', 'asataku', 'twitter');

$query = "SELECT * FROM tweet ORDER BY TweetDate desc;";

$today = date("Y-m-d H:i:s");	   // 2001-03-10 17:16:18 (MySQL の DATETIME フォーマット)

//ツイートボタン
if(isset($_POST["tweet"]) && isset($_POST["tweetnow"])){
	$insert = $mysqli->prepare("insert into tweet (Tweet,User,TweetDate,DeleteFlg) VALUE(?,?,?,0)");
	$insert->bind_param('sss', $_POST["tweet"],$_SESSION["mailaddress"],$today);
	$insert->execute();
}

//削除ボタン
if(isset($_POST["delete"]) && $_POST["ID"]){
	$delete = $mysqli->prepare("update tweet set DeleteFlg = 1 WHERE ID = ?");
	$delete->bind_param('i', $_POST["ID"]);
	$delete->execute();
}

//削除ボタン
if(isset($_GET["id"])){
	$delete = $mysqli->prepare("update tweet set DeleteFlg = 1 WHERE ID = ?");
	$delete->bind_param('i', $_GET["id"]);
	$delete->execute();
}

?>
<form action="" method="POST">
<input type="text" name="tweet">
<input type="submit" name='tweetnow' value="ツイート">

<h1>ツイート一覧</h1>
<table>
<?php
if ($result = $mysqli->query($query)) {
	while ($row = $result->fetch_assoc()) {
		if($row["DeleteFlg"] ==0){
			echo "<tr><td>";
			echo $row["Tweet"];
			echo $row["TweetDate"];
			echo "<input type='submit' name='delete' value='削除'>";
			echo "<input type='hidden' name='ID' value=".$row["ID"].">";
			echo "<a href='tweet.php?id=".$row["ID"]."'>削除</a>";
			echo "<a href='update.php?id=".$row["ID"]."'>編集</a>";
			echo "</td></tr>";


		}
	}
}
?>
</form>
</table>
<a href="history.php">履歴</a>
</body>
</html>	
