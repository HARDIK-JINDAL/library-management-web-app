<?php
session_start();
include("../database/db.php");



$success = "";
$error = "";

// Fetch all books
$sql = "SELECT book_id, title, author_name, retail_price, availability FROM Book";
$result = mysqli_query($conn, $sql);

// Step 2: Handle book selection and update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book'])) {
    $book_id = $_POST['book_id'];
    $new_title = trim($_POST['new_title']);
    $new_author_name = trim($_POST['new_author_name']);
    $new_retail_price = trim($_POST['new_retail_price']);
    $new_availability = trim($_POST['new_availability']);

    // Update the book in the database
    $update = $conn->prepare("UPDATE Book SET title = ?, author_name = ?, retail_price = ?, availability = ? WHERE book_id = ?");
    $update->bind_param("ssdsd", $new_title, $new_author_name, $new_retail_price, $new_availability, $book_id);
    if ($update->execute()) {
        $success = "✅ Book updated successfully!";
    } else {
        $error = "❌ Failed to update book.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
    <link rel="stylesheet" href="../dashboard/css/updateBook.css">
    <link rel="icon" href="resources/book.png" type="image/png">

</head>
<body>
    <div class="container">
        <h2>✨Edit Books✨</h2>

        <?php if ($success): ?>
            <p class="success-message"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <h3>Available Books:</h3>
            <form method="POST" action="">
                <div class="book-selection">
                    <table>
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Price</th>
                                <th>Availability</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><input type="radio" name="book_id" value="<?php echo $row['book_id']; ?>"></td>
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['retail_price']); ?></td>
                                    <td><?php echo htmlspecialchars($row['availability']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="book-edit">
                    <h3>Edit Selected Book:</h3>
                    <input type="text" name="new_title" placeholder="New Title" required><br><br>
                    <input type="text" name="new_author_name" placeholder="New Author Name" required><br><br>
                    <input type="number" name="new_retail_price" placeholder="New Price" required><br><br>
                    <select name="new_availability" required>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select><br><br>
                    <div class="buttons-container">
                        <input type="submit" name="update_book" value="Update Book">
                    </div>
                </div>
            </form>
        <?php else: ?>
            <p>No books available for editing.</p>
        <?php endif; ?>

        <div class="buttons-container">
            <button onclick="window.location.href='dashboard.php';">Back</button>
        </div>
    </div>
</body>
</html>
