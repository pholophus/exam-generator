<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['c_name'];
    $subId = $_POST['sub_id'];

    $c = mysqli_query($link, "INSERT INTO chapters (c_name, subjectId) VALUES ('$name', '$subId')"); 

    if($c){
        $_SESSION['message'] = "Chapter saved"; 
        header("location: ../view/home.php?subId=$subId");
    }else{
        $_SESSION['message'] = "Chapter failed to save"; 
        header("location: ../view/home.php?subId=$subId");
    }
    
}