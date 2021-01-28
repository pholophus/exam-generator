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
    $sql = "SELECT * FROM subjects";

    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            ?>
                
                <div class="container">

                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-5">
                        <h3>List of subjects:</h3>
                    </div>
                    <div class="col-md-2">
                        <a href="add.php" class='btn btn-info rounded-circle'><i class="fas fa-plus-square"></i></a>Add Subject
                    </div>
                </div>
                    
                    <div class="row">
                        <?php
                        while($row = mysqli_fetch_array($result)){
                            ?>
                                <div class="col d-flex justify-content-center py-5">
                                    <div class='card text-center' style="width: 20rem;">
                                        <div class='card-header'>
                                            <div class="d-flex">
                                                <div class="mr-auto p-3">
                                                    <h5><?=$row['s_name']?></h5>
                                                    <p class='card-text'><?=$row['s_code']?></p>
                                                </div>
                                                <div class="p-2">
                                                    <a href="put.php?id=<?=$row['s_id']?>" class='btn btn-info rounded-circle'><i class='far fa-edit'></i></a>
                                                </div>
                                                <div class="p-2">
                                                    <a href="edit.php?id=<?=$row['s_id']?>" class='btn btn-success rounded-circle'><i class='far fa-edit'></i></a>
                                                </div>
                                                <div class="p-2">
                                                    <a href="../controller/delete.php?del=<?=$row['s_id']?>" class='btn btn-danger rounded-circle'><i class='fas fa-trash'></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='card-body'>
                                            <a href="../../chapters/view/home.php?subId=<?=$row['s_id']?>" class='btn btn-primary'>Chapters</a>
                                            <a href="../../questions_subject/view/home.php?subId=<?=$row['s_id']?>" class='btn btn-primary'>Questions</a>
                                            <a href="../../exams/view/home.php?subId=<?=$row['s_id']?>" class='btn btn-primary'>Exams</a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
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


