<?php
    require_once("settings.php");
    $conn = @mysqli_connect($host, $user, $password, $sql_db);

    if(!$conn) {
        echo "<p>Oops! Something went wrong! :(</p>";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars(trim($_POST["password"]));

        
        $errors = [];
        $errMsg = "";
        if($email != "admin") {
            if(strlen($email) < 3) {
                array_push($errors,'err_email');
            } else {
                $check = false;
                for($i = 1; $i < strlen($email) - 1; $i++) {
                    if($email[$i] == '@') {
                        $check = true;
                        break;
                    }
                }
                if(!$check) {
                    array_push($errors,'err_email');
                }
            }
        }

        if(!isset($_POST["password"]) || strlen($password) < 3) {
            array_push($errors,'err_pwd');
        }

        
        if(count($errors) != 0) {
            $errString = "";
            for($i = 0; $i < count($errors); $i ++) {
                $errCode = $errors[$i];
                $errString .= "$errCode=1";
                if($i < count($errors) - 1) {
                    $errString .= "&";
                }
            }
            header("Location: index.php?$errString");
        } else {
            $query = "SELECT email, type, password FROM users WHERE email = '$email' AND password = '$password' AND type = ";
            if($email == "admin") {
                $query .= "1";
            } else {
                $query .= "0";
            }
            $query .= ";";
            $result = mysqli_query($conn,$query);
            $userCre = $result -> fetch_assoc();
            if($userCre && $userCre["email"] == $email && ($userCre["type"] == 0 || $userCre["type"] == 1) && $userCre["password"] == $password) {
                $query = "SELECT user_id, fname, lname, phone, email, address, type FROM users WHERE email = '$email' AND password = '$password' AND type = ";
                if($email == "admin") {
                    $query .= "1";
                } else {
                    $query .= "0";
                }
                $query .= ";";
                $result = mysqli_query($conn,$query);
                $user = $result -> fetch_assoc();
                session_start();
                $_SESSION["user"] = $user;
                if(isset($_SESSION["user"]) && $_SESSION["user"] != null) {
                    header("Location: home.php");
                } else {
                    echo $user;
                }
            } else {
                header("Location: index.php?err_wrong=1");
            }
        }
    }
?>