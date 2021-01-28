<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['e_name'];
    $total = $_POST['e_total'];
    $subId = $_POST['subject_id'];
    $id = $_POST['edit_id'];

    mysqli_query($link, "UPDATE exams SET e_name='$name', e_total='$total' WHERE e_id='$id'");
    
    $questions = $_POST['question'];
    
    $no = sizeof($questions);

    for($i=0; $i< count($questions); $i++){
        $qid = $questions[$i];
        mysqli_query($link, "UPDATE questions SET examId = '$id' WHERE q_id='$qid'");
    }
    
    $_SESSION['message'] = "Exam updated"; 
    //header("location: ../view/home.php?subId=$subId");
}
