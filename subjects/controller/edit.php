<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['update'])) {
	$name = $_POST['s_name'];
    $code = $_POST['s_code'];
    $id = $_POST['edit_id'];

	mysqli_query($link, "UPDATE subjects SET s_name='$name', s_code='$code' WHERE s_id='$id'");
	$_SESSION['message'] = "Subject updated!"; 
	header('location: ../view/home.php');
}