<?php
    function valid_candidate($username)
    {
        require_once "mysql_config.php";
        global $db;
        $sql = "SELECT * FROM candidates WHERE user = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                return mysqli_stmt_num_rows($stmt) == 1;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } else {
            return false;
        }
        mysqli_stmt_close($stmt);
        return false;
    }
?>

<?php
    require "mysql_config.php";
    /*$code = $c1 = $c2 = $c3 = "";
    $code_err = $c1_err = $c2_err = $c3_err = "";
    $sql = "SELECT * FROM votingActive WHERE 1"
    $result = db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if ($row["text"] == "no"){
                $code_err = "Voting code must be provided";
            }
        }
    } else {
        echo "0 results";
    }
    db->close();*/
    $doVote = "yes";
    $sql = "SELECT * FROM votingActive WHERE 1";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $doVote = $row["text"];
        }
    } else {
        echo "0 results";
    }
    //$db->close();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($doVote == "yes") {
            if (empty(trim($_POST["voting_code"]))) {
                $code_err = "Voting code must be provided";
            } else {
                $code = trim($_POST["voting_code"]);
            }
            if (empty(trim($_POST["candidate_one"]))) {
                $c1_err = "Candidate must be provided";
            } else {
                if (valid_candidate(trim($_POST["candidate_one"]))) {
                    $c1 = trim($_POST["candidate_one"]);
                } else {
                    $c1_err = "Invalid candidate";
                }
            }
            if (empty(trim($_POST["candidate_two"]))) {
                $c2_err = "Candidate must be provided";
            } else {
                if (valid_candidate(trim($_POST["candidate_two"]))) {
                    $c2 = trim($_POST["candidate_two"]);
                } else {
                    $c2_err = "Invalid candidate";
                }
            }
            if (empty(trim($_POST["candidate_three"]))) {
                $c3_err = "Candidate must be provided";
            } else {
                if (valid_candidate(trim($_POST["candidate_three"]))) {
                    $c3 = trim($_POST["candidate_three"]);
                } else {
                    $c3_err = "Invalid candidate";
                }
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
                        header("location: congrats.php");
                        exit;
                    } else {
                        echo "Something went wrong.";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($db);
        } else {
            echo "Voting is closed";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">-->
    <title>Vote</title>
    <style type="text/css">
        body{
            color: #54575B;
        }
    </style>
</head>

<div class="topbar" style="text-align: left">
  <a href="homepage.php" style="color: white; text-decoration:none;">
      < Back to Home Page
    </a>
</div>
<body>
<center><h2 style="font-size:36px;">Vote Form</h2></center>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
            <label>Voting Code</label>
            <input type="text" name="voting_code" class="form-control" value="<?php echo $code; ?>">

            <span class="help-block"><?php echo $code_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($c1_err)) ? 'has-error' : ''; ?>">
            <label>Candidate 1</label>
            <input type="text" name="candidate_one" class="form-control" value="<?php echo $c1; ?>">
            <span class="help-block"><?php echo $c1_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($c2_err)) ? 'has-error' : ''; ?>">
            <label>Candidate 2</label>
            <input type="text" name="candidate_two" class="form-control" value="<?php echo $c2; ?>">
            <span class="help-block"><?php echo $c2_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($c3_err)) ? 'has-error' : ''; ?>">
            <label>Candidate 3</label>
            <input type="text" name="candidate_three" class="form-control" value="<?php echo $c3; ?>">
            <span class="help-block"><?php echo $c3_err; ?></span>
        </div>
        By voting, you agree to the <a
                href="https://artofproblemsolving.com/community/c402403h1376236_rules_of_nerds_united">Nerds United
            Election Rules.</a></br></br>
        <input type="checkbox" required name="rule1" value="No"/>I am using the voting code PMed to me by an admin/mod,
        and not any other voting code.</br>
        <input type="checkbox" required name="rule2" value="No"/>I may vote for myself.</br>
        <input type="checkbox" required name="rule3" value="No"/>I may not put the same user in multiple choice
        spots.</br>
        <input type="checkbox" required name="rule4" value="No"/>I may not change my vote after I have voted .</br>
        <input type="checkbox" required name="rule5" value="No"/>If I misclick, I may report voting errors in the voting
        errors thread in NU, after which my code will be reset</br></br>
        <div class="form-group" style="margin: 0 35%;">
            <input type="submit" class="buttonLink" style="background-color:#002C73; color: white;" value="Vote">
        </div>
    </form>
    <br>
    <!--<button type="button" class="btn btn-primary><a href="Back">nuvote.ml</button>
    <form action="/" method="post">
        <input type="submit" class="btn btn-primary" value="Back">
    </form>-->
    <div style="margin: 0 35%;" class="buttonLink">
        <a href="public_nominations.php" style="color:white; text-decoration:none;">Current Nominations</a>
    </div>
</div>
</body>

</html>
