<?php
// Include database connection and User class
include 'Database.php';
include 'User.php';

try {
    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);

    // Fetch all registered users
    $result = $user->getUsers(); // Make sure this returns an array
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
} finally {
    // Ensure the database connection is closed when the script ends
    if (isset($db)) {
        $db->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions a {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid black;
            border-radius: 3px;
            background-color: #007BFF;
            color: white;
        }

        .actions a.delete {
            background-color: #DC3545;
        }

        .actions a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Registered Users</h1>
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['matric']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td class="actions">
                            <a href="update.php?matric=<?php echo urlencode($row['matric']); ?>">Update</a>
                            <a href="delete.php?matric=<?php echo urlencode($row['matric']); ?>" class="delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
