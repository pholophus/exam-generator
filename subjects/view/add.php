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
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Add subject</h2>
                        </div>
                        <p>Please fill this form and submit to add employee record to the database.</p>
                        <form action="../controller/add.php" method="post">
                            <div class="form-group">
                                <label>Subject Name</label>
                                <input type="text" name="s_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Subject Code</label>
                                <input type="text" name="s_code" class="form-control" required>
                            </div>

                            <button class="btn" type="submit" name="save" >Save</button>
                            
                            <a href="home.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
<?php
}
