<?php
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

    // 🔥 INSERT quiz history (THIS WAS MISSING)
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
        .quiz-container form {
            display: flex;
            flex-direction: column;
        }

        .question-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .question-box h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #2c3e50;
        }

        .question-box label {
            display: block;
            padding: 8px 10px;
            margin-bottom: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .question-box input[type="radio"] {
            margin-right: 10px;
        }

        .question-box label:hover {
            background-color: #e6f2ff;
        }

        .submit-btn {
            width: 120px;
            padding: 8px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <h2>Quiz Time!</h2>

    <?php if(isset($message)): ?>
        <div class='message'><?php echo $message; ?></div>
        <!-- Add a button to go back -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="home.php" class="submit-btn" style="text-decoration:none;">Go Back Home</a>
        </div>
    <?php else: ?>
        <form method="POST">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-box">
                    <h3>Q<?php echo $index + 1; ?>: <?php echo htmlspecialchars($q['question']); ?></h3>
                    <?php
                        $qid = $q['id'];
                        $options = [
                            'A' => $q['option_a'],
                            'B' => $q['option_b'],
                            'C' => $q['option_c']
                        ];
                        foreach ($options as $key => $value) {
                            echo '<label><input type="radio" name="answer_'.$qid.'" value="'.$key.'" required> '.htmlspecialchars($value).'</label>';
                        }
                    ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-btn">Submit Quiz</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
