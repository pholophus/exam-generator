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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h2>View Record</h2>
                                    </div>
                                    <p>Please fill this form and submit to add employee record to the database.</p>
                                    <form action="../controller/put.php" method="post">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="e_name" class="form-control" value="<?=$row['e_name']?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Marks</label>
                                            <input type="text" name="e_total" class="form-control" value="<?=$row['e_total']?>" required>
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
                <?php
            }
        }
    }
    }
?>