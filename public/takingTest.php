<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Taking Test - Test | VHuB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style4TakingTest.css">
  <link rel="icon" href="img/logo.ico" type="image/x-icon">
  <style>
    /* Tô màu nút đáp án được chọn */
    .answer-btn.selected {
      background-color:rgba(51, 33, 76, 0.55) !important; /* Màu xanh lá cây */
      color: #fff !important; /* Chữ trắng */
      border-color: rgba(51, 33, 76, 0.55) !important; /* Viền cùng màu */
    }
  </style>
</head>
<body>

  <div class="container-fluid test-header d-flex justify-content-between align-items-center sticky-top">
    <div class="d-flex align-items-center">
      <img src="img/grammar.png" alt="Icon" width="40" class="me-2">
      <h4 class="mb-0">Test</h4>
    </div>
    <div class="text-center w-100">
        <div id = "answered-count">0/20</div>
        <small>Vietnamese Proficiency Test</small>
    </div>
    <button class="btnQuit">Quit Test</button>
  </div>

  <div class="container mt-5" id="question-list">
    <?php
    $sql = "SELECT q.question_id, q.question_text, a.answer_id, a.answer_text 
            FROM questions q
            JOIN answer_options a ON q.question_id = a.question_id
            WHERE q.test_id = 1
            ORDER BY q.question_id, a.answer_id";

    $result = $conn->query($sql);
    $questions = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $qid = $row['question_id'];
            if (!isset($questions[$qid])) {
                $questions[$qid] = [
                    'text' => $row['question_text'],
                    'answers' => []
                ];
            }
            $questions[$qid]['answers'][] = [
                'id' => $row['answer_id'],
                'text' => $row['answer_text']
            ];
        }

        $index = 1;
        foreach ($questions as $qid => $qdata) {
            echo "<div class='test-card mb-4'>";
            echo "<div class='d-flex justify-content-between'>";
            echo "<p class='question'>{$qdata['text']}</p>";
            echo "<small>{$index} of 20</small>";
            echo "</div>";
            echo "<div class='row text-center'>";
            foreach ($qdata['answers'] as $answer) {
                echo "<div class='col-md-6 mb-2'>";
                echo "<button class='btn btn-outline-secondary answer-btn' data-question-id='{$qid}' data-answer-id='{$answer['id']}'>{$answer['text']}</button>";
                echo "</div>";
            }
            echo "</div>";
            echo "<div class='text-center mt-3'><a href='#' class='skip-btn'>Skip</a></div>";
            echo "</div>";
            $index++;
        }
    } else {
        echo "<p>No questions found.</p>";
    }
    ?>
    
    <!-- Nút Submit ở cuối -->
    <div class="text-center my-4">
      <button class="btn btn-lg" style="background-color: #FBBA49; color: #fff" id="submit-test">Submit Test</button>
    </div>
  </div>

  <script src="script4TakingTest.js"></script>
</body>
</html>
