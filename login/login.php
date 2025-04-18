<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="icon" href="resources/book.png" type="image/png">
    <title>Login</title>
</head>
<body>
    <h1>Employee Login</h1>
    <div class="container">
        <form action="login.php" method="POST">
            <input type="text" name="employee-id" placeholder="Enter employee ID">
            <input type="password" name="password" placeholder="Enter password">
            <input type="submit" value="login" name="submit">
            <input type="submit" value="home" name="home">
        </form>
    </div>
</body>
</html>

<?php
    include("../database/db.php");
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST["home"])){
            header("Location:../home/home.php");
            exit;
        }
        if(isset($_POST["submit"])){
            $emp_id= $_POST["employee-id"];
            $password=$_POST["password"];

            $sql="SELECT * FROM staff WHERE staff_id = '$emp_id'";
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result)>0){
                $emp = mysqli_fetch_assoc($result);
                if(password_verify($password,$emp["password"])){
                    $_SESSION['emp_id']=$emp["staff_id"];
                    $_SESSION['Name']=$emp["name"];
                    echo "<p>LOGIN SUCCESSFULL</p>";
                    header("Location:../dashboard/dashboard.php");
                    exit;
                }
                else{
                    echo "<p class='message'>❌ Invalid password.</p>";
                }
            }else {
                echo "<p class='message'>❌ User not found.</p>";
            }
        }

    }
    mysqli_close($conn);
?>