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

function tweet_update($tweet_update,$tweet_id)
{
    if (isset($tweet_update)) {
        $mysqli = connect_db();
        $update = $mysqli->prepare(
            "update tweet set Tweet = ? WHERE ID = ?"
        );
        $update->bind_param(
            'si',
            $tweet_update,
            $tweet_id
        );
        $update->execute();
    }
}

include 'update_templates.php';
