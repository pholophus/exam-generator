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
    //$param_id = $_GET["id"];
    $subId = $_GET["subId"];
    //$sql = "SELECT * FROM questions WHERE q_id = $param_id";

                ?>
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-md-8 mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <a class="btn btn-success" href="home.php?subId=<?php echo($subId);?>">Return</a>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <h4>Generate Question</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="../controller/generate.php" method="post">
                                                <div class="form-group">
                                                    <label>Level 1</label>
                                                    <input type="text" name="level1" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Level 2</label>
                                                    <input type="text" name="level2" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Level 3</label>
                                                    <input type="text" name="level3" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Level 4</label>
                                                    <input type="text" name="level4" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Level 5</label>
                                                    <input type="text" name="level5" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Level 6</label>
                                                    <input type="text" name="level6" class="form-control" >
                                                </div>
                                                <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">

                                                <button class="btn btn-primary mr-4" type="submit" name="generate" >Generate</button>
                                                
                                                <a href="home.php?subId=<?=$subId?>" class="btn btn-danger">Cancel</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                <?php
    }
?>