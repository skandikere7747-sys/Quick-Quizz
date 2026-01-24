USE if0_40955533_quickquizdata;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    quizzes_completed INT DEFAULT 0
);

CREATE TABLE quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    option_a VARCHAR(100),
    option_b VARCHAR(100),
    option_c VARCHAR(100),
    correct_option CHAR(1)
);

INSERT INTO quizzes (question, option_a, option_b, option_c, correct_option) VALUES
('What does HTML stand for?', 'HyperText Markup Language', 'HighText Machine Language', 'HyperTool Multi Language', 'A'),
('Which language runs in a browser?', 'PHP', 'JavaScript', 'Python', 'B');
