<?php
session_start();
require_once "../../config.php";

if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$subId = $_GET['subId'];
	mysqli_query($link, "DELETE FROM chapters WHERE c_id='$id'");

	$_SESSION['message'] = "Subject deleted!"; 

	header("location: ../view/home.php?subId=$subId");
}