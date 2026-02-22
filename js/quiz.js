document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector("form");
    if (!form) return;

    const questionBoxes = document.querySelectorAll(".question-box");
    const totalQuestions = questionBoxes.length;

    const progressFill = document.getElementById("progressFill");
    const answeredCount = document.getElementById("answeredCount");

    // =============================
    // UPDATE PROGRESS BAR
    // =============================
    function updateProgress() {
        let answered = 0;

        questionBoxes.forEach(box => {
            const checked = box.querySelector("input[type='radio']:checked");
            if (checked) answered++;
        });

        const percent = (answered / totalQuestions) * 100;

        if (progressFill) progressFill.style.width = percent + "%";
        if (answeredCount) answeredCount.textContent = answered;
    }

    // Attach change listener to ALL radios
    document.querySelectorAll("input[type='radio']").forEach(radio => {
        radio.addEventListener("change", function () {
            updateProgress();

            // Remove red border when answered
            const parentBox = radio.closest(".question-box");
            if (parentBox) {
                parentBox.style.border = "1px solid #ddd";
            }
        });
    });

    updateProgress();

    // =============================
    // FORM SUBMIT VALIDATION
    // =============================
    form.addEventListener("submit", function (e) {

        let firstUnanswered = null;
        let hasError = false;

        questionBoxes.forEach(box => {
            const checked = box.querySelector("input[type='radio']:checked");

            if (!checked) {
                box.style.border = "2px solid #e74c3c";
                hasError = true;

                if (!firstUnanswered) {
                    firstUnanswered = box;
                }
            } else {
                box.style.border = "1px solid #ddd";
            }
        });

        if (hasError) {
            e.preventDefault();

            // Smooth scroll to first unanswered
            firstUnanswered.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        }
    });

});
