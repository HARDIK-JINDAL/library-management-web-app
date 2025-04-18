<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="icon" href="resources/book.png" type="image/png">
    <link rel="stylesheet" href="../dashboard/css/addBook.css">
</head>
<body>
    <div class="container">
        <form action="addBook.php" method="post">
            <input type="number" name="bookID" placeholder="bookID">
            <input type="text" name="title" placeholder="Title">
            <input type="number" name="price" placeholder="price">
            <input type="text" name="author" placeholder="Author name">
            <input type="submit" value="Add" name="Add">
            <input type="submit" value="Back" name="Back">

        </form>
    </div>
</body>
</html>

<?php
    session_start();
    include("../database/db.php");
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST["Back"])){
            header("Location:dashboard.php");
            exit;
        }elseif(isset($_POST["Add"])){
            if(empty($_POST["bookID"])||empty($_POST["title"])||empty($_POST["price"])||empty($_POST["author"])){
                echo "<div class='display'><p>Please enter all the fields</p></div>";
            }else{
                $bookid=$_POST["bookID"];
                $title=$_POST["title"];
                $price=$_POST["price"];
                $author=$_POST["author"];
                $emp_id = (int) $_SESSION['emp_id']; // force it to integer

               
                $sql = "INSERT INTO Book (book_id, title, retail_price, author_name, updated_by)
                        VALUES ('$bookid', '$title', '$price', '$author', '$emp_id');";

                if (mysqli_query($conn, $sql)) {
                    echo "<p class='success'>✅ book added successfully!</p>";
                } else {
                    echo "<p class='error'>❌ Error: " . mysqli_error($conn) . "</p>";
                }
            }
        }
    }

    
mysqli_close($conn);

?>
