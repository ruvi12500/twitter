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
<input type="text" name="update">
<input type="submit">
</form>
</body>
</html>