<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $error = "Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if($stmt->execute()){
            $_SESSION['user'] = $username;
            header("Location: home.php");
            exit;
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register - QuickQuiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <h2>Register</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>

        <input type="submit" value="Register">
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>
</body>
</html>
