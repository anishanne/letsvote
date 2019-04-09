<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: home.php");
    exit;
}

require_once "mysql_config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "TRUNCATE TABLE votes";
        $db->query($sql);
        $sql = "TRUNCATE TABLE candidates";
        $db->query($sql);
        $sql = "TRUNCATE TABLE vote_codes";
        $db->query($sql);



        $sql = "INSERT INTO log (user, action) VALUES (?,?)";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $p_user, $p_log);
            $p_user = $_SESSION["username"];
            $p_log = "Reset Election at " . date("Y/m/d") . " at " . date("h:i:s");
            if (!mysqli_stmt_execute($stmt)) {
                echo "oops: " . mysqli_stmt_error($stmt);
            }

        }
        mysqli_close($db);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Election</title>
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
<div class="page-header">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="I Am Sure I Want To Reset The Election">
        </div>
    </form>
</div>
<a href="/home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>
</html>
