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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["code"]))) {
            $code_err = "Please enter a code.";
        } else {
            $code = trim($_POST["code"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = "UPDATE frontPageText SET text=? WHERE 1";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_code);

                $param_code = $code;

                if (!mysqli_stmt_execute($stmt)) {
                    echo "oops: " . mysqli_stmt_error($stmt);
                }
            }
        }
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
            <label>Change Front Page Text</label>
            <input type="text" name="code" class="form-control">
            <span class="help-block"><?php echo $code_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Change front page text.">
        </div>
    </form>
</div>
<a href="/admin/home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>
</html>

