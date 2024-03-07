<?php
// Connect to MySQL database
$conn = new mysqli("db-mongodb-nyc3-14514sara-do-user-159858530-0.c.db.digitalocean.com", "doadmin", "AVNS_WMIAiBDGsjjlsIK44lG", "defaultdb", 25060);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Query the database for the user using prepared statement
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and verify password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        echo "Login successful!";
        // Redirect to the dashboard or home page
        // header("Location: dashboard.php");
        // Don't forget to call exit() after a redirect header is sent
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>

