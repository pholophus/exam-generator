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

    echo "<a href='home.php?subId=".$subId."' class='btn btn-default'>Back</a>";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                ?>
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h2>View Record</h2>
                                    </div>
                                    <p>Please fill this form and submit to add employee record to the database.</p>
                                    <form action="../controller/edit.php" method="post">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="e_name" class="form-control" value="<?=$row['e_name']?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Marks</label>
                                            <input type="text" name="e_total" class="form-control" value="<?=$row['e_total']?>" disabled>
                                        </div>
                                        <input type="hidden" name="edit_id" value="<?php echo $param_id; ?>">
                                        <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">

                                        
                                    </form>
                                </div>
                            </div>        
                        </div>
                    </div>
                <?php
            }
        }
    }
    $sqlQues = "SELECT * FROM questions WHERE subjectId = $subId ";
    if($result = mysqli_query($link, $sqlQues)){
        if(mysqli_num_rows($result) > 0){
            $no =0;
            while($row = mysqli_fetch_array($result)){
                $no++;
                ?><div class='card'>
                        <div class='card-header'>
                            Test
                        </div>
                        <div class='card-body'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='check1'>
                                    <p>Question <?= $no ?>: <?=$row['q_question']?></p>
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
    }
?>