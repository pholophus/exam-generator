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

    $sql = "SELECT * FROM chapters WHERE subjectId = $param_id";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            ?>
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="../../subjects/view/home.php" class="btn btn-danger">Return</a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h3>List of chapters (<?= $subName?>)</h3>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href='add.php?subId=<?php echo($param_id);?>' class='btn btn-primary'>Add</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row ">
                                    <?php
                                        $no = 0;
                                        while($row = mysqli_fetch_array($result)){
                                            $no++;
                                    ?>
                                        <div class="col-md-5 ml-5 mb-5">
                                            <div class='card' style="width: 20rem;">
                                                <div class='card-header'>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                        <h5><?php echo($no.") ".$row['c_name']);?></h5>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <a href='../controller/delete.php?subId=<?php echo($param_id);?>&del=<?php echo($row['c_id']);?>' class='btn btn-danger'><i class='fas fa-trash'></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='card-body'>
                                                    <a href='edit.php?subId=<?php echo($param_id);?>&id=<?php echo($row['c_id']);?>' class='btn btn-success'>Update</a>
                                                    <a href='put.php?subId=<?php echo($param_id);?>&id=<?php echo($row['c_id']);?>' class='btn btn-success'>Edit add</a>
                                                    <a href="../../questions_chapter/view/home.php?subId=<?= $param_id?>&chapId=<?php echo($row['c_id']);?>" class='btn btn-success'>Questions</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            // Free result set
            mysqli_free_result($result);
        } else{
           ?>
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="../../subjects/view/home.php" class="btn btn-success">Return</a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h3>List of chapters:</h3>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <a href='add.php?subId=<?php echo($param_id);?>' class='btn btn-primary'>Add Chapter</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                            </div>
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


