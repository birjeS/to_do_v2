<?php
session_start();
header('Content-Type: application/json');

// Replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials
$conn = new mysqli('localhost', 'root', 'qwerty', 'to_do_list');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle CRUD operations for todos
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Get all todos
    $result = $conn->query("SELECT * FROM todos");
    $todos = [];
    while ($row = $result->fetch_assoc()) {
        $todos[] = $row;
    }
    echo json_encode($todos);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Add a new todo
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data['title'];
    $conn->query("INSERT INTO todos (title) VALUES ('$title')");
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Delete a todo
    $id = $_GET['id'];
    $conn->query("DELETE FROM todos WHERE id=$id");
}

$conn->close();
?>
