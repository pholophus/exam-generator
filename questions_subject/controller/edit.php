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
    $id = $_POST['edit_id'];
    $chap = 0;
    $exam = 0;

	$q = mysqli_query($link, "UPDATE questions SET q_question='$question', q_answer='$answer', q_mark='$mark', q_level='$level', chapterId = '$chap', examId = '$exam', subjectId = '$subId' WHERE q_id='$id'");
    
    if($q){
        $_SESSION['message'] = "Question updated"; 
        header("location: ../view/home.php?subId=$subId");
    }else{
        $_SESSION['message'] = "Question failed to update"; 
        header("location: ../view/home.php?subId=$subId");
    }
    
}