<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: adminpage.php");
    exit;
}

require_once "config.php";
require "password.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST["username"]);
    if(empty($user)){
        $username_err = "Please enter your username!";
    }
    else {
        $username = trim($_POST["username"]);
    }

    $pass = trim($_POST["password"]);
    if(empty($pass)) {
        $password_err = "Please enter your password!";
    }
    else {
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql  = "SELECT ID, USERNAME, PASSWORD FROM admins WHERE USERNAME = ?";

        if($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){ 
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: adminpage.php");
                        }
                        else {
                            $login_err = "Invalid username or password!";
                        }
                    }
                }
                else {
                    $login_err = "Invalid username or password!";
                }   
            }
            else {
                echo("Something went wrong!  Try again!");
            }
            mysqli_stmt_close($stmt);
        }
    }
        mysqli_close($connect);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="finalstyle.css">
    <style>
        
        .wrapper{ width: 350px; padding: 20px; }
        h2 {
            font-size: 45px;
        }
        input[type="text" i] {
           border-radius: 4px;
           width: 190px;
           padding: 8px;
           display: inline-block;
           box-sizing: border-box;
           font-size: 15px;
           background-color: #464649;
           color: white;
        }
        input[type="text" i]:focus {
            background-color: #000000;
            border-color: #1F70FF;
            border-style: double;
        }
        input[type="password" i] {
            border-radius: 4px;
            width: 190px;
            padding: 8px;
            display: inline-block;
            box-sizing: border-box;
            font-size: 15px;
            background-color: #464649;
            color: white;
        }
        input[type="password" i]:focus {
            border-radius: 4px;
            border-color: #1F70FF;
            background-color: #000000;
        }
        .invalid-feedback {
            color: var(--invalid-red);
        }
        #login-explain {
            font-size: 13px;
        }
        input[type="submit" i] {
            color: white;
            background-color: var(--button-blue);
            text-decoration: none;
            border-radius: 5px;
            border-color: transparent;
            cursor: pointer;
            font-size: 17px;
            filter: drop-shadow(2px 2px 2px black);
            margin-top: 15px;
            padding-right: 10px;
            padding-left: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

    </style>
</head>
<body>
    <center>
    <div class="wrapper">
        <h2>Login</h2>
        <p id="login-explain">Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="invalid-feedback">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <br><br>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div> 
            <br>  
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <br><br>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
    <center>
</body>
</html>
