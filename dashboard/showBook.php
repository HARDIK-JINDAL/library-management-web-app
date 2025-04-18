<?php
include("../database/db.php"); // Make sure to include your database connection

// Query to get all available books
$sql_available_books = "SELECT book_id, title, author_name, retail_price, availability FROM Book WHERE availability = 'available'";
$result_available_books = mysqli_query($conn, $sql_available_books);

// Query to get all books (available and borrowed)
$sql_all_books = "SELECT book_id, title, author_name, retail_price, availability FROM Book";
$result_all_books = mysqli_query($conn, $sql_all_books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link rel="stylesheet" href="../dashboard/css/showBook.css"> 
    <link rel="icon" href="resources/book.png" type="image/png">

</head>
<body>

    <!-- Back Button -->
    <button onclick="window.location.href='dashboard.php';">Back</button>

    <h2>Available Books</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display available books
            if (mysqli_num_rows($result_available_books) > 0) {
                while ($row = mysqli_fetch_assoc($result_available_books)) {
                    echo "<tr>
                            <td>{$row['book_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['author_name']}</td>
                            <td>{$row['retail_price']}</td>
                            <td>{$row['availability']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No available books</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>All Books</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display all books
            if (mysqli_num_rows($result_all_books) > 0) {
                while ($row = mysqli_fetch_assoc($result_all_books)) {
                    echo "<tr>
                            <td>{$row['book_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['author_name']}</td>
                            <td>{$row['retail_price']}</td>
                            <td>{$row['availability']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No books found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
