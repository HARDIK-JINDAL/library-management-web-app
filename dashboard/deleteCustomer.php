
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
    <link rel="stylesheet" href="../dashboard/css/deleteCustomer.css"> 
    <link rel="icon" href="resources/book.png" type="image/png">
</head>
<body>
    <div class="customer">
        <h2>Delete Customer</h2>
        <form action="deleteCustomer.php" method="post">
            <input type="text" name="Customer-id" placeholder="Customer ID" required>
            <input type="text" name="Name" placeholder="Customer Name" required>
            <input type="submit" value="Delete" name="Delete">
            <input type="submit" value="Back" name="Back">
        </form>
    </div>
</body>
</html>

<?php
session_start();
include("../database/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Redirect back to the dashboard if 'Back' button is clicked
    if (isset($_POST["Back"])) {
        header("Location: dashboard.php");
        exit;
    }

    // Process the deletion if 'Delete' button is clicked
    elseif (isset($_POST["Delete"])) {
        $customer_id = $_POST["Customer-id"];
        $name = $_POST["Name"];

        // Check if the fields are empty
        if (empty($customer_id) || empty($name)) {
            echo "<p style='color:red;'>❌ Please fill in all fields.</p>";
            exit;
        }

        // Check if the customer exists in the database
        $checkCustomer = "SELECT * FROM Customer WHERE customer_id = '$customer_id' AND name = '$name'";
        $res = mysqli_query($conn, $checkCustomer);

        if (mysqli_num_rows($res) == 0) {
            echo "<p style='color:red;'>❌ No such customer exists.</p>";
            exit;
        }

        // Check if the customer has borrowed books (in the IssuedBooks table)
        $borrowCheck = "SELECT COUNT(*) as count FROM IssuedBooks WHERE customer_id = '$customer_id'";
        $borrowRes = mysqli_query($conn, $borrowCheck);
        $borrowRow = mysqli_fetch_assoc($borrowRes);

        // If the customer has borrowed books, prevent deletion
        if ($borrowRow['count'] > 0) {
            echo "<p style='color:red;'>❌ Cannot delete. Customer still has borrowed books.</p>";
            exit;
        }

        // Delete related logs first (to avoid foreign key constraint issues)
        $deleteLogs = "DELETE FROM log WHERE customer_id = '$customer_id'";
        mysqli_query($conn, $deleteLogs);

        // Now delete the customer from the Customer table
        $deleteQuery = "DELETE FROM Customer WHERE customer_id = '$customer_id'";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<p style='color:green;'>✅ Customer deleted successfully!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error deleting customer: " . mysqli_error($conn) . "</p>";
        }
    }
}

mysqli_close($conn);
?>
