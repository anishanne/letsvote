<?php
require_once "mysql_config.php";

$result = mysqli_query($db,"SELECT * FROM votes");

echo "<table border='1'>
<tr>
<th>Voting Code</th>
<th>First Choice For Mod/Admin</th>
<th>Second Choice For Mod/Admin</th>
<th>Third Choice For Mod/Admin</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['vote_code'] . "</td>";
echo "<td>" . $row['candidate_one'] . "</td>";
echo "<td>" . $row['candidate_two'] . "</td>";
echo "<td>" . $row['candidate_three'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($db);
?>