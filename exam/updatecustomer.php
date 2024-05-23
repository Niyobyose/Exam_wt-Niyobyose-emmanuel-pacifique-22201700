<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $service = $_POST['service'];

    // Prepare and bind statement
    $stmt = $conn->prepare("UPDATE customer SET name=?, age=?, service=? WHERE id=?");
    
    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sisi", $name, $age, $service, $id);

    // Execute query
    if ($stmt->execute()) {
        echo "Data updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>