

<?php
session_start();
require_once "../../config.php";

if (isset($_POST['submit'])) {

    $q1 = $q2 = $q3 = $q4 = $q5 = $q6 = "";
    $qid1 = $qid2 = $qid3 = $qid4 = $qid5 = $qid6 = null;
    $ids = array();
    $filtered_ids = array();
    $key = uniqid("exam");
    $total = 0;
    $subId = $_POST['subject_id'];
    $name = $_POST['exam_name'];

    if(isset($_POST['ques_level_one'])){
        $q1 = $_POST['ques_level_one'];
        $qid1 = explode( '_', $q1 );
        $ids = array_merge($ids,$qid1);
    }
    if(isset($_POST['ques_level_two'])){
        $q2 = $_POST['ques_level_two'];
        $qid2 = explode( '_', $q2 );
        $ids = array_merge($ids,$qid2);
    }
    if(isset($_POST['ques_level_three'])){
        $q3 = $_POST['ques_level_three'];
        $qid3 = explode( '_', $q3 );
        $ids = array_merge($ids,$qid3);
    }
    if(isset($_POST['ques_level_four'])){
        $q4 = $_POST['ques_level_four'];
        $qid4 = explode( '_', $q4 );
        $ids = array_merge($ids,$qid4);
    }
    if(isset($_POST['ques_level_five'])){
        $q5 = $_POST['ques_level_five'];
        $qid5 = explode( '_', $q5 );
        $ids = array_merge($ids,$qid5);
    }
    if(isset($_POST['ques_level_six'])){
        $q6 = $_POST['ques_level_six'];
        $qid6 = explode( '_', $q6 );
        $ids = array_merge($ids,$qid6);
    }

    foreach($ids as $id){
        if($id != ""){
            array_push($filtered_ids, $id);         
        }
    }

    $sql_marks = "SELECT * FROM questions WHERE q_id IN (".implode(',',$filtered_ids).")";

    if($result_marks = mysqli_query($link, $sql_marks)){
        if(mysqli_num_rows($result_marks) > 0){
            while($row_marks = mysqli_fetch_array($result_marks)){
                $total += $row_marks["q_mark"];
            }
        }
    }

    echo($total);

    $exam = mysqli_query($link, "INSERT INTO exams (e_name, e_total, subjectId, e_key) VALUES ('$name', '$total', '$subId', '$key')");

    $sql = "SELECT * FROM exams WHERE e_key = '$key'";

    $id = 0;

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $id = $row['e_id'];
            }
        }
    }

    foreach($filtered_ids as $filter){
        $exam_paper = mysqli_query($link, "INSERT INTO exam_paper (ep_exam, ep_question) VALUES ('$id', '$filter')");
    }

    //var_dump($filtered_ids);
    
    
    /*mysqli_query($link, "INSERT INTO exams (e_name, e_total, subjectId) VALUES ('$name', '$total', '$subId')"); 
    $_SESSION['message'] = "Exam saved"; */
    header("location: ../view/home.php?subId=$subId");
}