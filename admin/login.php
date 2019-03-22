<!--
    letsvote - STV voting system
    Copyright (C) 2019 anishanne

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
-->

<?php
    session_start();

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        header("location: home.php");
        exit;
    }

    require_once "../system/mysql_config.php";

    $username = $password = "";
    $username_err = $password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }

        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty($username_err) && empty($password_err)) {
            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                $param_username = $username;

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                session_start();

                                $_SESSION["logged_in"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;


                                //if (empty($username_err) && empty($password_err)) {
                                $sql = "INSERT INTO log (user, action) VALUES (?,?)";
                                if ($stmt = mysqli_prepare($db, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "ss", $p_user, $p_log);
                                    $p_user = $username;

                                    $p_log = "Logged in on " . date("Y/m/d") . " at " . date("h:i:s");
                                    if (!mysqli_stmt_execute($stmt)) {
                                        echo "oops: " . mysqli_stmt_error($stmt);
                                    }

                                }


                                //require_once "webhook.php";
                                // $text = "This is a test messasge";//($username."Logged in on " . date("Y/m/d") . " at " . date("h:i:s"));
                                //curl_setopt($curl, CURLOPT_POST, 1);
                                //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => $text)));

                                //echo  curl_exec($curl);
                                header("location: home.php");
                            } else {
                                $password_err = "The password you entered was not valid.";
                            }
                        }
                    } else {
                        $username_err = "No account found with that username.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            mysqli_stmt_close($stmt);
        }


        mysqli_close($db);
    }
?>

<!DOCTYPE html>
<html lang="en">
<body background="background.jpeg">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
</body>
</html>
