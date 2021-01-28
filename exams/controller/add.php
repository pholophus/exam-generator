<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['save'])) {
    $name = $_POST['e_name'];
    $total = $_POST['e_total'];
    $subId = $_POST['sub_id'];

    mysqli_query($link, "INSERT INTO exams (e_name, e_total, subjectId) VALUES ('$name', '$total', '$subId')"); 
    $_SESSION['message'] = "Exam saved"; 
    header("location: ../view/home.php?subId=$subId");
}