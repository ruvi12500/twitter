<!DOCTYPE html>
<html>
<head>
	<title>Tweet編集画面</title>
</head>
<body>

<form action="" method="POST">
<input type="text" name="update">
<input type="submit" value = "確定">
<? tweet_update($_POST['update'],$_GET['id']); ?>
<br>
<a href="tweet.php">戻る</a>
</form>
</body>
</html>
