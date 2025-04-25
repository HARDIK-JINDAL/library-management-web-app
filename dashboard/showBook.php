<?php
include("../database/db.php"); // Include your database connection

// Query to get available books and calculate title count
$sql_available_books = "SELECT book_id, title, author_name, retail_price, availability, 
                                (SELECT COUNT(*) FROM Book b WHERE b.title = Book.title) AS title_count
                        FROM Book 
                        WHERE availability = 'available'";

$result_available_books = mysqli_query($conn, $sql_available_books);
$available_count = mysqli_num_rows($result_available_books); // Count of available books

// Query to get all books and calculate title count
$sql_all_books = "SELECT book_id, title, author_name, retail_price, availability, 
                        (SELECT COUNT(*) FROM Book b WHERE b.title = Book.title) AS title_count
                  FROM Book";

$result_all_books = mysqli_query($conn, $sql_all_books);
$all_count = mysqli_num_rows($result_all_books); // Count of all books
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

    <!-- Available Books Table -->
    <h2>Available Books (<?php echo $available_count; ?>)</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Title Count</th> <!-- New column for title count -->
            </tr>
        </thead>
        <tbody>
            <?php
            if ($available_count > 0) {
                while ($row = mysqli_fetch_assoc($result_available_books)) {
                    echo "<tr>
                            <td>{$row['book_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['author_name']}</td>
                            <td>{$row['retail_price']}</td>
                            <td>{$row['availability']}</td>
                            <td>{$row['title_count']}</td> <!-- Show title count -->
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No available books</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- All Books Table -->
    <h2>All Books (<?php echo $all_count; ?>)</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Title Count</th> <!-- New column for title count -->
            </tr>
        </thead>
        <tbody>
            <?php
            if ($all_count > 0) {
                while ($row = mysqli_fetch_assoc($result_all_books)) {
                    echo "<tr>
                            <td>{$row['book_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['author_name']}</td>
                            <td>{$row['retail_price']}</td>
                            <td>{$row['availability']}</td>
                            <td>{$row['title_count']}</td> <!-- Show title count -->
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No books found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
