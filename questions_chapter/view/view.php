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
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card mt-5">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <?php
                                                        echo "<a class='btn btn-danger' href=\"javascript:history.go(-1)\">Back</a>";
                                                    ?>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <h4>View question</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="../controller/edit.php" method="post">
                                                <div class="form-group">
                                                    <label>Question</label>
                                                    <input type="text" name="q_question" class="form-control" value="<?=$row['q_question']?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Answer</label>
                                                    <input type="text" name="q_answer" class="form-control" value="<?=$row['q_answer']?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Level</label>
                                                    <input type="text" name="q_level" class="form-control" value="<?=$row['q_level']?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Answer</label>
                                                    <input type="text" name="q_answer" class="form-control" value="<?=$row['q_answer']?>" disabled>
                                                </div>
                                                <input type="hidden" name="edit_id" value="<?php echo $param_id; ?>">
                                                <input type="hidden" name="subject_id" value="<?php echo $subId; ?>">

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