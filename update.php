<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	$mysqli = new mysqli('localhost', 'takumi_asai', 'asataku', 'twitter');


	//編集ボタン
if(isset($_POST["update"])){
	$update = $mysqli->prepare("update tweet set Tweet= ? WHERE ID = ?");
	$update->bind_param('si', $_POST["update"],$_GET["id"]);
	$update->execute();
	header('location:tweet.php');
	exit();	
}
?>
<form action="" method="POST">

<?php
/*
$stmt = $mysqli->prepare("SELECT * FROM tweet where ID = ?");
if ($stmt->execute($_GET["id"])) {
	while ($row = $stmt->fetch()) {
		echo $row["Tweet"];
	}
}

*/
?>
<input type="text" name="update">
<input type="submit">
<br>
<a href="tweet.php">戻る</a>
</form>
</body>
</html>