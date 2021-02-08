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
    $chapId = $_GET["chapId"];
    $sql = "SELECT * FROM questions WHERE q_id = $param_id";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
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
                                                    <h4>Update question</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="../controller/edit.php" method="post">
                                                <div class="form-group">
                                                    <label>Question</label>
                                                    <input type="text" name="q_question" class="form-control" value="<?=$row['q_question']?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Answer</label>
                                                    <input type="text" name="q_answer" class="form-control" value="<?=$row['q_answer']?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Mark</label>
                                                    <input type="text" name="q_mark" class="form-control" value="<?=$row['q_mark']?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label> Level </label>
                                                    <select class="form-control" name="q_level" >
                                                        <option value="1"  <?php print $row['q_level'] == 1 ? "selected" : "" ;?>>1</option>
                                                        <option value="2"  <?php print $row['q_level'] == 2 ? "selected" : "" ;?>>2</option>
                                                        <option value="3"  <?php print $row['q_level'] == 3 ? "selected" : "" ;?>>3</option>
                                                        <option value="4"  <?php print $row['q_level'] == 4 ? "selected" : "" ;?>>4</option>
                                                        <option value="5"  <?php print $row['q_level'] == 5 ? "selected" : "" ;?>>5</option>
                                                        <option value="6"  <?php print $row['q_level'] == 6 ? "selected" : "" ;?>>6</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="edit_id" value="<?php echo $param_id; ?>">
                                                <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">
                                                <input type="hidden" name="chapterId" value="<?php echo $subId; ?>">

                                                <button class="btn btn-success" type="submit" name="update" >Update</button>
                                                
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
        }
    }
    }
?>