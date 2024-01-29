<?php
session_start();
header('Content-Type: application/json'); // Set content type to JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database (replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials)
    $conn = new mysqli('localhost', 'root', 'qwerty', 'to_do_list_v2');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to insert user data
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Registration successful
        $_SESSION['success_message'] = "Registration successful!";
        echo json_encode(['success' => true, 'message' => 'Registration successful!', 'redirect' => '/todoList.php']);
    } else {
        // Registration failed
        error_log("Error during registration: " . $stmt->error);
        echo json_encode(['success' => false, 'error' => 'Registration failed. Please try again.']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
