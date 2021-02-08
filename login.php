<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: subjects/view/home.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: subjects/view/home.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
                                <div class="form-group" >
                                
                                    <div class="input-container">
                                    <i class="far fa-user icon" ></i>
                                        <input type="text" class="input-login" placeholder="Enter username" name="username" size="36">
                                    </div>
                                    <span class="help-block mb-3" style="color: red;"><?php echo $username_err; ?></span>

                                    <div class="input-container">
                                        <i class="fas fa-lock icon" ></i>
                                        <input type="password" class="input-login" name="password" placeholder="Enter password" size="36">
                                    </div>
                                    <span class="help-block mb-3" style="color: red;"><?php echo $password_err; ?></span>

                                    <div class="text-center">
                                        <input class="btn btn-primary" type="submit" value="Login">
                                        <a href="register.php" class="btn btn-success">Register</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</body>
</html>