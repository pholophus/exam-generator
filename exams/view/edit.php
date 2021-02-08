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

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                ?>
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card mt-5">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6 text-center">
                                                    <h4>Edit exam paper</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            

                                            <form action="../controller/edit.php" method="post">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="e_name" class="form-control" value="<?=$row['e_name']?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Marks</label>
                                                    <input type="text" name="e_total" class="form-control" value="<?=$row['e_total']?>" required>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header text-center">
                                                        <h5>List of chosen questions:</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                            $sqlc = "SELECT exams.*, exam_paper.*, questions.* FROM exam_paper INNER JOIN exams ON exam_paper.ep_exam = exams.e_id INNER JOIN questions ON exam_paper.ep_question = questions.q_id WHERE exams.e_id = $param_id";
                                                            if($resultc = mysqli_query($link, $sqlc)){
                                                                if(mysqli_num_rows($resultc) > 0){
                                                                    $no =0;
                                                                    while($row = mysqli_fetch_array($resultc)){
                                                                        $no++;
                                                                        ?><div class='card mb-3'>
                                                                                <div class='card-header'>
                                                                                    No <?=$no?>
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
                                                                    mysqli_free_result($resultc);
                                                                } else{
                                                                    echo "<p class='lead'><em>No questions.</em></p>";
                                                                }
                                                            } else{
                                                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                
                                                <!-- UNTUK FILTER SOALAN-->
                                                <form action="" method="GET" name="">
                                                    <table>
                                                        <tr>
                                                            <td><input type="text" name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" placeholder="Enter keywords" /></td>
                                                            <td><input type="text" name="mark" value="<?php echo isset($_GET['mark']) ? $_GET['mark'] : ''; ?>" placeholder="Enter marks" /></td>
                                                            <td><input type="text" name="level" value="<?php echo isset($_GET['level']) ? $_GET['level'] : ''; ?>" placeholder="Enter level" /></td>
                                                            <td><input type="hidden" name="subId" value="<?php echo $subId; ?>" placeholder="Enter keywords" /></td>
                                                            <td><input type="hidden" name="id" value="<?php echo $param_id; ?>" placeholder="Enter keywords" /></td>
                                                            <td><input type="submit" name="" value="Search" /></td>
                                                        </tr>
                                                    </table>
                                                </form>

                                                <!-- UNTUK FILTER SOALAN-->
                                                <div class="card mt-5">
                                                    <div class="card-header text-center">
                                                        <h5>List of available questions:</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                            $k = isset($_GET['k']) ? $_GET['k'] : NULL;
                                                            $mark = isset($_GET['mark']) ? $_GET['mark'] : NULL;
                                                            $level = isset($_GET['level']) ? $_GET['level'] : NULL;

                                                            // create the base variables for building the search query
                                                            $sqlq = "SELECT * FROM questions WHERE subjectId = $subId AND examId != $param_id AND q_mark LIKE'%".$mark."%' AND q_level LIKE'%".$level."%' AND ";
                                                            $display_words = "";
                                                                                
                                                            // format each of search keywords into the db query to be run
                                                            $keywords = explode(' ', $k);			
                                                            foreach ($keywords as $word){
                                                                $sqlq .= "q_question LIKE '%".$word."%' OR ";
                                                                $display_words .= $word.' ';
                                                            }
                                                            $sqlq = substr($sqlq, 0, strlen($sqlq)-4);
                                                            $display_words = substr($display_words, 0, strlen($display_words)-1);

                                                            //$sql = "SELECT * FROM questions WHERE subjectId = $param_id";
                                                            if($resultq = mysqli_query($link, $sqlq)){
                                                                if(mysqli_num_rows($resultq) > 0){
                                                                    $no =0;
                                                                    while($row = mysqli_fetch_array($resultq)){
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
                                                                                            <fieldset id="checkArray">
                                                                                                <input type="checkbox" id="radio1" name="question[]" value="<?=$row['q_id']?>">
                                                                                            </fieldset>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                    }
                                                                    // Free result set
                                                                    mysqli_free_result($resultq);
                                                                } else{
                                                                    echo "<p class='lead'><em>No records were found.</em></p>";
                                                                }
                                                            } else{
                                                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                                            }
                                                        ?>
                                                    </div>
                                                </div>

                                                
                                                

                                                <input type="hidden" name="edit_id" value="<?php echo $param_id; ?>">
                                                <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">

                                                <button class="btn" type="submit" name="update" >Update</button>
                                                
                                                <a href="home.php" class="btn btn-default">Cancel</a>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>        
                        </div>
                    </div>
                <?php
            }
        }
    }
    }
?>