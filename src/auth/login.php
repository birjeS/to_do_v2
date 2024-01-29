<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database (replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials)
    $conn = new mysqli('localhost', 'root', 'qwerty', 'to_do_list_v2');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to retrieve user data
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $hashedPassword); // Assuming password is stored as hashed

    // Fetch the result
    $success = $stmt->fetch();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    if ($success) {
        if (password_verify($password, $hashedPassword)) {
            // Login successful
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            echo json_encode(['success' => true, 'redirect' => './todoList.php']);
            exit();
        } else {
            // Password verification failed
            echo json_encode(['success' => false, 'error' => 'Password verification failed']);
        }
    } else {
        // Email not found in the database
        echo json_encode(['success' => false, 'error' => 'Email not found in the database']);
    }
}