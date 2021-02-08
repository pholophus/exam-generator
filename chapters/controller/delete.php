<?php
session_start();
require_once "../../config.php";

if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$subId = $_GET['subId'];
	$chapterName = "";

	$sql = "SELECT * FROM chapters WHERE subjectId = $param_id";
	if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$chapterName = $row['c_name'];
			}
		}
	}

	mysqli_query($link, "DELETE FROM chapters WHERE c_id='$id'");

	echo"
		<script type=\"text/javascript\">
			window.alert('Chapter ".$chapterName ." successfully deleted');
		</script>
	";

	header("location: ../view/home.php?subId=$subId");
}