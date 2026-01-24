<?php
include "config.php";
$score = 0;

$result = $conn->query("SELECT * FROM quizzes");
while ($q = $result->fetch_assoc()) {
    if (isset($_POST['q'.$q['id']]) && $_POST['q'.$q['id']] == $q['correct_option']) {
        $score++;
    }
}

$totalQuestions = count($questions);

// Save quiz history
$stmt = $conn->prepare(
    "INSERT INTO quiz_history (username, score, total_questions) VALUES (?, ?, ?)"
);
$stmt->bind_param("sii", $username, $score, $totalQuestions);
$stmt->execute();

$conn->query("UPDATE users SET quizzes_completed = quizzes_completed + 1 WHERE id=".$_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h2>Your Score: <?= $score ?></h2>
<a href="home.php">Back Home</a>
</div>
</body>
</html>
