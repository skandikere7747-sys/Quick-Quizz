
USE if0_40955533_quickquizdata;

-- Remove old quiz questions
TRUNCATE TABLE quizzes;

-- Insert fun, casual, teamwork-focused questions
INSERT INTO quizzes (question, option_a, option_b, option_c, correct_option) VALUES
('What is the BEST way to handle a disagreement with a teammate?', 
 'Ignore it and hope it goes away', 
 'Talk it out respectfully and early', 
 'Complain to another coworker', 
 'B'),

('Which habit improves team communication the most?', 
 'Regular check-ins and updates', 
 'Assuming everyone already knows', 
 'Only talking when something breaks', 
 'A'),

('When a teammate is struggling, what should you do first?', 
 'Wait for the manager to notice', 
 'Offer help or ask how you can support them', 
 'Focus only on your own tasks', 
 'B'),

('What makes meetings more effective?', 
 'Clear agenda and time limits', 
 'More people invited just in case', 
 'No notes or follow-ups', 
 'A'),

('What is the healthiest response to constructive feedback?', 
 'Take it personally', 
 'Listen, reflect, and improve', 
 'Defend yourself immediately', 
 'B'),

('Which action builds trust within a team?', 
 'Taking credit for group work', 
 'Being reliable and honest', 
 'Only speaking up when it benefits you', 
 'B'),

('What should a team do after completing a big project?', 
 'Immediately move on to the next task', 
 'Blame mistakes and move forward', 
 'Review what worked and celebrate wins', 
 'C'),

('What is the best way to avoid misunderstandings at work?', 
 'Over-communicate expectations clearly', 
 'Assume everyone thinks the same way', 
 'Only communicate through chat', 
 'A');