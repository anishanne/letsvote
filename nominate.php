<?php
    session_start();

    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        header("location: home.php");
        exit;
    }

    require_once "mysql_config.php";

    $nominee = $nominee_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["nominee"]))) {
            $nominee_err = "Work with me here...";
        } else {
            $nominee = trim($_POST["nominee"]);
        }

        $sql = "INSERT INTO candidates (user) VALUES (?)";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $nominee);

            if (!mysqli_stmt_execute($stmt)) {
                echo "oops: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }

        $sql = "INSERT INTO log (user, action) VALUES (?,?)";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $p_user, $p_log);

            $p_user = $_SESSION["username"];
            $p_log = "Added nomination for " . $nominee . " at " . date("Y/m/d") . " at " . date("h:i:s");

            if (!mysqli_stmt_execute($stmt)) {
                echo "oops: " . mysqli_stmt_error($stmt);
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
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
    <style type="text/css">
        body{
            background-size: cover !important;
            color: white
        }
    </style>
</head>
<body>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($nominee_err)) ? 'has-error' : ''; ?>">
            <label>User</label>
            <input type="text" name="nominee" class="form-control" value="<?php echo $nominee; ?>">
            <span class="help-block"><?php echo $nominee_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Nomination">
        </div>
    </form>
</div>
<a href="home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>

</html>
