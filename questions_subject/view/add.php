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
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Add question</h2>
                        </div>
                        <p>Please fill this form and submit to add employee record to the database.</p>
                        <form action="../controller/add.php" method="post">
                            <div class="form-group">
                                <label> Question </label>
                                <input type="text" name="q_question" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label> Answer </label>
                                <input type="text" name="q_answer" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label> Marks </label>
                                <input type="text" name="q_mark" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label> Level </label>
                                <select name="q_level" >
                                    <option value="">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>

                            <input type="hidden" name="sub_id" value="<?php echo $subId ?>">

                            <button class="btn" type="submit" name="save" >Save</button>
                            
                            <a href="home.php?subId=<?=$subId?>" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
<?php
}
