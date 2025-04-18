
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Books</title>
    <link rel="stylesheet" href="../dashboard/css/issueBook.css"> 
    <link rel="icon" href="resources/book.png" type="image/png">

</head>
<body>
    <div class="container">
        <h1>✨Issue new books✨</h1>
        <form action="issueBook.php" method="POST">
            <input type="number" name="cid" placeholder="Customer ID">
            <input type="number" name="bid" placeholder="Book ID">
            <input type="text" name="bname" placeholder="Book name">
            <input type="submit" value="issue" name="issue">
            <input type="submit" value="back" name="back">
        </form>
    </div>
    
</body>
</html>
<?php
    include("../database/db.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["issue"])) {
            if (empty($_POST["cid"]) || empty($_POST["bid"]) || empty($_POST["bname"])) {
                echo "<div class='display'><p>Please enter all the fields</p></div>";
            } else {
                $cid = $_POST['cid'];
                $bid = $_POST['bid'];
                $bname = $_POST['bname'];

                // Check if the book is available (availability != 'borrowed')
                $sql_check_book = "SELECT availability FROM Book WHERE book_id = '$bid'";
                $result_book = mysqli_query($conn, $sql_check_book);
                if (mysqli_num_rows($result_book) > 0) {
                    $book = mysqli_fetch_assoc($result_book);
                    if ($book['availability'] == 'borrowed') {
                        echo "<div class='display'><p>❌ This book is already borrowed.</p></div>";
                    } else {
                        // Check if the customer has exceeded the borrowing limit (3 books)
                        $sql_check_customer = "SELECT book_issued FROM Customer WHERE customer_id = '$cid'";
                        $result_customer = mysqli_query($conn, $sql_check_customer);
                        if (mysqli_num_rows($result_customer) > 0) {
                            $customer = mysqli_fetch_assoc($result_customer);
                            if ($customer['book_issued'] >= 3) {
                                echo "<div class='display'><p>❌ Borrowing limit exceeded: Customer already has 3 books.</p></div>";
                            } else {
                                // Insert the new issued book record
                                $sql_insert = "INSERT INTO IssuedBooks (customer_id, book_id, book_name) VALUES ('$cid', '$bid', '$bname')";
                                if (mysqli_query($conn, $sql_insert)) {
                                    // Everything is handled by the trigger (book availability, customer count, and log)
                                    echo "<div class='display'><p>✅ Book issued successfully!</p></div>";
                                } else {
                                    echo "<div class='display'><p>❌ Error: " . mysqli_error($conn) . "</p></div>";
                                }
                            }
                        } else {
                            echo "<div class='display'><p>❌ Customer not found.</p></div>";
                        }
                    }
                } else {
                    echo "<div class='display'><p>❌ Book not found.</p></div>";
                }
            }
        }

        if (isset($_POST["back"])) {
            header("Location: dashboard.php");  // Redirect back to the dashboard or any other page
            exit;
        }
    }
    mysqli_close($conn);
?>
