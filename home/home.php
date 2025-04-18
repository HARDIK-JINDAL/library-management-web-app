<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Library Management System</title>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
  <link rel="icon" href="resources/book.png" type="image/png">

  <link rel="stylesheet" href="home.css">
</head>
<body>
<h1>Library management system</h1>

  <div class="container">
    <h2>Employee</h2>
    <form action="home.php" method="POST">
      <input type="submit" value="LOGIN" name="LOGIN">
      <input type="submit" value="SIGNUP" name="SIGNUP">
    </form>
  </div>
</body>
</html>

<?php
  if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["LOGIN"])){
      header("Location: ../login/login.php ");
      exit;
    }
    elseif(isset($_POST["SIGNUP"])){
      header("Location:../signup/signup.php");
      exit;
    }
  }

?>