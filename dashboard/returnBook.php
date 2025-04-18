<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Books</title>
    <link rel="stylesheet" href="../dashboard/css/returnBook.css"> 
    <link rel="icon" href="resources/book.png" type="image/png">

</head>
<body>
    <div class="container">
        <h1>✨Return Books✨</h1>
        <form action="returnBook.php" method="POST">
        <input type="number" name="cid" placeholder="Enter Customer ID">
        <input type="number" name="bid" placeholder="Enter Book ID">
        <input type="submit" value="return" name="return">
        <input type="submit" value="back" name="back">
        </form>

    </div>
</body>
</html>

<?php
    include("../database/db.php");  // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Check if the "Back" button is clicked
        if (isset($_POST["back"])) {
            header("Location: dashboard.php");  // Redirect back to the dashboard or any other page
            exit;
        }

        // Check if the "Return" button is clicked
        if (isset($_POST['return'])) {
            // Check if customer ID and book ID are provided
            if (empty($_POST["cid"]) || empty($_POST['bid'])) {
                echo "<div class='display'><p>Please enter both Customer ID and Book ID.</p></div>";
            } else {
                $cid = $_POST['cid'];  // Customer ID
                $bid = $_POST['bid'];  // Book ID

                // Check if the customer has borrowed the specified book
                $sql_check = "SELECT * FROM IssuedBooks WHERE customer_id = '$cid' AND book_id = '$bid'";
                $result_check = mysqli_query($conn, $sql_check);

                // If the book is found in the issued books table, proceed to delete it (i.e., return the book)
                if (mysqli_num_rows($result_check) > 0) {
                    // Prepare and execute the query to delete the record from IssuedBooks table
                    $sql_return = "DELETE FROM IssuedBooks WHERE customer_id = '$cid' AND book_id = '$bid'";

                    if (mysqli_query($conn, $sql_return)) {
                        echo "<div class='display'><p>Book returned successfully!</p></div>";
                    } else {
                        echo "<div class='display'><p>Error: " . mysqli_error($conn) . "</p></div>";
                    }
                } else {
                    echo "<div class='display'><p>This book is not issued to the customer.</p></div>";
                }
            }
        }
    }
?>
