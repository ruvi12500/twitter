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

$query = "SELECT * FROM tweet";

//ツイートボタン
if(isset($_POST["tweet"])){
	$insert = $mysqli->prepare("insert into tweet VALUE(?,?,0)");
	$insert->bind_param('ss', $_POST["tweet"], $_SESSION["mailaddress"]);
	$insert->execute();
}

?>
<form action="" method="POST">
<input type="text" name="tweet">
<input type="submit" value="ツイート">
</form>
<h2>ツイート一覧</h2>
<table>
<?php
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
    	if($row["DeleteFlg"] ==0){
	        echo "<tr><td>";
	        echo $row["Tweet"];
	        echo "</td></tr>";
		}
	}
}

echo $_SESSION["mailaddress"];
?>

</table>

</body>
</html>