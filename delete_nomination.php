<?php
function random_str()
{
    $keyspace = 'abcdefghijklmnopqrstuvwxyz';
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < 32; ++$i) {
        $pieces [] = $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

?>

<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: home.php");
    exit;
}

require_once "mysql_config.php";

$code = random_str();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM candidates WHERE user = ?";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_code);

        $param_code = $code;

        if (!mysqli_stmt_execute($stmt)) {
            echo "oops: " . mysqli_stmt_error($stmt);
        }
    }

    mysqli_stmt_close($stmt);
    $sql = "INSERT INTO log (user, action) VALUES (?,?)";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $p_user,$p_log);
        $p_user=$_SESSION["username"];
        $p_log="Removed nomination for ".$code." at ".date("Y/m/d")." at ".date("h:i:s");
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
            <label>User</label>
            <input type="text" name="code" class="form-control">
            <span class="help-block"><?php echo $code_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Remove Nomination">
        </div>
    </form>
</div>
<a href="/home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>

</html>
