<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}else{
    $subId = $_GET['subId'];
    include('../../header.php');
    ?>
 
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="home.php?subId=<?php echo($subId);?>" class="btn btn-success">Return</a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h4>Add chapter</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="../controller/add.php" method="post">
                                    <div class="form-group">
                                        <label>Chapter Name</label>
                                        <input type="text" name="c_name" class="form-control" required>
                                    </div>

                                    <input type="hidden" name="sub_id" value="<?php echo $subId ?>">

                                    <button class="btn btn-primary" type="submit" name="save" >Save</button>
                                    
                                    <a href="home.php?subId=<?=$subId?>" class="btn btn-danger ml-2">Cancel</a>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>        
            </div>
        </div>
<?php
}
