<?php
$host = "localhost";
$user = "root";
$dp = "bcm_system";
$connection = mysqli_connect($host, $user, "", $dp);

if (isset($_POST["insert"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST['phone'];
    $insert = "INSERT INTO users VALUES (NULL,'$username','$phone',NULL,NULL,'$email',$password)";

    $ins_query = mysqli_query($connection, $insert);

    if ($ins_query) {
        header("location:index.php");
    }
}

if (isset($_POST["login"])) {
    $email=$_POST["email"];
    $password=$_POST["password"];

    $get_all_data = "SELECT * FROM users";
    $get_all_data_qu = mysqli_query($connection, $get_all_data);
    foreach($get_all_data_qu as $row){
        if($row["email"]==$email){
            if($row["password"]==$password){
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION["ID"]=$row["ID"];
                $_SESSION['username'] = $row["username"];
                $_SESSION["address"]=$row["address"];
                $_SESSION["info"]=$row["info"];
                $_SESSION["phone"]=$row["phone"];
                header("location:home.php");
            }
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootsrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>

    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
            <!--  -->
            <div class="login-form">
                <form action="" method="post">
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="email" class="label">Email Address</label>
                            <input id="email" type="email" class="input" name="email">
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Password</label>
                            <input id="pass" type="password" class="input" data-type="password" name="password">
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Sign In" name="login">
                        </div>
                    </div>
                </form>
                <form action="" method="post">
                    <div class="sign-up-htm">
                        <div class="group">
                            <label for="user" class="label">User name</label>
                            <input id="user" type="text" class="input" name="username">
                        </div>
                        <div class="group">
                            <label for="email" class="label">Email Address</label>
                            <input id="email" type="email" class="input" name="email">
                        </div>
                        <div class="group">
                            <label for="phone" class="label">Phone Number</label>
                            <input id="phone" type="tel" class="input" name="phone">
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Password</label>
                            <input id="pass" type="password" class="input" data-type="password" name="password">
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Sign Up" name="insert">
                        </div>
                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <label for="tab-1">Already Member?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstap.js"></script>
</body>

</html>