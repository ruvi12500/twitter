<?

session_start();
    $Tweeted = 0;
    $Deleted = 1;
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
    $mysqli = connect_db();
    $query = "SELECT * FROM tweet ORDER BY TweetDate desc";
    $today = date("Y-m-d H:i:s");
    if ($result = $mysqli->query($query)) {
     while ($row = $result->fetch_assoc()) {
         if($row["DeleteFlg"] == $Tweeted) { ?>
            <tr><td>
                <?= $row["Tweet"] ?>
                <?= $row["TweetDate"] ?>
                <a href="tweet.php?id=<?= $row["ID"] ?> ">削除</a>
                <a href="update.php?id=<?= $row["ID"] ?> ">編集</a>
            </td></tr>
            <? }
        }
    }
}

function tweet_post()
{
    if (isset($_POST["tweet"]) && isset($_POST["tweetbtn"])) {
        $insert = $mysqli->prepare("insert into tweet (Tweet,User,TweetDate,DeleteFlg) VALUE(?,?,?,0)");
        $insert->bind_param('sss', $_POST["tweet"],$_SESSION["mailaddress"],$today);
        $insert->execute();
    }
}

function tweet_delete()
{
    if (isset($_GET["id"])) {
        $delete = $mysqli->prepare("update tweet set DeleteFlg = $Deleted WHERE ID = ?");
        $delete->bind_param('i', $_GET["id"]);
        $delete->execute();
    }
}


include 'tweet_templates.php';