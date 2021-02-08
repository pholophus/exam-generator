<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['s_name'];
    $code = $_POST['s_code'];
    $userId = $_SESSION["id"];

    $s = mysqli_query($link, "INSERT INTO subjects (s_name, s_code, userId) VALUES ('$name', '$code', '$userId')"); 

    if($s){
        $_SESSION['message'] = "Subject saved"; 
        header('location: ../view/home.php');
    }else{
        $_SESSION['message'] = "Subject failed to save"; 
        header('location: ../view/home.php');
    }
    
}