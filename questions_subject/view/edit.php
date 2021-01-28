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
    $sql = "SELECT * FROM questions WHERE q_id = $param_id";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                ?>
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h2>Update Record</h2>
                                    </div>
                                    <p>Please fill this form and submit to add employee record to the database.</p>
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
                                            <select name="q_level" >
                                                <option value="1" <?php $row['q_mark'] == 1 ? "selected" : "" ?>>1</option>
                                                <option value="2" <?php $row['q_mark'] == 2 ? "selected" : "" ?>>2</option>
                                                <option value="3" <?php $row['q_mark'] == 3 ? "selected" : "" ?>>3</option>
                                                <option value="4" <?php $row['q_mark'] == 4 ? "selected" : "" ?>>4</option>
                                                <option value="5" <?php $row['q_mark'] == 5 ? "selected" : "" ?>>5</option>
                                                <option value="6" <?php $row['q_mark'] == 6 ? "selected" : "" ?>>6</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="edit_id" value="<?php echo $param_id; ?>">
                                        <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">

                                        <button class="btn" type="submit" name="update" >Update</button>
                                        
                                        <a href="home.php?subId=<?=$subId?>" class="btn btn-default">Cancel</a>
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