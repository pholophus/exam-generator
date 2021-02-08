<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['save'])) {
    $name = $_POST['e_name'];
    $total = $_POST['e_total'];
    $subId = $_POST['subId'];
    $questions = $_POST['question'];
    $key = uniqid("exam");

    print_r($questions);

    $no = sizeof($questions);

    $exam = mysqli_query($link, "INSERT INTO exams (e_name, e_total, subjectId, e_key) VALUES ('$name', '$total', '$subId', '$key')"); 
    
    $sql = "SELECT * FROM exams WHERE e_key = '$key'";
    $id = 0;

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $id = $row['e_id'];
                echo($row['e_id']);
            }
        }
    }

    echo("id ".$id);

    for($i=0; $i< count($questions); $i++){
        $q_seperate = explode(" ",$questions[$i]);
        $qid = $q_seperate[0];
       mysqli_query($link, "INSERT INTO exam_paper (ep_exam, ep_question) VALUES ('$id', '$qid')");
    }

    
    $_SESSION['message'] = "Exam saved"; 
    header("location: ../view/home.php?subId=$subId");
}