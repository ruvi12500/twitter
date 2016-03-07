<?
function connect_db(){
    $mysqli = new mysqli(
        'localhost',
        'takumi_asai',
        'asataku',
        'twitter'
    );
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }
    return $mysqli;
}

function login($mailaddress,$password){
session_start();
$mysqli = connect_db();

    if (isset($_SESSION["mailaddress"])) {

      $status = "logged_in";

    } elseif (!empty($mailaddress) OR !empty($password)) {

        $stmt = $mysqli->prepare(
            "SELECT * FROM user WHERE MailAddress = ? AND PassWord = ?"
        );
        $stmt->bind_param(
            'ss',
            $mailaddress,
            $password
        );
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $status = "login";
            $_SESSION["mailaddress"] = $mailaddress;
        } else {
            $status = "failed";
        }
        return $status;
    }


}


$status = login($_POST['mailaddress'],$_POST['password']);
include 'index_templates.php';
