<!DOCTYPE html>
<html>
<head>
    <title>Twitter</title>
</head>
<body>
<form action="" method="POST">
<input type="text" name="tweet">
<input type="submit" name='tweetbtn' value="ツイート">

<h1>ツイート一覧</h1>
<table>
<? tweet_list();?>
</form>
</table>
<a href="history.php">履歴</a>
</body>
</html>
