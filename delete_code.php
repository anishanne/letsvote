<?php
    session_start();

    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        header("location: home.php");
        exit;
    }

    require_once "mysql_config.php";

    $code = $code_err = "";
    $id = -1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["code"]))) {
            $code_err = "Please enter a code.";
        } else {
            $code = trim($_POST["code"]);
        }

        if (empty($code_err)) {
			    
			//$sql = "DELETE FROM votes WHERE vote_code='$code'";
	
			//if ($db->query($sql) == TRUE) {
			//	echo " ";
			//} //else {
					//echo "Error deleting record: " . $db->error;
				//}

			//$db->close();
            $sql = "DELETE FROM votes WHERE vote_code = ?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("s", $ccode);
			$ccode=$code;
			$stmt->execute();
			
			
			
            /*if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_code);

                $param_code = $code;

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id);
                        mysqli_stmt_fetch($stmt);
                    } else {
                        $code_err = "Unknown code.";
                    }
                } else {
                    echo "oops";
                }
            }

            mysqli_stmt_close($stmt);*/
        }

        if (empty($code_err) && $id !== -1) {
            $sql = "UPDATE vote_codes SET valid = 0 WHERE id = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $param_id);

                $param_id = $id;

                if (!mysqli_stmt_execute($stmt)) {
                    echo "oops: " . mysqli_stmt_error($stmt);
                }
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($db);
    }

	
	
	
    require_once "mysql_config.php";

    $code = $code_err = "";
    $id = -1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["code"]))) {
            $code_err = "Please enter a code.";
        } else {
            $code = trim($_POST["code"]);
        }

        if (empty($code_err)) {
			    
			//$sql = "DELETE FROM votes WHERE vote_code='$code'";
	
			//if ($db->query($sql) == TRUE) {
			//	echo " ";
			//} //else {
					//echo "Error deleting record: " . $db->error;
				//}

			$db->close();
            $sql = "DELETE FROM votes WHERE vote_code='?'";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_code);

                $param_code = $code;

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id);
                        mysqli_stmt_fetch($stmt);
                    } else {
                        $code_err = "Unknown code.";
                    }
                } else {
                    echo "oops";
                }
            }

            mysqli_stmt_close($stmt);
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
</body>
</html>
