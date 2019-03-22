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

    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        header("location: home.php");
        exit;
    }

    require_once "../system/mysql_config.php";

    $code = $code_err = "";
    $id = -1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["code"]))) {
            $code_err = "Please enter a code.";
        } else {
            $code = trim($_POST["code"]);
        }

        if (empty($code_err)) {
            $sql = "DELETE FROM votes WHERE vote_code = ?";
            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $ccode);
                $ccode = $code;
                if (!mysqli_stmt_execute($stmt)) {
                    echo "oops: " . mysqli_stmt_error($stmt);
                }
            }
        }

        if (empty($code_err)) {
            $sql = "UPDATE vote_codes SET valid = 0 WHERE vote_code = ?";
            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $ccode);
                $ccode = $code;
                if (!mysqli_stmt_execute($stmt)) {
                    echo "oops: " . mysqli_stmt_error($stmt);
                }
            }
        }
        $sql = "INSERT INTO log (user, action) VALUES (?,?)";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $p_user, $p_log);
            $p_user = $_SESSION["username"];
            $p_log = "Deleted code that started with " . mb_substr($code, 0, -29) . " at " . date("Y/m/d") . " at " . date("h:i:s");
            if (!mysqli_stmt_execute($stmt)) {
                echo "oops: " . mysqli_stmt_error($stmt);
            }

        }
        mysqli_close($db);
    }

?>

<!DOCTYPE html>
<html lang="en">
<body background="background.jpeg">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="page-header">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
            <label>Code</label>
            <input type="text" name="code" class="form-control">
            <span class="help-block"><?php echo $code_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Disable code">
        </div>
    </form>
</div>
<a href="/admin/home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>
</html>
