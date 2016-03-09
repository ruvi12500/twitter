<?
class Twitter
{
    private $host = 'localhost';
    private $db_user = 'takumi_asai';
    private $db_pass = 'asataku';
    private $use_db = 'twitter';
    private $tweet = null;
    private $tweetbtn = null;
    private $deletebtn = null;

    public function setTweet($tweet)
    {
        $this->tweet = (string)filter_var($tweet);
    }
    public function getTweet()
    {
        return $this->tweet;
    }

    public function setTweetBtn($tweetbtn)
    {
        $this->tweetbtn = $tweetbtn;
    }
    public function getTweetBtn()
    {
        return $this->tweetbtn;
    }

    public function setTweetDelete($deletebtn)
    {
        $this->deletebtn = $deletebtn;
    }
    public function getTweetDelete()
    {
        return $this->deletebtn;
    }

    public function connect_db()
    {
        $mysqli = new mysqli(
            $this->host,
            $this->db_user,
            $this->db_pass,
            $this->use_db
        );
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error
            );
        }
        return $mysqli;
    }

    public function tweet_list()
    {
        $Tweeted = 0;
        $mysqli = $this->connect_db();
        $query = "SELECT * FROM tweet ORDER BY TweetDate desc";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                if ($row['DeleteFlg'] == $Tweeted) { ?>
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

    public function tweet_post($tweet,$tweetbtn)
    {
        if (isset($tweet) && isset($tweetbtn)) {
            $mysqli = $this->connect_db();
            $today = date("Y-m-d H:i:s");
            $insert = $mysqli->prepare(
                "insert into tweet
                (Tweet,User,TweetDate,DeleteFlg)
                VALUE(?,?,?,0)"
            );
            $insert->bind_param('sss',$tweet,$_SESSION["mailaddress"],$today);
            $insert->execute();
        }
    }

    public function tweet_delete($tweet_id)
    {
        if (isset($tweet_id)) {
            $mysqli = $this->connect_db();
            $Deleted = 1;
            $delete = $mysqli->prepare(
                "update tweet set DeleteFlg = $Deleted WHERE ID = ?"
            );
            $delete->bind_param('i', $tweet_id);
            $delete->execute();
        }
    }
}

$tweet_class = new Twitter();

if (isset($_POST['tweet']) && isset($_POST['tweetbtn'])) {
    $tweet_class->setTweet($_POST['tweet']);
    $tweet_class->setTweetBtn($_POST['tweetbtn']);
}

if (isset($_GET['id'])) {
    $tweet_class->setTweetDelete($_GET['id']);
}

include 'tweet_templates.php';
