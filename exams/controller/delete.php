<?php
session_start();
require_once "../../config.php";

if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$subId = $_GET['subId'];
	mysqli_query($link, "DELETE FROM exams WHERE e_id='$id'");
	mysqli_query($link, "DELETE FROM exam_paper WHERE ep_exam='$id'");

	$_SESSION['message'] = "Exam deleted!"; 

	header("location: ../view/home.php?subId=$subId");
}