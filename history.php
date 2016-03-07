<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
//接続
$mysqli = new mysqli('localhost', 'takumi_asai', 'asataku', 'twitter');

$query = "SELECT * FROM tweet ORDER BY TweetDate desc;";

?>
<form action="" method="POST">
<table>
<?php

if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
	        echo "<tr><td>";
	        echo "ツイート:";
	        echo $row["Tweet"];
	        echo "　日時：";
	        echo $row["TweetDate"];
	        if($row["DeleteFlg"] == 1){
	        	echo " 削除されています。";
	        }
	        echo "</td></tr>";
		
	}
}
?>
<a href="tweet.php">戻る</a>
</form>
</table>

</body>
</html>