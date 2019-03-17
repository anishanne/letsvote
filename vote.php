<?php
    require "mysql_config.php";

    $code = $c1 = $c2 = $c3 = "";
    $code_err = $c1_err = $c2_err = $c3_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (trim(empty($_POST["voting_code"]))) {
            $code_err = "Voting code must be provided";
        } else {
            $code = $_POST["voting_code"];
        }

        if (trim(empty($_POST["candidate_one"]))) {
            $c1_err = "Candidate must be provided";
        } else {
            $c1 = $_POST["candidate_one"];
        }

        if (trim(empty($_POST["candidate_two"]))) {
            $c2_err = "Candidate must be provided";
        } else {
            $c2 = $_POST["candidate_two"];
        }

        if (trim(empty($_POST["candidate_three"]))) {
            $c3_err = "Candidate must be provided";
        } else {
            $c3 = $_POST["candidate_three"];
        }

        if (empty($code_err) && empty($c1_err) && empty($c2_err) && empty($c3_err)) {
            $sql = "SELECT valid FROM vote_codes WHERE vote_code = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_code);

                $param_code = $code;
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $valid);
                        if (mysqli_stmt_fetch($stmt)) {
                            if ($valid != true) {
                                $code_err = "That code is not valid.";
                            }
                        }
                    } else {
                        $code_err = "That code does not exist.";
                    }
                } else {
                    echo "Something went wrong.";
                }
            }

            mysqli_stmt_close($stmt);
        }

        if (empty($code_err) && empty($c1_err) && empty($c2_err) && empty($c3_err)) {
            $sql = "INSERT INTO votes (vote_code, candidate_one, candidate_two, candidate_three) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $param_vote_code, $param_c1, $param_c2, $param_c3);

                $param_vote_code = $code;
                $param_c1 = $c1;
                $param_c2 = $c2;
                $param_c3 = $c3;
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Something went wrong.";
                    exit;
                }
            }

            mysqli_stmt_close($stmt);
        }

        if (empty($code_err) && empty($c1_err) && empty($c2_err) && empty($c3_err)) {
            $sql = "UPDATE vote_codes SET valid = ? WHERE vote_code = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "is", $param_valid, $param_vote_code);

                $param_valid = 0;
                $param_vote_code = $code;
                if (mysqli_stmt_execute($stmt)) {
                    header("location: index.html");
                    exit;
                } else {
                    echo "Something went wrong.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" href="vote.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>Vote</title>
</head>

<body>

<h2>Vote Form</h2>

<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
            <label>Voting Code</label>
            <input type="text" name="voting_code" class="form-control" value="<?php echo $code; ?>">

            <span class="help-block"><?php echo $code_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($c1_err)) ? 'has-error' : ''; ?>">
            <label>Candidate 1</label>
            <!--<input type="text" name="candidate_one" class="form-control" value="<?php echo $c1; ?>">-->
			<select name="candidate_one" class="form-control" value="<?php echo $c1; ?>">
				<option value="volvo">Volvo</option>
				<option value="saab">Saab</option>
				<option value="fiat">Fiat</option>
				<option value="audi">Audi</option>
			</select>
            <span class="help-block"><?php echo $c1_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($c2_err)) ? 'has-error' : ''; ?>">
            <label>Candidate 2</label>
            <!--<input type="text" name="candidate_two" class="form-control" value="<?php echo $c2; ?>">-->
			<select name="candidate_two" class="form-control" value="<?php echo $c2; ?>">
				<option value="volvo">Volvo</option>
				<option value="saab">Saab</option>
				<option value="fiat">Fiat</option>
				<option value="audi">Audi</option>
			</select>
            <span class="help-block"><?php echo $c2_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($c3_err)) ? 'has-error' : ''; ?>">
            <label>Candidate 3</label>
            <!--<input type="text" name="candidate_three" class="form-control" value="<?php echo $c3; ?>">-->
			<select name="candidate_three" class="form-control" value="<?php echo $c3; ?>">
				<option value="volvo">Volvo</option>
				<option value="saab">Saab</option>
				<option value="fiat">Fiat</option>
				<option value="audi">Audi</option>
			</select>
            <span class="help-block"><?php echo $c3_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Vote">
        </div>
    </form>
</div>

</body>
</html>