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
    $sql = "SELECT * FROM chapters WHERE c_id = $param_id";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                ?>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card mt-5">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?php
                                                    echo "<a class='btn btn-primary' href=\"javascript:history.go(-1)\">Back</a>";
                                                ?>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <h4>Update Chapter</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="../controller/edit.php" method="post">
                                            <div class="form-group">
                                                <label>Chapter Name</label>
                                                <input type="text" name="c_name" class="form-control" value="<?=$row['c_name']?>" required>
                                            </div>
                                            <input type="hidden" name="edit_id" value="<?php echo $param_id; ?>">
                                            <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">

                                            <button class="btn btn-success" type="submit" name="update" >Update</button>
                                            
                                            <a href="home.php" class="btn btn-danger">Cancel</a>
                                        </form>
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