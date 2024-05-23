<?php
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

// Check if Product_Id is set
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
//product (id,barcode,category_id, name,cost,quantity,total_cost,created_at
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM login WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['id'];
    $b = $row['username'];
    $c = $row['password'];
   
  } else {
    echo "user not found.";
  }
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Update your account table</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form in account</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="name">username:</label>
    <input type="text" name="username" id="username" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="address">password:</label>
    <input type="text" name="password" id="password" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>

    

    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($stmt->execute()) {
      echo "Record updated successfully.<br><br>echo 
           <a href='trainees.php'>OK</a>";
  } else {
      echo "Error updating data: " . $stmt->error;
  }
}
if (isset($_POST['update'])) {
  // Retrieve updated values from form
  $id = $_POST['id'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  

  // Update the trainee in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE `login` SET `username` = ?, `password` = ? WHERE `login`.`id` = ?;);
  $stmt->bind_param("sssi",$id, $username, $password);
  $stmt->execute();

  // Redirect to product.php
  header('Location: trainees.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>
