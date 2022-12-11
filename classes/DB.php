<?php

class DB
{
    private $host = 'localhost';
    private $dbname = 'login';
    private $user = 'root';
    private $pass = '';
    private $charset = "utf8mb4";
    private $conn;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function getConnection()
    {
//        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname .
                ";charset=" . $this->charset, $this->user, $this->pass, $this->options);
        } catch (PDOException $exception) {
            echo "Error -> " . $exception->getMessage();
        }
        return $this->conn;
    }

    // Create new user in db
    public function createUser()
    {
        $sql = "INSERT INTO users (firstname, lastname, username, email, address, phone, password, country_id) VALUES (:firstname, :lastname, :username, :email, :address, :phone, md5(:password), :country_id)";
        $name = $this->getConnection()->prepare($sql);

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $country_id = $_POST['country_id'];

        $name->bindParam(':firstname', $firstname);
        $name->bindParam(':lastname', $lastname);
        $name->bindParam(':username', $username);
        $name->bindParam(':email', $email);
        $name->bindParam(':address', $address);
        $name->bindParam(':phone', $phone);
        $name->bindParam(':password', $password);
        $name->bindParam(':country_id', $country_id);
        $name->execute();
    }

    // find user from db by email
    public function findUser($email)
    {
        $query = $this->getConnection()->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $result = $query->fetch();
        if ($result > 0) {
            return $result;
        } else {
            return false;
        }
    }


    public function login($email, $password)
    {
        $row = $this->findUser($email);
        if (!$row) return false;

        if ($row['password'] === md5($password)) {
            return true;
        } else {
            return false;
        }
    }

    public function redirect($location)
    {
        header('Location:' . $location);
        exit();
    }

    public function updateUser($id)
    {
        if(isset($_POST['update']))
        {

            $sql = "UPDATE users SET firstname=:firstname, lastname=:lastname, username=:username, address=:address, phone=:phone,
                 country_id=:country_id WHERE id=:id";
            $name = $this->getConnection()->prepare($sql);

            $name->bindParam(':id', $id);
            $name->bindParam(':firstname', $firstname);
            $name->bindParam(':lastname', $lastname);
            $name->bindParam(':username', $username);
            $name->bindParam(':address', $address);
            $name->bindParam(':phone', $phone);
            $name->bindParam(':country_id', $country_id);

            $id = $_SESSION['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $country_id = $_POST['country_id'];

            $name->execute();
        }

    }


    public function changePassword($password, $tokenMail)
    {
        $sql = "UPDATE users SET password=:password WHERE email=:email";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $tokenMail);
        $stmt->bindParam(':password', $password);
        if ($stmt->execute())
        {
            return true;
        } else {
            return false;
        }
    }

    public function resetPassword($resetSelector, $currentDate)
    {
        $sql = "SELECT * FROM pwdreset WHERE resetSelector=:resetSelector AND resetExpire >= :currentDate";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':resetSelector', $resetSelector);
        $stmt->bindParam(':currentDate', $currentDate);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            return $stmt;
        } else {
            return false;
        }
    }

    public function insertToken($email, $selector, $token, $expire)
    {
        $query = "INSERT INTO pwdReset (resetEmail, resetSelector, resetToken, resetExpire) VALUES (:resetEmail, :resetSelector, :resetToken, :resetExpire)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':resetEmail', $email);
        $stmt->bindParam(':resetSelector', $selector);
        $stmt->bindParam(':resetToken', $token);
        $stmt->bindParam(':resetExpire', $expire);
        $stmt->execute();
    }

    public function deleteEmail($resetEmail)
    {
        $query = 'DELETE FROM pwdReset WHERE resetEmail=:resetEmail';
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':resetEmail', $resetEmail);
        if($stmt->execute())
        {
            return true;
        } else {
            return false;
        }
    }

}
