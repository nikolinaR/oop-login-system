<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require '../PHPMailer/autoload.php';
require_once 'DB.php';
require_once 'UsersController.php';

class ForgotPassword
{
    private $user;
    private $userContr;
    protected $mail;

    public function __construct()
    {
        $this->user = new DB();
        $this->userContr = new UsersController();
        //Create an instance; passing `true` enables exceptions
        $this->mail = new PHPMailer(true);
        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'nikolina.risteska65@gmail.com';
        $this->mail->Password = 'zxvybgpbnsdxemye';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
    }


    public function sendMail()
    {
        $userEmail = trim($_POST['email']);
        if (empty($userEmail))
        {
            $this->userContr->redirect('reset_password.php');
            exit('please enter an email');
        }
        if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
            $this->userContr->redirect('reset_password.php');
            exit('please enter an email');
        }

        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $url = 'php-login-register-system-with-profile.test/changePass.php?selector='.$selector.'&validator='.bin2hex($token);
        $expires = date("U") + 1800;
        if (!$this->user->deleteEmail($userEmail))
        {
            die("there was an error");

        }
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        if ($this->user->insertToken($userEmail, $selector, $hashedToken, $expires))
        {
            die("there was an error");
        }

        $subject = 'Reset your password';
        $message = '<p>Click the link below to reset your password ';
        $message .= '<a href="'.$url.'">Reset Password</a></p>';

        $this->mail->isHTML(true);          //Set email format to HTML
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->setFrom("nikolina.risteska65@gmail.com", "Nikolina");
        $this->mail->addAddress($userEmail);
        $this->mail->send();
        echo 'Message has been sent';
    }

    public function valChangePass()
    {
        if (isset($_POST['changpass']))
        {
            $data = [
                'selector' => trim($_POST['selector']),
                'validator' => trim($_POST['validator']),
                'password' => trim($_POST['password']),
                'confirm_pass' => trim($_POST['confirm_pass'])
            ];

            if (strlen($data['password']) < 6) {
                die('Password must be at least 6 characters');
            } elseif (!preg_match('@[^\w]@', $data['password']) || !preg_match('@[0-9]@', $data['password'])) {
                die('must contain at least one special character and one number');
                // confirm password
            } elseif ($data['password'] !== $data['confirm_pass']) {
                die('Password doesnt match');
            }

            $currentDate = date("U");
            $row = $this->user->resetPassword($data['selector'], $currentDate);
            $select = $row->fetch();
            if(!$row){
                die('the link expired');
            }

            $tokenBin = hex2bin($data['validator']);
            $tokenCheck = password_verify($tokenBin, $select['resetToken']);
            if (!$tokenCheck)
            {
                die('you must re-submit your reset request');
            }

            $tokenEmail = $select['resetEmail'];
            if (!$this->user->findUser($tokenEmail))
            {
                die('error tokenEmail');
            }

            if (!$this->user->changePassword(md5($data['password']) ,$tokenEmail))
            {
                die("there was an error");
            }
            if (!$this->user->deleteEmail($tokenEmail))
            {
                die("there was an error");
            }
            $this->userContr->redirect('/login.php');
        }
    }
}

$init = new ForgotPassword();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'send':
            $init->sendMail();
            break;
        case 'reset':
            $init->valChangePass();
            break;
        default:
            header('location: ../login.php');
    }
}
