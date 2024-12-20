<?php
class Database
{
    // Update these with your actual database credentials
    private $host = "localhost"; // Use "localhost" or the IP address of your database server
    private $db_name = "lab_5b"; // The name of your database
    private $username = "root";  // Default username for XAMPP/WAMP is "root"
    private $password = "";      // Default password for XAMPP/WAMP is an empty string
    public $conn;

    // Method to get the database connection
    public function getConnection()
    {
        // Create a new connection using MySQLi
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
?>
