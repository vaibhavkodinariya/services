<?php
class UserOperator
{
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function login_with_email($email, $password)
    {
        $query = "SELECT ID,User_type,PasswordHash FROM users WHERE Email=?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($email));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                if (password_verify($password, $result[0]['PasswordHash'])) {
                    $success['Success'] = true;
                    $success['ID'] = $result[0]['ID'];
                    return $success;
                } else {
                    $success['Success'] = false;
                    $success['Messege'] = 'Incorrect Username or Password';
                    return $success;
                }
            } else {
                $success['Success'] = false;
                $success['Messege'] = 'Incorrect Username or Password';
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function add_user($email, $password, $confirmpassword)
    {
        $querytocompare = "SELECT Email FROM users where Email=?";
        $insertdata = "INSERT INTO users(Email,PasswordHash)VALUES(:email,:password)";
        try {
            $selecttocompare = $this->db->prepare($querytocompare);
            $selecttocompare->execute(array($email));
            $records = $selecttocompare->fetchAll(PDO::FETCH_ASSOC);
            if (count($records) > 0) {
                $success['Success'] = false;
                $success['Messege'] = 'Already Exists';
                return $success;
            }
            if ($password != $confirmpassword) {
                $success['Success'] = false;
                $success['Messege'] = "Password and Confirm Password isnt't Match";
                return $success;
            }
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $registerintotable = $this->db->prepare($insertdata);
            $registerintotable->bindParam(':email', $email);
            $registerintotable->bindParam(':password', $passwordhash);
            if ($registerintotable->execute()) {
                $success['Success'] = true;
                $success['Messege'] = "You are Registerd now";
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function getUserdata($id)
    {
        $query = "Select * from users where ID=?";
        try {
            $fetchdata = $this->db->prepare($query);
            $fetchdata->execute(array($id));
            $result = $fetchdata->fetch(PDO::FETCH_ASSOC);
            if ($result > 0) {
                $success['Success'] = true;
                $success['Data'] = $result;
                return array($success);
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}