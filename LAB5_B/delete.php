<?php
include 'Database.php';
include 'User.php';

$message = ""; // Initialize a message variable

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        // Retrieve the matric value from the GET request
        if (!isset($_GET['matric']) || empty($_GET['matric'])) {
            throw new Exception("Matric value is missing.");
        }

        $matric = $_GET['matric'];

        // Create an instance of the Database class and get the connection
        $database = new Database();
        $db = $database->getConnection();

        // Create an instance of the User class
        $user = new User($db);

        // Attempt to delete the user
        if ($user->deleteUser($matric)) {
            $message = "User with Matric '$matric' deleted successfully!";
        } else {
            $message = "Failed to delete user. The user may not exist.";
        }

        // Close the connection
        $db->close();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    $message = "Invalid request method. Only GET requests are allowed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
    <h1>Delete User</h1>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="showData.php">Back to User List</a> <!-- Update the link to your main user list page -->
</body>
</html>
