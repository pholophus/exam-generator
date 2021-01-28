<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['save'])) {
    $name = $_POST['c_name'];
    $subId = $_POST['sub_id'];

    $s = mysqli_query($link, "INSERT INTO chapters (c_name, subjectId) VALUES ('$name', '$subId')"); 

    if($s){
        $_SESSION['message'] = "Chapter saved"; 
        header("location: ../view/home.php?subId=$subId");
    }else{
        $_SESSION['message'] = "Chapter failed to save"; 
        header("location: ../view/home.php?subId=$subId");
    }
    
}