<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register customer</title>
    <link rel="stylesheet" href="../dashboard/css/registerCustomer.css"> 
    <link rel="icon" href="resources/book.png" type="image/png">

</head>
<body>
    <div class="customer">
        <h1>✨Register customer✨</h1>
        <form action="registerCustomer.php" method="POST">
            <input type="text" name="name" placeholder="Customer name">
            <input type="text" name="address" placeholder="Address">
            <input type="submit" value="Add" name="Add">
            <input type="submit" value="back" name="Back">
        </form>
    </div>
    
</body>
</html>

<?php
    include("../database/db.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if Back button is clicked
        if (isset($_POST["Back"])) {
            header("Location: dashboard.php");  // Redirect back to the dashboard or any other page
            exit;
        }

        // Check if Add button is clicked
        if (isset($_POST['Add'])) {
            // Validate input fields
            if (empty($_POST["name"]) || empty($_POST['address'])) {
                echo "<div class='display'><p>Please enter all the fields.</p></div>";
            } else {
                $name = $_POST['name'];
                $address = $_POST['address'];
                
                // Set reg_date to current date and book_issued to 0
                $reg_date = date('Y-m-d');  // Current date in Y-m-d format
                $book_issued = 0;

                // Prepare SQL query to insert customer with manual values for reg_date and book_issued
                $sql = "INSERT INTO customer (name, address, reg_date, book_issued) 
                        VALUES ('$name', '$address', '$reg_date', '$book_issued')";

                // Execute query
                if (mysqli_query($conn, $sql)) {
                    echo "<div class='display'><p>Customer added successfully!</p></div>";
                } else {
                    echo "<div class='display'><p>Error: " . mysqli_error($conn) . "</p></div>";
                }
            }
        }
    }
?>