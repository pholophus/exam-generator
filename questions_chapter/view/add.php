<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}else{
    $subId = $_GET['subId'];
    $chapId = $_GET['chapId'];
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
                                    <?php
                                        echo "<a class='btn btn-primary' href=\"javascript:history.go(-1)\">Back</a>";
                                    ?>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h4>Add question</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
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
                                        <select class="form-control" name="q_level" required>
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
                                    <input type="hidden" name="chapId" value="<?php echo $chapId ?>">

                                    <button class="btn btn-success" type="submit" name="save" >Save</button>
                                    
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
