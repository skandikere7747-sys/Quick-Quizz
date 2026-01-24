<?php
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home - QuickQuiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="profile-container">
    <h2>Hi, <?php echo htmlspecialchars($username); ?>!</h2>
    
    <a class="button" href="quiz.php">Take a Quiz</a>
    <a class="button" href="profile.php">My Profile</a>
    <a class="button" href="logout.php">Logout</a>
</div>

</body>
</html>
