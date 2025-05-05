document.addEventListener('DOMContentLoaded', () => {
  const answerButtons = document.querySelectorAll('.answer-btn');
  const userAnswers = {}; // Object to store user answers

  // Handle answer button clicks
  answerButtons.forEach(button => {
    button.addEventListener('click', () => {
      console.log('Clicked button:', button);
      const questionId = button.getAttribute('data-question-id');
      const answerId = button.getAttribute('data-answer-id');

      // Remove previous selection for this question
      document.querySelectorAll(`.answer-btn[data-question-id='${questionId}']`)
              .forEach(btn => btn.classList.remove('selected'));

      // Mark new selection
      button.classList.add('selected');
      console.log('Class list after adding selected:', button.classList);

      // Store user answer
      userAnswers[questionId] = answerId;

      // Mark question as answered
      const testCard = button.closest('.test-card');
      if (testCard) {
        testCard.classList.add('answered');
      }

      // Update answered count
      updateAnsweredCount();
    });
  });

  // Function to update answered count
  function updateAnsweredCount() {
    const total = document.querySelectorAll('.test-card').length;
    const answered = document.querySelectorAll('.test-card.answered').length;
    document.getElementById('answered-count').textContent = `${answered}/${total}`;
  }

  // Handle submit button click
  const submitButton = document.querySelector('#submit-test');
  if (submitButton) {
    submitButton.addEventListener('click', () => {
      // Check if at least 2 questions are answered
      if (Object.keys(userAnswers).length < 2) {
        alert("Bạn chưa trả lời đủ ít nhất 2 câu!");

        // Scroll to the first unanswered question
        const unansweredCard = document.querySelector('.test-card:not(.answered)');
        if (unansweredCard) {
          unansweredCard.scrollIntoView({ behavior: "smooth", block: "center" });
        }
        return;
      }

      // Send data to server
      fetch("submit_test.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(userAnswers)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        const score = data.score;
        if (typeof score !== "undefined" && score >= 0) {
          window.location.href = `result.php?score=${score}`;
        } else {
          alert("Đã có lỗi xảy ra khi tính điểm. Vui lòng thử lại!");
        }
      })
      .catch(error => {
        console.error("Lỗi khi gửi dữ liệu:", error);
        alert("Có lỗi khi gửi dữ liệu, vui lòng thử lại.");
      });
    });
  }
});