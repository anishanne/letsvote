<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: home.php");
    exit;
}

require_once "mysql_config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["code"]))) {
        $code_err = "Please enter a code.";
    } else {
        $code = trim($_POST["code"]);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "UPDATE resultsPageText SET text=? WHERE 1";

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
        <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
            <label>Change Results Page Text</label>
            <input type="text" name="code" class="form-control">
            <span class="help-block"><?php echo $code_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Change result page text.">
        </div>
    </form>
</div>
<a href="home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>
</html>

