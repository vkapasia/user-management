<?php

session_start();

class database
{

    private $servername;
    private $username;
    private $password;
    private $dbname;

    protected function connect()
    {

        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "user_management";

        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn;
        }
    }
}




class databasequerys extends database
{


    function auth($table, $data)
    {
        $email = $data['email'];
        $password = $data['password'];

        // echo md5($password);
        // exit;


        $sql = "SELECT * FROM $table where email = '$email'";
        $result = $this->connect()->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();

            if (md5($password) != $row['password']) {
                $_SESSION["error_message"] = "Please Check Your password";
                return 'Please Check Your password';
            }

            if ($table == 'users') {
                date_default_timezone_set("Asia/Kolkata");
                $currenttime = date("Y-m-d h:i:s");
                $updatesql = "UPDATE users SET last_login = '$currenttime' WHERE email = '$email'";
                $this->connect()->query($updatesql);
            }

            $set = $table . "Id";
            $_SESSION["$set"] = $row['id'];
            $_SESSION["success_message"] = "LogedIn Successfully";
            return 'login Successfully';
        } else {
            $_SESSION["error_message"] = "Please Check Your Email";
            return 'Please Check Your Email';
        }
    }


    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 16; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    function insertData($table, $data)
    {

        foreach ($data as $key => $value) {
            $keys[] = $key;
            if ($key == 'password') {
                if (empty($value)) {
                    $value =  $this->randomPassword();
                } else {
                    $value = md5($value);
                }
            }
            $values[] = "'" . $value . "'";
        };
        array_pop($keys);
        array_pop($values);

        $kkk = implode(',', $keys);
        $vvv = implode(',', $values);


        $sql = "INSERT INTO $table ($kkk)
            VALUES ($vvv)";

        // echo $sql;exit;

        if ($this->connect()->query($sql) === TRUE) {
            $_SESSION["success_message"] = "User Created Successfully";
            return 'User Created Successfully';
        } else {
            $_SESSION["error_message"] = $this->connect()->error;
            return 'Something Went Wrong!';
        }
    }

    function insertMultiData($table, $data)
    {
        foreach ($data as $key => $value) {
            $valcount = count($value);
            $keys[] = $key;
        };


        array_unshift($keys, 'user_id');

        $kkk = implode(',', $keys);

        $error = 0;
        for ($i = 0; $i <= $valcount; $i++) {

            $values = array();

            foreach ($data as $key => $value) {

                $values[] = "'" . $data[$key][$i] . "'";
            }

            array_unshift($values, $_SESSION['usersId']);

            $vvv = implode(',', $values);

            $sql = "INSERT INTO $table ($kkk)
            VALUES ($vvv)";

            if ($this->connect()->query($sql) === FALSE) {
                $error++;
            }
        }

        if (empty($error) || $error != 1) {
            $_SESSION["error_message"] = $this->connect()->error;
            return 0;
        } else {
            $_SESSION["success_message"] = "Task Created Successfully";

            echo '<script>window.location.href = "http://localhost/user-management/dashboard.php";</script>';exit;

            return 1;
        }
    }

    function getallData($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->connect()->query($sql);

        if ($result->num_rows > 0) {
            // // output data of each row
            $row = $result->fetch_all();
            return $row;
        } else {
            return 0;
        }
    }

    function getDatawhere($table, $where)
    {
        $sql = "SELECT * FROM $table WHERE $where";

        $result = $this->connect()->query($sql);

        if ($result->num_rows > 0) {
            // // output data of each row
            $row = $result->fetch_all();
            return $row;
        } else {
            return 0;
        }
    }

    function updatePassword($table, $data)
    {

        date_default_timezone_set("Asia/Kolkata");
        $currenttime = date("Y-m-d h:i:s");

        $password = md5($data['password']);

        $setname = $table . "Id";
        $userId = $_SESSION["$setname"];
        $updatesql = "UPDATE users SET last_pass_updated = '$currenttime', password = '$password' WHERE id = '$userId'";

        $resutl = $this->connect()->query($updatesql);

        return $resutl;
    }
}

$database = new databasequerys();
