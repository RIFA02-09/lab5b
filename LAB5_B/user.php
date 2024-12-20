<?php
class User
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new user
    public function createUser($matric, $name, $password, $role)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $matric, $name, $password, $role);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return true;
            } else {
                return "Error executing statement: " . $stmt->error;
            }
        } else {
            return "Error preparing statement: " . $this->conn->error;
        }
    }

    // Read all users
    public function getUsers()
    {
        // Prepare the SQL query to select users
        $sql = "SELECT matric, name, role FROM users";
        
        // Check if the database connection is valid
        if ($this->conn->connect_error) {
            return "Error: " . $this->conn->connect_error;
        }
    
        // Execute the query
        $result = $this->conn->query($sql);
    
        // Check if the query was successful
        if ($result) {
            // Initialize an empty array to hold users
            $users = [];
            
            // Fetch each row and add it to the users array
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            
            // Return the users array
            return $users;
        } else {
            // Return an error message if the query fails
            return "Error: " . $this->conn->error;
        }
    }
    

    // Read a single user by matric
    public function getUser($matric)
    {
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $matric);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            return $user ? $user : null; // Return null if no user found
        } else {
            return "Error preparing statement: " . $this->conn->error;
        }
    }

    // Update a user's information
    public function updateUser($matric, $name, $role)
    {
        $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $name, $role, $matric);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return true;
            } else {
                return "Error executing statement: " . $stmt->error;
            }
        } else {
            return "Error preparing statement: " . $this->conn->error;
        }
    }
    public function getUserByMatric($matric)
    {
        try {
            $query = "SELECT * FROM users WHERE matric = :matric LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':matric', $matric);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Delete a user by matric
    public function deleteUser($matric)
    {
        $sql = "DELETE FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $matric);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return true;
            } else {
                return "Error executing statement: " . $stmt->error;
            }
        } else {
            return "Error preparing statement: " . $this->conn->error;
        }
    }
}
