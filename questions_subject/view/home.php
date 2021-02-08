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
    $param_id = $_GET["subId"];

    $subName = "";

    $sqlSub = "SELECT * FROM subjects WHERE s_id = $param_id";
    if($result = mysqli_query($link, $sqlSub)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $subName = $row['s_name'];
            }
        }
    }

    $sql = "SELECT * FROM questions WHERE subjectId = $param_id";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            ?>
                <div class="row justify-content-center">
                    <div class="col-md-8 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="../../subjects/view/home.php" class="btn btn-danger">Back</a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h4>List of questions (<?=$subName?>)</h4>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href='add.php?subId=<?php echo($param_id);?>' class='btn btn-primary'>Add question</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center " id="render">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Question</th>
                                            <th scope="col">Mark</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Chapter</th>
                                            <th scope="col">: : :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 1;
                                            while($row = mysqli_fetch_array($result)){
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?php echo($no++);?></th>
                                                        <td scope="row"><?php echo($row['q_question']);?></td>
                                                        <td scope="row"><?php echo($row['q_mark']);?></td>
                                                        <td scope="row"><?php echo($row['q_level']);?></td>
                                                        <td scope="row">
                                                            <?php 
                                                                $chapId = $row['chapterId'];
                                                                $sqlChap = "SELECT * FROM chapters WHERE c_id = $chapId";

                                                                    if($resultChap = mysqli_query($link, $sqlChap)){
                                                                        if(mysqli_num_rows($resultChap) > 0){
                                                                            while($rowChap = mysqli_fetch_array($resultChap)){
                                                                                echo($rowChap['c_name']);
                                                                            }
                                                                        }else{
                                                                            echo("No chapter");
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td scope="row">
                                                            <a href='view.php?subId=<?php echo($param_id);?>&id=<?php echo($row['q_id']);?>' class='btn btn-success'>View</a>
                                                            <a href='edit.php?subId=<?php echo($param_id);?>&id=<?php echo($row['q_id']);?>' class='btn btn-success'>Update</a>
                                                            <a href='put.php?subId=<?php echo($param_id);?>&id=<?php echo($row['q_id']);?>' class='btn btn-success'>Edit add </a>
                                                            <a href='../controller/delete.php?subId=<?php echo($param_id);?>&del=<?php echo($row['q_id']);?>' class='btn btn-danger'>Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            // Free result set
            mysqli_free_result($result);
        } else{
            ?>
                <div class="row justify-content-center">
                    <div class="col-md-8 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="../../subjects/view/home.php" class="btn btn-danger">Back</a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h4>List of questions (<?=$subName?>)</h4>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href='add.php?subId=<?php echo($param_id);?>' class='btn btn-primary'>Add question</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center " id="render">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Question</th>
                                            <th scope="col">Mark</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Chapter</th>
                                            <th scope="col">: : :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    // Close connection
    mysqli_close($link);
    ?>   
    <?php
    include('../../footer.php');
}


