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
    
    $sql = "SELECT * FROM exams WHERE subjectId = $param_id";
    ?>

    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                        <a href="../../subjects/view/home.php" class="btn btn-danger">Return</a>
                        </div>
                        <div class="col-md-4 text-center">
                        <h4>Exam List (<?=$subName?>)</h4>
                        </div>
                        <div class="col-md-4 text-right">
                        <a class='btn btn-primary' href='manually.php?subId=<?php echo($param_id);?>'>Manual Create</a>
                            <a class='btn btn-primary' href='generate.php?subId=<?php echo($param_id);?>'>Auto Create </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="render">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Exam paper name</th>
                                <th scope="col">Marks</th>
                                <th scope="col">: : :</th>
                            </tr>
                        </thead>
                        <tbody>
        
                <?php
                    $no = 1;
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                ?>
                                <tr>
                                    <td><?php echo($no++);?></td>
                                    <td>
                                        <h5><?php echo($row['e_name']);?></h5>
                                    </td>
                                    <td>
                                        <p><?php echo($row['e_total']);?></p>
                                    </td>
                                    <td>
                                        <a href='view.php?subId=<?php echo($param_id);?>&id=<?php echo($row['e_id']);?>' class='btn btn-success'>View</a>
                                        <a href="../controller/download.php?id=<?php echo($param_id);?>&examId=<?php echo($row['e_id']);?>" class='btn btn-success'>Download</a>
                                        <a href='../controller/delete.php?subId=<?php echo($param_id);?>&del=<?php echo($row['e_id']);?>' class='btn btn-danger'>Delete</a>
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
            echo "<p class='lead'><em>No records were found.</em></p>";
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


