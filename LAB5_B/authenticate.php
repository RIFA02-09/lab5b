<?php

include 'Database.php';
include 'User.php';

if (isset($_POST['submit']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Sanitize inputs
    $matric = $db->real_escape_string(trim($_POST['matric']));
    $password = $db->real_escape_string(trim($_POST['password']));

    // Validate inputs
    if (!empty($matric) && !empty($password)) {
        $user = new User($db);
        $userDetails = $user->getUser($matric);

        // Check if user exists and verify password
        if ($userDetails && password_verify($password, $userDetails['password'])) {
            echo 'Login Successful';
        } else {
            echo 'Login Failed. Invalid username or password. Try <a href="login.php">login</a> again.';
        }
    } else {
        echo 'Please fill in all required fields.';
    }

    // Close the database connection
    $db->close();
}
?>
