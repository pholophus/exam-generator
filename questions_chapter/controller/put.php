<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['update'])) {
    $question = $_POST['q_question'];
    $answer = $_POST['q_answer'];
    $mark = $_POST['q_mark'];
    $level = $_POST['q_level'];
    $subId = $_POST['subject_id'];
    $chapId = $_POST['chapterId'];

    mysqli_query($link, "INSERT INTO questions (q_question, q_answer, q_mark, q_level, subjectId, chapterId, examId) VALUES ('$question', '$answer', '$mark', '$level', '$subId', $chapId, 0)"); 
    $_SESSION['message'] = "Question saved"; 
    header("location: ../view/home.php?subId=$subId&chapId=$chapId");
} 