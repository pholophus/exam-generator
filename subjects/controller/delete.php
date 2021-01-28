<?php
session_start();
require_once "../../config.php";

if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($link, "DELETE FROM subjects WHERE s_id='$id'");

	$_SESSION['message'] = "Subject deleted!"; 

	header('location: ../view/home.php');
}