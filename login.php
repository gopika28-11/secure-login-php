<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check failed attempts in the last 15 minutes
    $stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE username = ? AND success = 0 AND attempt_time > (NOW() - INTERVAL 15 MINUTE)");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['attempts'] >= 5) {
        echo "Account locked. Try again in 15 minutes.";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Correct login
            $log = $conn->prepare("INSERT INTO login_attempts (username, success) VALUES (?, 1)");
            $log->bind_param("s", $username);
            $log->execute();

            $_SESSION['username'] = $username;
            echo "Login successful! Welcome, " . htmlspecialchars($username);
        } else {
            // Wrong password or username
            $log = $conn->prepare("INSERT INTO login_attempts (username, success) VALUES (?, 0)");
            $log->bind_param("s", $username);
            $log->execute();

            echo "Invalid username or password.";
        }
    }
}
?>

<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>