<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: home.php");
    exit;
}?>
<?php
require_once "mysql_config.php";

$result = mysqli_query($db, "SELECT * FROM votes");

$list1 = "";

while ($row = mysqli_fetch_array($result)) {
    echo strtolower(nl2br($row['candidate_one'].","));
    echo strtolower(nl2br($row['candidate_two'].","));
    echo strtolower(nl2br($row['candidate_three']." \r\n "));
}
$list = strtolower($list1);
echo $list;
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings

// fetch the data

$rows = mysqli_query($db, "SELECT * FROM votes");

// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
mysqli_close($db);
?>
