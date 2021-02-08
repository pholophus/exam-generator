<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="auth.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</head>
<body style=" background-repeat: no-repeat; height: 100%; background-attachment: fixed; margin: 0;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-9 mt-5"></div>
            <div class="col-md-9 mt-5"></div> 
            <div class="col-md-9 mt-5">
                <div class="row" >
                    <div class="col-md-7 text-center py-5" style="background-color:#f2f2f2; box-shadow: 0px 5px; border:0; border: 1px solid black;  border-bottom-left-radius:20px; border-top-left-radius:20px; position: relative;">
                        <!--<img src="images/colleague.jpg" height="400" width="580" alt="" style="object-fit:cover;">-->
                        <img src="images/remotely.svg" height="400" width="580" alt="">
                        <div class="text-center ml-3" style="position: absolute; bottom: 5px; left: 150px;">
                            <h4>Question Recommender System</h4>
                        </div>
                    </div>
                    <div class="col-md-5 py-5" style="background-color:#f2f2f2; box-shadow: 5px 5px; border-bottom-right-radius:20px; border:0; border: 1px solid black;  border-top-right-radius:20px;">
                        <div class="mx-5 mt-3">
                            <div class="text-center">
                                <img src="images/user-logo.png" height="70" alt="">
                                <h2 class="mt-3">Welcome</h2>
                            </div>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                                    <span class="help-block" style="color: red;"><?php echo $username_err; ?></span>
                                </div>    
                                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                    <span class="help-block" style="color: red;"><?php echo $password_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                    <span class="help-block" style="color: red;"><?php echo $confirm_password_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                                <p>Already have an account? <a href="login.php">Login here</a>.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</body>
</html>