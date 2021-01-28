<?php
session_start();
require_once "../../config.php";
 
// Processing form data when form is submitted
if (isset($_POST['update'])) {
	$name = $_POST['c_name'];
	$id = $_POST['edit_id'];
	$subId = $_POST['subject_id'];

	mysqli_query($link, "UPDATE chapters SET c_name='$name' WHERE c_id='$id'");
	$_SESSION['message'] = "Chapter updated!"; 
	header("location: ../view/home.php?subId=$subId");
}