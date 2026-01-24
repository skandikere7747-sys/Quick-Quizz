CREATE TABLE quiz_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
