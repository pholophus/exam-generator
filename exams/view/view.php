<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}else{
    include('../../header.php');
    require_once "../../config.php";
    $param_id = $_GET["id"];
    $subId = $_GET["subId"];
    $sql = "SELECT * FROM exams WHERE e_id = $param_id";

    ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <?php
                                if($result = mysqli_query($link, $sql)){
                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_array($result)){
                                        ?>
                                            <div class="col-md-3">
                                                <a href='home.php?subId=<?php echo($subId);?>' class='btn btn-danger'>Back</a>
                                            </div>
                                            
                                            <div class="col-md-6 text-center">
                                                <h4><?php echo($row['e_name']);?></h4>
                                            </div>

                                            <div class="col-md-3 text-right">
                                                <h4>Total marks: <?=$row['e_total']?></h4>
                                            </div>
                                        <?php
                                        }
                                    }
                                }     
                            ?>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            $sqlQues = "SELECT exams.*, exam_paper.*, questions.* FROM exam_paper INNER JOIN exams ON exam_paper.ep_exam = exams.e_id INNER JOIN questions ON exam_paper.ep_question = questions.q_id WHERE exams.e_id = $param_id";
    
                            if($result = mysqli_query($link, $sqlQues)){
                                if(mysqli_num_rows($result) > 0){
                                    $no = 0;
                                    while($row = mysqli_fetch_array($result)){
                                        $no++;
                                        ?>
                                            <div class='card my-4'>
                                                <div class='card-header'>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Question no.<?= $no;?>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                        <div class="col-md-3 text-right">
                                                            <a class="btn btn-primary" href="../../questions_subject/view/view.php?subId=<?php echo($subId);?>&id=<?php echo($row['q_id']);?>">View</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='card-body'>
                                                    <div class='form-check-inline'>
                                                        <label class='form-check-label' for='check1'>
                                                            <p>Question: <?=$row['q_question']?></p>
                                                            <p>Mark: <?=$row['q_mark']?></p>
                                                            <p>Question Level: <?=$row['q_level']?></p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                    // Free result set
                                    mysqli_free_result($result);
                                } else{
                                    echo "<p class='lead'><em>No records were found.</em></p>";
                                }
                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
    <?php

    
}
?>