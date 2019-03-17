<?php
    session_start();

    $_SESSION = array();

    session_destroy();
    $sql = "INSERT INTO log (user, action) VALUES (?,?)";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $p_user,$p_log);
        $p_user=$_SESSION["username"];
        $p_log="Logged out on ".date("Y/m/d")." at ".date("h:i:s");
        if (!mysqli_stmt_execute($stmt)) {
            echo "oops: " . mysqli_stmt_error($stmt);
        }

    }
    header("location: login.php");
    exit;
