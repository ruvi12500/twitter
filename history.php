
<?
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
    $query = "SELECT * FROM tweet ORDER BY TweetDate desc;";
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) { ?>
            <tr><td>
            ツイート:
            <?= $row["Tweet"]; ?>
            日時：
            <?= $row["TweetDate"]; ?>
            <? if($row["DeleteFlg"] == 1) { ?>
                削除されています。
            <? } ?>
            </td></tr>
    <? }
    }
}

include 'history_templates.php';
