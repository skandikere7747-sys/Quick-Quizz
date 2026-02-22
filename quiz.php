<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user'];

// Fetch all questions
$result = $conn->query("SELECT * FROM quizzes");
$questions = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
} else {
    die("No questions found in the database.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;

    foreach ($questions as $q) {
        $qid = $q['id'];
        if (isset($_POST["answer_$qid"]) && $_POST["answer_$qid"] === $q['correct_option']) {
            $score++;
        }
    }

    $totalQuestions = count($questions);

    // Update completed count
    $stmt = $conn->prepare(
        "UPDATE users SET quizzes_completed = quizzes_completed + 1 WHERE username = ?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Insert quiz history
    $stmt = $conn->prepare(
        "INSERT INTO quiz_history (username, score, total_questions)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sii", $username, $score, $totalQuestions);
    $stmt->execute();

    $message = "You scored $score out of $totalQuestions";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz - QuickQuiz</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .quiz-container { max-width: 700px; margin: auto; }

        .question-box {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            transition: border 0.2s ease;
        }

        .question-box h3 { margin-bottom: 10px; }

        .question-box label {
            display: block;
            padding: 8px;
            margin-bottom: 6px;
            border-radius: 6px;
            cursor: pointer;
        }

        .question-box label:hover {
            background-color: #e6f2ff;
        }

        .submit-btn {
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .submit-btn:hover { background: #45a049; }

        /* Progress Bar */
        .progress-container { margin-bottom: 20px; }

        .progress-text {
            text-align: right;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .progress-bar {
            width: 100%;
            background: #eee;
            border-radius: 8px;
            overflow: hidden;
            height: 10px;
        }

        .progress-fill {
            height: 10px;
            background: #4CAF50;
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <h2>Quiz Time!</h2>

    <?php if(isset($message)): ?>
        <p><strong><?= $message ?></strong></p>
        <a href="home.php" class="submit-btn">Back Home</a>
    <?php else: ?>
        <form method="POST">

            <!-- Progress Indicator -->
            <div class="progress-container">
                <div class="progress-text">
                    Answered <span id="answeredCount">0</span> of <?= count($questions); ?>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
            </div>

            <?php foreach ($questions as $index => $q): ?>
                <div class="question-box">
                    <h3>Q<?= $index + 1 ?>: <?= htmlspecialchars($q['question']); ?></h3>

                    <?php
                        $qid = $q['id'];
                        $options = [
                            'A' => $q['option_a'],
                            'B' => $q['option_b'],
                            'C' => $q['option_c']
                        ];

                        foreach ($options as $key => $value) {
                            echo '<label>
                                <input type="radio" name="answer_'.$qid.'" value="'.$key.'">
                                '.htmlspecialchars($value).'
                              </label>';
                        }
                    ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-btn">Submit Quiz</button>
        </form>
    <?php endif; ?>
</div>

<script src="/js/quiz.js"></script>

</body>
</html>
