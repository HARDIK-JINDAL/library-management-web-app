<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="icon" href="resources/book.png" type="image/png">
    <link rel="stylesheet" href="signup.css">

</head>
<body>
    <h1>New employee signup</h1>
    <div class="container">
        <h2>enter all the details</h2>
        <form action="signup.php" method="POST">
            <input type="text" name="staff-id" placeholder="Enter employee id">
            <input type="text" name="name" placeholder="Enter employee name">
            <input type="number" name="salary" placeholder="enter employee salary">
            <input type="password" name="password" placeholder="Enter password">
            <input type="submit" name="submit" value="submit">
            <input type="submit" name="home" value="home">



        </form>
    </div>
</body>
</html>


<?php
    include("../database/db.php");
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST["home"])){
            header("Location:../home/home.php");
            exit;
        }
        if(isset($_POST['submit'])){
            if(empty($_POST['staff-id']) || empty($_POST['name']) || empty($_POST['salary']) || empty($_POST['password'])){
                echo "<div class='display'><p>Please enter all the fields</p></div>";
            }else{
                $password=$_POST['password'];
                $salary = $_POST['salary'];
                $name=$_POST['name'];
                $emp_id=$_POST['staff-id'];

                $hash=password_hash($password,PASSWORD_DEFAULT);

                $sql = "INSERT INTO staff(staff_id , name , salary , password)VALUEs('$emp_id','$name','$salary','$hash')";
                mysqli_query($conn,$sql);
                echo "<div class='display'><p>New employee registered</p></div>";
            }
        }
    }


    mysqli_close($conn);
?>