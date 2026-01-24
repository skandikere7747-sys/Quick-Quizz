<?php
session_start();
include('config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user'];

/* Fetch user summary */
$stmt = $conn->prepare("SELECT quizzes_completed FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

$completed = (int)$user['quizzes_completed'];

/* Fetch best score */
$stmt = $conn->prepare(
    "SELECT MAX(score) AS best_score FROM quiz_history WHERE username = ?"
);
$stmt->bind_param("s", $username);
$stmt->execute();
$bestResult = $stmt->get_result();
$bestScore = $bestResult->fetch_assoc()['best_score'] ?? 0;

/* Fetch last quiz */
$stmt = $conn->prepare(
    "SELECT score, total_questions, taken_at 
     FROM quiz_history 
     WHERE username = ? 
     ORDER BY taken_at DESC 
     LIMIT 1"
);
$stmt->bind_param("s", $username);
$stmt->execute();
$lastQuiz = $stmt->get_result()->fetch_assoc();

/* Fetch recent history */
$stmt = $conn->prepare(
    "SELECT score, total_questions, taken_at 
     FROM quiz_history 
     WHERE username = ? 
     ORDER BY taken_at DESC 
     LIMIT 5"
);
$stmt->bind_param("s", $username);
$stmt->execute();
$history = $stmt->get_result();

/* Level */
$level = $completed >= 10 ? "Quiz Master 🧠" : ($completed >= 5 ? "Quiz Pro 🚀" : "Quiz Rookie 🌱");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile - QuickQuiz</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .stat-box {
            text-align: center;
            background: #f5f7fa;
            padding: 15px;
            border-radius: 8px;
            width: 30%;
        }
        .history li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h2>👤 My Profile</h2>

    <p><strong>Username:</strong> <?= htmlspecialchars($username); ?></p>
    <p><strong>Status:</strong> <?= $level; ?></p>

    <div class="stats">
        <div class="stat-box">
            <h3><?= $completed; ?></h3>
            <small>Quizzes Completed</small>
        </div>
        <div class="stat-box">
            <h3><?= $bestScore; ?></h3>
            <small>Best Score</small>
        </div>
        <div class="stat-box">
            <h3>
                <?= $lastQuiz ? $lastQuiz['score'].'/'.$lastQuiz['total_questions'] : '—'; ?>
            </h3>
            <small>Last Quiz</small>
        </div>
    </div>

    <h3>📜 Recent Quiz History</h3>
    <ul class="history">
        <?php if ($history->num_rows > 0): ?>
            <?php while ($row = $history->fetch_assoc()): ?>
                <li>
                    <?= $row['score']; ?>/<?= $row['total_questions']; ?> 
                    on <?= date("M d, Y", strtotime($row['taken_at'])); ?>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>No quizzes taken yet.</li>
        <?php endif; ?>
    </ul>

    <br>
    <a href="home.php" class="button">⬅ Back to Home</a>
</div>

</body>
</html>
