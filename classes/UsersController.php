<?php

require_once 'DB.php';

class UsersController extends DB
{
    private array $errors = [];

    public function register()
    {
        if (isset($_POST['submit'])) {

            //init data
            $data = [
                    'firstname' => trim($_POST['firstname']),
                    'lastname' => trim($_POST['lastname']),
                    'username' => trim($_POST['username']),
                    'address' => trim($_POST['address']),
                    'phone' => trim($_POST['phone']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'country_id' => trim($_POST['country_id'])
                ];

            //validate inputs
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['email']) || empty($data['address']) || empty($data['phone']) || empty($data['username']) || empty($data['country_id']) || empty($data['password']) || empty($data['confirm_password'])) {
                die("you must fill all fields");
               // exit();
            }

            // Firstname
            if (!preg_match("/^[a-zA-Z0-9]*$/", $data['firstname'])) {
                $this->addError('firstname', 'Firstname must be alphanumeric');
            }

            // Lastname
            if (!preg_match("/^[a-zA-Z0-9]*$/", $data['lastname'])) {
                $this->addError('lastname', 'Lastname must be alphanumeric');
            }

            // Username
            if (!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])) {
                $this->addError('username', 'Username must be alphanumeric');
            }

            // Email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', 'Please enter a valid email');
            }
            // Check if email is unique
            if ($this->findUser($data['email'])) {
                $this->addError('email', 'Email address is taken');
            }

            //country
            if (empty($_POST['country_id'])) {
                $this->addError('country_id', 'Please select a country');
            }

            //password
            if (strlen($data['password']) < 6) {
                $this->addError('password', 'Password must be at least 6 characters');
            } elseif (!preg_match('@[^\w]@', $data['password']) || !preg_match('@[0-9]@', $data['password'])) {
                $this->addError('password', 'must contain at least one special character and one number');
                // confirm password
            } elseif ($data['password'] !== $data['confirm_password']) {
                $this->addError('confirm_password', 'Password doesnt match');
            }

            if (!$this->errors) {
                //  if all passed register user
                $this->createUser();
                $this->redirect('login.php');
            }
            return $this->errors;
        }
    }

    public function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }




    public function loginUser()
    {
       if (isset($_POST['login']))
       {
           $email = $_POST['email'];
           $password = $_POST['password'];
           if (empty($email) || empty($password)) {
               $this->addError('password', 'Please fill out all inputs');
           }
           //Check for email
           $user = $this->findUser($email);
           if ($user) {
               //User Found
               $loggedInUser = $this->login($email, $password);
               if ($loggedInUser) {
                   //Create session
                   $_SESSION['id'] = $user['id'];
                   $_SESSION['email'] = $user['email'];
                   $_SESSION['username'] = $user['username'];
                   $this->redirect('index.php');
               } else {
                   $this->addError('password', 'Password Incorrect');
               }
           } else {
               $this->addError('email', 'User not found');
           }
           return $this->errors;
       }

    }


    public function logout()
    {
        if (isset($_POST['logout']))
        {
            unset($_SESSION['id']);
            unset($_SESSION['email']);
            session_destroy();
            $this->redirect('login.php');
        }
    }

    public function getCountries()
    {
        $pdo = $this->getConnection();
        return $pdo->query('SELECT * FROM country')->fetchAll();
    }

    public function update($id)
    {
        if (isset($_POST['update']))
        {
            //init data
            $data = [
                'firstname' => trim($_POST['firstname']),
                'lastname' => trim($_POST['lastname']),
                'username' => trim($_POST['username']),
                'address' => trim($_POST['address']),
                'phone' => trim($_POST['phone']),
                'country_id' => trim($_POST['country_id'])
            ];

            //validate inputs
            if (empty($data['firstname']) || empty($data['lastname'])  || empty($data['username']) || empty($data['address']) || empty($data['phone']) || empty($data['country_id'])) {
                die("you must fill all fields");
                // exit();
            }
            $this->updateUser($data);
            $this->redirect('userProfile.php');
        }

    }

}
