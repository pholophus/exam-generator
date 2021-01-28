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
    $param_id = $_GET["subId"];
    $sql = "SELECT * FROM questions WHERE subjectId = $param_id";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                echo "<div class='card text-center' style='width: 18rem;'>";
                    echo "<div class='card-header'>";
                        echo "<h5> Question: ".$row['q_question']."</h5>";
                    echo "</div>";

                    echo "<div class='card-body'>";
                        echo "<a href='view.php?subId=".$param_id."&id=".$row['q_id']."' class='btn btn-primary'>View</a>";
                        echo "<a href='add.php?subId=".$param_id."' class='btn btn-primary'>Add</a>";
                        echo "<a href='edit.php?subId=".$param_id."&id=".$row['q_id']."' class='btn btn-primary'>Edit</a>";
                        echo "<a href='put.php?subId=".$param_id."&id=".$row['q_id']."' class='btn btn-primary'>Edit existing </a>";
                        echo "<a href='../controller/delete.php?subId=".$param_id."&del=".$row['q_id']."'' class='btn btn-primary'>Delete</a>";
                    echo "</div>";
                echo "</div>";
            }
            // Free result set
            mysqli_free_result($result);
        } else{
            echo "<p class='lead'><em>No records were found.</em></p>";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    // Close connection
    mysqli_close($link);
    ?>   
    <?php
    include('../../footer.php');
}


