<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QuickQuiz</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Full page center */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6dd5fa, #ffffff);
        }

        .container {
            text-align: center;
            background: #fff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            max-width: 400px;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 12px 25px;
            border-radius: 8px;
            background: #4CAF50;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to QuickQuiz</h2>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    </div>
</body>
</html>
