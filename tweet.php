<?
session_start();
function connect_db()
{
    $mysqli = new mysqli(
        'localhost',
        'takumi_asai',
        'asataku',
        'twitter'
        );
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error
            );
        }
    return $mysqli;
}

function tweet_list()
{
    $Tweeted = 0;
    $mysqli = connect_db();
    $query = "SELECT * FROM tweet ORDER BY TweetDate desc";
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            if($row['DeleteFlg'] == $Tweeted) { ?>
                <tr><td>
                <?= $row['Tweet'] ?>
                <?= $row['TweetDate'] ?>
                <a href="tweet.php?id=<?= $row['ID'] ?> ">削除</a>
                <a href="update.php?id=<?= $row['ID'] ?> ">編集</a>
                </td></tr>
            <? }
        }
    }
}

function tweet_post($tweet,$tweetbtn)
{
    if (isset($tweet) && isset($tweetbtn)) {
        $mysqli = connect_db();
        $today = date("Y-m-d H:i:s");
        $insert = $mysqli->prepare(
            "insert into tweet (Tweet,User,TweetDate,DeleteFlg) VALUE(?,?,?,0)"
        );
        $insert->bind_param(
            'sss',
            $tweet,
            $_SESSION["mailaddress"],
            $today
        );
        $insert->execute();
    }
}

function tweet_delete($tweet_id)
{
    if (isset($tweet_id)) {
        $mysqli = connect_db();
        $Deleted = 1;
        $delete = $mysqli->prepare(
            "update tweet set DeleteFlg = $Deleted WHERE ID = ?"
        );
        $delete->bind_param('i', $tweet_id);
        $delete->execute();
    }
}



include 'tweet_templates.php';
