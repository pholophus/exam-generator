<?php
session_start();
require_once "../../config.php";

if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$subId = $_GET['subId'];
	mysqli_query($link, "DELETE FROM questions WHERE q_id='$id'");

	$_SESSION['message'] = "Question deleted!"; 

	header("location: ../view/home.php?subId=$subId");
}