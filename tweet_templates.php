<!DOCTYPE html>
<html>
<head>
    <title>Twitter</title>
</head>
<body>
<form action="" method="POST">
<input type="text" name="tweet">
<input type="submit" name='tweetbtn' value="ツイート"><br>
<a href="history.php">履歴</a>
<h1>ツイート一覧</h1>
<table>
    <? tweet_post($_POST['tweet'],$_POST['tweetbtn']); ?>
    <? tweet_delete($_GET['id']); ?>
    <? tweet_list(); ?>
</form>
</table>

</body>
</html>
