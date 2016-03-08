<?
class Login
{
    private $host = 'localhost';
    private $db_user = 'takumi_asai';
    private $db_pass = 'asataku';
    private $use_db = 'twitter';
    private $mailaddress = null;
    private $password = null;
    private $status = 'none';

    public function setMailAddress($mailaddress)
    {
        $this->mailaddress = (string)filter_var($mailaddress);
    }
    public function getMailAddress()
    {
        return $this->mailaddress;
    }

    public function setPassWord($password)
    {
        $this->password = (string)filter_var($password);
    }
    public function getPassWord()
    {
        return $this->password;
    }

    public function setStatus($status)
    {
        $this->status = (string)filter_var($status);
    }
    public function getStatus()
    {
        return $this->status;
    }


    public function connect_db()
    {
        $class = new Login();
        $mysqli = new mysqli(
            $class->host,
            $class->db_user,
            $class->db_pass,
            $class->use_db
        );
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error
                );
            }
        return $mysqli;
    }

    public function login_check($mailaddress,$password)
    {
    //session_start();
    $mysqli = $this->connect_db();

        if (isset($_SESSION["mailaddress"])) {
            $this->setStatus('logged_in');
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
                $this->setStatus('login');
                $_SESSION["mailaddress"] = $mailaddress;
            } else {
                $this->setStatus('failed');
            }
        }
    }
}

$login_class = new Login();

if (isset($_POST['mailaddress']) && isset($_POST['password'])) {
    $login_class->setMailAddress($_POST['mailaddress']);
    $login_class->setPassWord($_POST['password']);
}

$login_class->login_check($login_class->getMailAddress(),$login_class->getPassWord());

include 'index_templates.php';
