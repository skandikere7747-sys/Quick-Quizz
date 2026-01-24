document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    if (!form) return;

    form.addEventListener("submit", (e) => {
        const questions = document.querySelectorAll("[data-question]");
        let allAnswered = true;

        questions.forEach(q => {
            const checked = q.querySelector("input[type='radio']:checked");
            if (!checked) {
                allAnswered = false;
            }
        });

        if (!allAnswered) {
            e.preventDefault();
            alert("Please answer all questions before submitting the quiz.");
        }
    });
});
