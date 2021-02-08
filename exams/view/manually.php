<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}else{
    $param_id = $_GET["subId"];
    require_once "../../config.php";
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
                                        <a class="btn btn-danger" href="home.php?subId=<?=$param_id?>">Back</a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h2>Generate Exam Manually </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="my-3">
                                        <form action="" method="GET" name="">
                                            <table>
                                                <tr>
                                                    <td><input type="text" name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" placeholder="Enter keywords" /></td>
                                                    <td><input type="text" name="mark" value="<?php echo isset($_GET['mark']) ? $_GET['mark'] : ''; ?>" placeholder="Enter marks" /></td>
                                                    <td><input type="text" name="level" value="<?php echo isset($_GET['level']) ? $_GET['level'] : ''; ?>" placeholder="Enter level" /></td>
                                                    <td><input type="hidden" name="subId" value="<?php echo $param_id; ?>" placeholder="Enter keywords" /></td>
                                                    <td><input type="submit" name="" value="Search" /></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>

                                <form action="../controller/manually.php" method="post">
                                    <div class="form-group">
                                        <label> Exam Name </label>
                                        <input type="text" name="e_name" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label> Total marks </label>
                                        <input id="total_mark" type="text" name="e_total" class="form-control" required >
                                    </div>

                                    <input type="hidden" name="subId" value="<?=$param_id?>">

                                    <br />

                                    <?php
                                        $k = isset($_GET['k']) ? $_GET['k'] : NULL;
                                        $mark = isset($_GET['mark']) ? $_GET['mark'] : NULL;
                                        $level = isset($_GET['level']) ? $_GET['level'] : NULL;
                                        $sqlq = "";

                                        // create the base variables for building the search query
                                        if(is_null($mark) || $mark==""){
                                            $sqlq = "SELECT * FROM questions WHERE subjectId = $param_id AND examId = 0 AND q_mark LIKE'%".$mark."%' AND q_level LIKE'%".$level."%' AND ";
                                        }else{
                                            $sqlq = "SELECT * FROM questions WHERE subjectId = $param_id AND examId = 0 AND q_mark = $mark AND q_level LIKE'%".$level."%' AND ";
                                        }
                                       
                                        $display_words = "";
                                                            
                                        // format each of search keywords into the db query to be run
                                        $keywords = explode(' ', $k);			
                                        foreach ($keywords as $word){
                                            $sqlq .= "q_question LIKE '%".$word."%' OR ";
                                            $display_words .= $word.' ';
                                        }
                                        $sqlq = substr($sqlq, 0, strlen($sqlq)-4);
                                        $display_words = substr($display_words, 0, strlen($display_words)-1);

                                        //$sql = "SELECT * FROM questions WHERE subjectId = $param_id";
                                        if($resultq = mysqli_query($link, $sqlq)){
                                            if(mysqli_num_rows($resultq) > 0){
                                                $no =0;
                                                while($row = mysqli_fetch_array($resultq)){
                                                    $no++;
                                                    ?><div class='card mb-4'>
                                                            <div class='card-header'>
                                                                No <?=$no?>
                                                            </div>
                                                            <div class='card-body'>
                                                                <div class='form-check-inline'>
                                                                    <label class='form-check-label' for='check1'>
                                                                        <p>Question <?= $no ?>: <?=$row['q_question']?></p>
                                                                        <p>Mark: <?=$row['q_mark']?></p>
                                                                        <p>Question Level: <?=$row['q_level']?></p>
                                                                        <fieldset id="checkArray">
                                                                            <input onClick="calculate()" type="checkbox" id="radio1" name="question[]" value="<?php echo($row['q_id']." ".$row['q_mark']);?>" >
                                                                        </fieldset>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                                // Free result set
                                                mysqli_free_result($resultq);
                                            } else{
                                                echo "<p class='lead'><em>No records were found.</em></p>";
                                            }
                                        } else{
                                            echo "ERROR: Could not able to execute $sqlq. " . mysqli_error($link);
                                        }
                                    ?>

                                    <input type="hidden" name="sub_id" value="<?php echo $subId ?>">

                                    <button class="btn btn-success" type="submit" name="save" >Save</button>
                                    
                                    <a href="home.php" class="btn btn-danger">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>

        <script type="text/javascript">
            
            function calculate() {
                var input = document.getElementsByName("question[]");
                var total = 0;
                
                for (var i = 0; i < input.length; i++) {
                    if (input[i].checked) {
                        var res = input[i].value.split(" ");
                    total += parseFloat(res[1]);
                    }
                }
                document.getElementById("total_mark").value = total;
            }
            
            
        </script>
    </body>
<?php
}
