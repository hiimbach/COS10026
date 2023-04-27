<?php
    require_once("settings.php");
    $conn = @mysqli_connect($host, $user, $password, $sql_db);

    if(!$conn) {
        echo "<p>Oops! Something went wrong! :(</p>";
    } else {
        $fname = htmlspecialchars(trim($_POST["fname"]));
        $lname = htmlspecialchars(trim($_POST["lname"]));
        $phone = htmlspecialchars(trim($_POST["phone"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $address = htmlspecialchars(trim($_POST["address"]));
        $userImageContent = null;
        $userImageType = null;
        if(count($_FILES) > 0 && $_FILES["avt"] != null) {
            $userImageName = basename($_FILES["avt"]["name"]);
            $userImageType = pathinfo($userImageName, PATHINFO_EXTENSION);
    
            $allowTypes = ['jpg','png','jpeg','gif'];
    
            if(in_array($userImageType, $allowTypes)) {
                $userImage = $_FILES["avt"]["tmp_name"];
                $userImageContent = addslashes(file_get_contents($userImage));
            }
        }
        $userId = $_GET["userId"];

        $errMsg = 0;

        if($fname == "" || $lname == "" || $email == "") {
            $errMsg += 1;
        }

        if($errMsg != 0) {
            echo "<p>Oops! Something went wrong! :(</p>";
        } else {
            $query = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', address = '$address', phone = '$phone', avatar = '$userImageContent', avatar_type = '$userImageType' WHERE user_id = $userId;";
            $result = mysqli_query($conn,$query);
            header("Location: manager.php");
        }
    }
?>