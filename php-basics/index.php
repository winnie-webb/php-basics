<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php Basics</title>
</head>
<body>
<?php
// Server-side validation for form input before interacting with the database

// Connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form input
    $user_username = trim($_POST['username']);
    $user_email = trim($_POST['email']);

    $errors = [];

    // Validate the username (must be between 3 and 15 characters)
    if (empty($user_username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($user_username) < 3 || strlen($user_username) > 15) {
        $errors[] = "Username must be between 3 and 15 characters.";
    }

    // Validate the email (must be a valid email address)
    if (empty($user_email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // If there are no validation errors, interact with the database
    if (empty($errors)) {
        // Check if the username or email already exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $user_username, $user_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Username or email already exists.";
        } else {
            // Insert into the database if validation passes
            $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $user_username, $user_email);
            if ($stmt->execute()) {
                echo "User registered successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    // Output validation errors if any
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}

$conn->close();
?>

</body>
</html>