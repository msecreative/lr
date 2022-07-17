<?php
    include_once "Session.php";
    include "Database.php";

    class User{
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        // user registration machanism

        public function userRegistration($data){
            $name       = $data['name'];
            $username   = $data['username'];
            $email      = $data['email'];
            $password   = $data['password'];
            $chkEmail = $this->emailCheck($email);

            if ($name == "" || $username == "" || $email == "" || $password == "") {
               $msg = "<div class='alert alert-danger'><strong>Field must not be empty !!</strong></div>";
               return $msg;
            }
            // username validation

            if (strlen($username) < 3) {
                $msg = "<div class='alert alert-danger'><strong>Username is too short !!</strong></div>";
               return $msg;
            }elseif (preg_match('/[^a-z0-9_-]+/i',$username)) {
                $msg = "<div class='alert alert-danger'><strong>Username must only contain alphanumerical, dashes and underscore !!</strong></div>";
               return $msg;
            }
            // Email validation
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $msg = "<div class='alert alert-danger'><strong>Email address is not valid !!</strong></div>";
               return $msg;
            }
            if ($chkEmail == true) {
                $msg = "<div class='alert alert-danger'><strong>Email address already Exist !!</strong></div>";
               return $msg;
            }
            $password   = md5($data['password']);

            $sql = "INSERT INTO tbl_user(`name`, username, email, `password`) VALUES(:name, :username, :email, :password)";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':username', $username, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                $msg = "<div class='alert alert-success'><strong>Success !!</strong>You have been registered</div>";
               return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Your registration not successfull!!</strong></div>";
               return $msg;
            }

        }

        // Email chk

        public function emailCheck($email){
            $sql = "SELECT email FROM tbl_user WHERE email = :email";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
        }

        // Password Chk

        private function checkPassword($id, $oldPass){
            $password = md5($oldPass);
            $sql = "SELECT password FROM tbl_user WHERE  id = :id AND password = :password";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':password', $password);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
        }

        // geting user detais

        public function getLoginUser($email,$username,$password){
            $sql = "SELECT * FROM tbl_user WHERE email = :email OR email = :username AND password= :password LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->bindValue(':username', $username);
            $query->bindValue(':password', $password);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }

        // user Login machanism

        public function userLogin($data){
            $email      = $data['email'];
            $username   = $data['email'];
            $password   = md5($data['password']);
            $chkEmail = $this->emailCheck($email);

            if ($email == "" || $password == "") {
               $msg = "<div class='alert alert-danger'><strong>Field must not be empty !!</strong></div>";
               return $msg;
            }

            // Email validation
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $msg = "<div class='alert alert-danger'><strong>Email address is not valid !!</strong></div>";
               return $msg;
            }
            if ($chkEmail == false) {
                $msg = "<div class='alert alert-danger'><strong>Email address does't Exist !!</strong></div>";
               return $msg;
            }

            $result = $this->getLoginUser($email,$username,$password);

            if ($result) {
                Session::init();
                Session::set("login", true);
                Session::set("id", $result->id);
                Session::set("name", $result->name);
                Session::set("username", $result->username);
                Session::set("loginmsg", "<div class='alert alert-success'><strong>Success !!</strong>You are loged in</div>");
                header("Location: index.php");
            }else{
                $msg = "<div class='alert alert-danger'><strong>Data not found !!</strong></div>";
               return $msg;
            }
        }

        // Select All user data

        public function getUserData(){
            $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
            $query = $this->db->pdo->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

        // select Profile details 

        public function getProfileDetailsById($id){
            $sql = "SELECT * FROM tbl_user WHERE id=:id LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }

        // Update user date

        public function updateProfileData($pId, $data){
            $name       = $data['name'];
            $username   = $data['username'];
            $email      = $data['email'];
            
            // $chkEmail = $this->emailCheck($email);

            if ($name == "" || $username == "" || $email == "") {
               $msg = "<div class='alert alert-danger'><strong>Field must not be empty !!</strong></div>";
               return $msg;
            }
            // username validation

            if (strlen($username) < 3) {
                $msg = "<div class='alert alert-danger'><strong>Username is too short !!</strong></div>";
               return $msg;
            }elseif (preg_match('/[^a-z0-9_-]+/i',$username)) {
                $msg = "<div class='alert alert-danger'><strong>Username must only contain alphanumerical, dashes and underscore !!</strong></div>";
               return $msg;
            }
            // Email validation
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $msg = "<div class='alert alert-danger'><strong>Email address is not valid !!</strong></div>";
               return $msg;
            }

            $sql = "UPDATE  tbl_user SET `name`=:name, username=:username, email=:email WHERE id=:id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':username', $username, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':id', $pId);
            $result = $query->execute();
            if ($result) {
                $msg = "<div class='alert alert-success'><strong>Success !!</strong>You have updated successfully!!!</div>";
               return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Your update not successfull!!</strong></div>";
               return $msg;
            }
        }

        // Change password machanism

        public function updatePassData($id, $data){
            $oldPass = $data['oldPass'];
            $newPass = $data['newPass'];
            if ($oldPass == "" || $newPass == "") {
                $msg = "<div class='alert alert-danger'><strong>Field must not be empty !!</strong></div>";
                return $msg;
             }

             $chkPass = $this->checkPassword($id, $oldPass);

             if ($chkPass == false) {
                $msg = "<div class='alert alert-danger'><strong>Old Password Doesn't Exist !!</strong></div>";
                return $msg;
             }
             if (strlen($newPass) < 6) {
                $msg = "<div class='alert alert-danger'><strong>New Password is too short !!</strong></div>";
                return $msg;
             }

             $npw = md5($newPass);

            $sql = "UPDATE  tbl_user SET `password`=:password WHERE id=:id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':password', $npw, PDO::PARAM_STR);
            $query->bindValue(':id', $id);
            $result = $query->execute();
            if ($result) {
                $msg = "<div class='alert alert-success'><strong>Success !!</strong>You have updated successfully!!!</div>";
               return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Your update not successfull!!</strong></div>";
               return $msg;
            }

        }
        
    }//User Class End