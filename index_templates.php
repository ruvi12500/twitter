<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Twitter Login</title>
</head>
<body>
    <h1>ログインページ</h1>
    <?php if ($status == "logged_in") { ?>
        <p>ログイン済みです。</p>
    <?php } elseif ($status == "login") { ?>
        <?= "test";?>
    <?php } elseif ($status == "failed") { ?>
        <p>メールアドレスもしくはパスワードが違います。</p>
    <?php } else { ?>
        <form action="" method="POST">
        MAILADDRESS:<input type="text" name="mailaddress"><br>
        PASSWORD:<input type="password" name="password"><br>
        <input type="submit" value="ログイン">
    </form>
    <?php } ?>
</body>
</html>