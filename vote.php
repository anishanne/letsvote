<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="vote.css">
</head>

<body>

<h2>Vote Form</h2>

<form action="logVote.php"  method="post">
  <div class="container">
    <label for="usercode"><b>Usercode</b></label>
    <input type="text" placeholder="Enter Your Code" name="code" required>

    <label for="choice1"><b>First Choice for Admin/Mod</b></label>
    <input type="text" placeholder="Enter You First Choice for Admin/Mod:" name="c1" required>
  
    <label for="choice2"><b>Second Choice for Admin/Mod</b></label>
    <input type="text" placeholder="Enter You Second Choice for Admin/Mod:" name="c2" required>

    <label for="choice3"><b>Third Choice for Admin/Mod</b></label>
    <input type="text" placeholder="Enter You Third Choice for Admin/Mod:" name="c3" required>
	
    <button type="submit">Login</button>
	
  </div>
</form>

</body>
</html>