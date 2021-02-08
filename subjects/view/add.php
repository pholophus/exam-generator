<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}else{
    include('../../header.php');
    ?>
 
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                    <div class="card mt-5">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="home.php" class="btn btn-primary">Return</a>
                                </div>
                                <div class="col-md-6 text-center">
                                    <h4>Add subject</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="../controller/add.php" method="post">
                                <div class="form-group">
                                    <label>Subject Name</label>
                                    <input type="text" name="s_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Subject Code</label>
                                    <input type="text" name="s_code" class="form-control" required>
                                </div>

                                <button class="btn btn-success" type="submit" name="save" >Save</button>
                                
                                <a href="home.php" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                        
                    </div>
                </div>        
            </div>
        </div>
<?php
}
