<?php

require_once "config.php";
require "password.php";

$username = $password = $password_confirm = "";
$username_err = $password_err = $password_confirm_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST["username"]);
    if(empty($user)) {
        $username_err = "Please enter a username!";
    }
    else {
        $sql = "SELECT id FROM admins WHERE username = ?";

        if($stmt = mysqli_prepare($connect, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken! Please choose another one.";
                }
                else {
                    $username = trim($_POST["username"]);
                }
            }
            else {
                echo "Something went wrong! Try again!";
            }
            mysqli_stmt_close($stmt);
        }
    }

    $pass = trim($_POST["password"]);
    if (empty($pass)) {
        $password_err = "Please enter a password!";
    }
    elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters!";
    }
    else {
        $password = trim($_POST["password"]);
    }

    $confirmpass = trim($_POST["confirm_password"]);
    if (empty($confirmpass)) {
        $confirm_password_err = "Please confirm your password!";
    }
    else {
        $confirm_password = $confirmpass;
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match! Try again.";
        }
    }

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO admins (USERNAME, PASSWORD) VALUES (?, ?)";

        if($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)){
                header("location: admin_login.php");
            }
            else {
                echo("Something went wrong! Try again.");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="admin_login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
