<?php
include 'Database.php';
include 'User.php';

$message = ""; // Initialize a message variable
$matric = "";
$name = "";
$role = "";

// Load user details if matric is provided
if (isset($_GET['matric'])) {
    try {
        $matric = $_GET['matric'];

        // Create an instance of the Database class and get the connection
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $userData = $user->getUserByMatric($matric); // Assumes a method to fetch a user by matric

        if ($userData) {
            $matric = $userData['matric']; // Ensure matric is editable
            $name = $userData['name'];
            $role = $userData['role'];
        } else {
            $message = "User not found.";
        }

        $db->close();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle the update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);

        if ($user->updateUser($matric, $name, $role)) {
            $message = "User updated successfully!";
        } else {
            $message = "Failed to update the user.";
        }

        $db->close();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        form {
            display: inline-block;
            text-align: left;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label {
            display: inline-block;
            width: 100px;
        }

        input[type="text"] {
            width: 200px;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
        }

        a.green-link {
            color: green;
        }

        a.red-link {
            color: red;
        }

        h1 {
            margin-bottom: 20px;
        }

        figure {
            margin: 20px 0;
            text-align: center;
            font-style: italic;
        }

        .message {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Update User</h1>
    <form action="update.php" method="POST">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($matric); ?>" required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>

        <label for="role">Access Level:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($role); ?>" required><br>

        <button type="submit">Update</button>
        <a href="showData.php" class="red-link">Cancel</a>
    
    </form>

   
    <!-- Display a message if available -->
    <?php if (!empty($message)): ?>
        <p class="message"> <?php echo htmlspecialchars($message); ?> </p>
    <?php endif; ?>
</body>

</html>
