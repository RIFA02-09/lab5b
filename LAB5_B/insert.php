<?php
include 'Database.php';
include 'User.php';

try {
    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Validate POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role'])) {
            // Sanitize inputs
            $matric = htmlspecialchars(trim($_POST['matric']));
            $name = htmlspecialchars(trim($_POST['name']));
            $password = trim($_POST['password']); // Do not htmlspecialchars passwords
            $role = htmlspecialchars(trim($_POST['role']));

            // Create an instance of the User class
            $user = new User($db);

            // Register the user using POST data
            $result = $user->createUser($matric, $name, $password, $role);

            // Provide feedback based on the result
            if ($result === true) {
                echo "User registered successfully.";
            } else {
                echo "Error: " . $result; // Return the error message from createUser
            }
        } else {
            echo "All fields are required.";
        }
    } else {
        echo "Invalid request method.";
    }

    // Close the database connection
    mysqli_close($db);
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
