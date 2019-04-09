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

    $code = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "INSERT INTO vote_codes (vote_code, valid) VALUES (?, 1)";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_code);

            $code = random_str();
            $param_code = $code;

            if (!mysqli_stmt_execute($stmt)) {
                echo "oops: " . mysqli_stmt_error($stmt);
            }
        }

        mysqli_stmt_close($stmt);
        $sql = "INSERT INTO log (user, action) VALUES (?,?)";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $p_user, $p_log);
            $p_user = $_SESSION["username"];
            $p_log = "Generated code that started with " . mb_substr($code, 0, -29) . " at " . date("Y/m/d") . " at " . date("h:i:s");
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
<body background="background.jpeg">
<div class="page-header">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label><?php echo "Code: " . $code; ?></label>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Generate code">
        </div>
    </form>
</div>
<a href="/home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>
</html>
