<?php 
// Iterative PHP program to print 
// sums of all possible subsets. 

$subId = $_POST['subject_id'];
include('../../header.php');
require_once "../../config.php";

if(isset($_POST['generate'])){
    if(isset($_POST['level1'])){
        $sql = "SELECT * FROM questions WHERE q_level = 1 AND subjectId = $subId";

        $q1 = array();

        if($result = mysqli_query($link, $sql)){
            //echo("1lvl masuk");
            if(mysqli_num_rows($result) > 0){
				//echo("2lvl masuk");
                while($row = mysqli_fetch_array($result)){
                    $q1current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
                    //echo($row['q_id'].' '.$row['q_mark']);
                    //print_r($q1current);
                    array_push($q1, $q1current);
                    //echo "ada value?";
                }
            }
		}
		
		$arr = $q1;
		asort($arr);
		$n = sizeof($arr); 
		$target = $_POST['level1'];
		$c = subsetAccurateSums($arr, $n, $target); 
		$listAccurate = $c[0];
		$sumAccurate = $c[1];

		/*echo "choice ";
		print_r($q1);*/
		
		if(empty($listAccurate)){
			$d = subsetNearestSums($arr, $n, $target);
			$listNearest = $d[0];
			$sumNearest = $d[1];
			/*print "<br> List of the values ".json_encode($arr)."<br>";
			print "Desired value ".$target."<br>";
			print "Nearest sum ".$sumNearest."<br>";
			print "Nearest list";
			print_r($listNearest);
			print ("<br> size of suggested combinations: " . sizeof($listNearest)."<br>");*/
			//print out each combination
			
			print "<br> <h4>List question for level 1</h4>";
			print "<h5>Target value :".$target."</h5><br>";
			print "<h5>Nearest sum :".$sumNearest."</h5><br>";
			$o=1;
			for($i=0; $i<sizeof($listNearest); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listNearest[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumNearest."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listNearest[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}else{
			print "<br> <h4>List question for level 1</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Accurate sum :".$sumAccurate."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listAccurate); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listAccurate[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumAccurate."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listAccurate[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}
		
    }else{
        echo "macam tak masuk 1?";
    }if(isset($_POST['level2'])){
        $sql = "SELECT * FROM questions WHERE q_level = 2 AND subjectId = $subId";

        $q2 = array();

        if($result = mysqli_query($link, $sql)){
            //echo("1lvl masuk");
            if(mysqli_num_rows($result) > 0){
				//echo("2lvl masuk");
                while($row = mysqli_fetch_array($result)){
                    $q2current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
                    //echo($row['q_id'].' '.$row['q_mark']);
                    //print_r($q1current);
                    array_push($q2, $q2current);
                    //echo "ada value?";
                }
            }
		}
		
		$arr = $q2;
		asort($arr);
		$n = sizeof($arr); 
		$target = $_POST['level2'];
		$c = subsetAccurateSums($arr, $n, $target); 
		$listAccurate = $c[0];
		$sumAccurate = $c[1];

		/*echo "choice ";
		print_r($q1);*/
		
		if(empty($listAccurate)){
			$d = subsetNearestSums($arr, $n, $target);
			$listNearest = $d[0];
			$sumNearest = $d[1];
			/*print "<br> List of the values ".json_encode($arr)."<br>";
			print "Desired value ".$target."<br>";
			print "Nearest sum ".$sumNearest."<br>";
			print "Nearest list";
			print_r($listNearest);
			print ("<br> size of suggested combinations: " . sizeof($listNearest)."<br>");*/
			//print out each combination
			print "<br> <h4>List question for level 2</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Nearest sum :".$sumNearest."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listNearest); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listNearest[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumNearest."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listNearest[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}else{
			print "<br> <h4>List question for level 2</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Accurate sum :".$sumAccurate."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listAccurate); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listAccurate[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listAccurate[$i][$k]["marks"];
					print($mark);
					//print_r($listAccurate[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumAccurate."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listAccurate[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}
		
    }else{
        echo "macam tak masuk 2?";
    }if(isset($_POST['level3'])){
        $sql = "SELECT * FROM questions WHERE q_level = 3 AND subjectId = $subId";

        $q3 = array();

        if($result = mysqli_query($link, $sql)){
            //echo("1lvl masuk");
            if(mysqli_num_rows($result) > 0){
				//echo("2lvl masuk");
                while($row = mysqli_fetch_array($result)){
                    $q3current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
                    //echo($row['q_id'].' '.$row['q_mark']);
                    //print_r($q1current);
                    array_push($q3, $q1current);
                    //echo "ada value?";
                }
            }
		}
		
		$arr = $q3;
		asort($arr);
		$n = sizeof($arr); 
		$target = $_POST['level3'];
		$c = subsetAccurateSums($arr, $n, $target); 
		$listAccurate = $c[0];
		$sumAccurate = $c[1];

		/*echo "choice ";
		print_r($q1);*/
		
		if(empty($listAccurate)){
			$d = subsetNearestSums($arr, $n, $target);
			$listNearest = $d[0];
			$sumNearest = $d[1];
			/*print "<br> List of the values ".json_encode($arr)."<br>";
			print "Desired value ".$target."<br>";
			print "Nearest sum ".$sumNearest."<br>";
			print "Nearest list";
			print_r($listNearest);
			print ("<br> size of suggested combinations: " . sizeof($listNearest)."<br>");*/
			//print out each combination
			print "<br> <h4>List question for level 3</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Nearest sum :".$sumNearest."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listNearest); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listNearest[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumNearest."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listNearest[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}else{
			print "<br> <h4>List question for level 3</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Accurate sum :".$sumAccurate."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listAccurate); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listAccurate[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listAccurate[$i][$k]["marks"];
					print($mark);
					//print_r($listAccurate[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumAccurate."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listAccurate[$i][$m]["marks"];
					//print($mark);
					$questionId = $listAccurate[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}
		
    }else{
        echo "macam tak masuk 3?";
    }if(isset($_POST['level4'])){
        $sql = "SELECT * FROM questions WHERE q_level = 4 AND subjectId = $subId";

        $q4 = array();

        if($result = mysqli_query($link, $sql)){
            //echo("1lvl masuk");
            if(mysqli_num_rows($result) > 0){
				//echo("2lvl masuk");
                while($row = mysqli_fetch_array($result)){
                    $q4current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
                    //echo($row['q_id'].' '.$row['q_mark']);
                    //print_r($q1current);
                    array_push($q4, $q4current);
                    //echo "ada value?";
                }
            }
		}
		
		$arr = $q4;
		asort($arr);
		$n = sizeof($arr); 
		$target = $_POST['level4'];
		$c = subsetAccurateSums($arr, $n, $target); 
		$listAccurate = $c[0];
		$sumAccurate = $c[1];

		/*echo "choice ";
		print_r($q1);*/
		
		if(empty($listAccurate)){
			$d = subsetNearestSums($arr, $n, $target);
			$listNearest = $d[0];
			$sumNearest = $d[1];
			/*print "<br> List of the values ".json_encode($arr)."<br>";
			print "Desired value ".$target."<br>";
			print "Nearest sum ".$sumNearest."<br>";
			print "Nearest list";
			print_r($listNearest);
			print ("<br> size of suggested combinations: " . sizeof($listNearest)."<br>");*/
			//print out each combination
			print "<br> <h4>List question for level 4</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Nearest sum :".$sumNearest."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listNearest); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listNearest[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumNearest."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listNearest[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}else{
			print "<br> <h4>List question for level 4</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Accurate sum :".$sumAccurate."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listAccurate); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listAccurate[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listAccurate[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listAccurate[$i][$k]["marks"];
					print($mark);
					//print_r($listAccurate[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumAccurate."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listAccurate[$i][$m]["marks"];
					//print($mark);
					$questionId = $listAccurate[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listAccurate[$i][$k][$k]);
				}
			}
		}
		
    }else{
        echo "macam tak masuk 4?";
    }if(isset($_POST['level5'])){
        $sql = "SELECT * FROM questions WHERE q_level = 5 AND subjectId = $subId";

        $q5 = array();

        if($result = mysqli_query($link, $sql)){
            //echo("1lvl masuk");
            if(mysqli_num_rows($result) > 0){
				//echo("2lvl masuk");
                while($row = mysqli_fetch_array($result)){
                    $q1current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
                    //echo($row['q_id'].' '.$row['q_mark']);
                    //print_r($q1current);
                    array_push($q5, $q5current);
                    //echo "ada value?";
                }
            }
		}
		
		$arr = $q5;
		asort($arr);
		$n = sizeof($arr); 
		$target = $_POST['level5'];
		$c = subsetAccurateSums($arr, $n, $target); 
		$listAccurate = $c[0];
		$sumAccurate = $c[1];

		/*echo "choice ";
		print_r($q1);*/
		
		if(empty($listAccurate)){
			$d = subsetNearestSums($arr, $n, $target);
			$listNearest = $d[0];
			$sumNearest = $d[1];
			/*print "<br> List of the values ".json_encode($arr)."<br>";
			print "Desired value ".$target."<br>";
			print "Nearest sum ".$sumNearest."<br>";
			print "Nearest list";
			print_r($listNearest);
			print ("<br> size of suggested combinations: " . sizeof($listNearest)."<br>");*/
			//print out each combination
			print "<br> <h4>List question for level 5</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Nearest sum :".$sumNearest."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listNearest); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listNearest[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumNearest."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listNearest[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}else{
			print "<br> <h4>List question for level 5</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Accurate sum :".$sumAccurate."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listAccurate); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listAccurate[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listAccurate[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listAccurate[$i][$k]["marks"];
					print($mark);
					//print_r($listAccurate[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumAccurate."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listAccurate[$i][$m]["marks"];
					//print($mark);
					$questionId = $listAccurate[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}
		
    }else{
        echo "macam tak masuk 5?";
    }if(isset($_POST['level6'])){
        $sql = "SELECT * FROM questions WHERE q_level = 6 AND subjectId = $subId";

        $q6 = array();

        if($result = mysqli_query($link, $sql)){
            //echo("1lvl masuk");
            if(mysqli_num_rows($result) > 0){
				//echo("2lvl masuk");
                while($row = mysqli_fetch_array($result)){
                    $q6current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
                    //echo($row['q_id'].' '.$row['q_mark']);
                    //print_r($q1current);
                    array_push($q6, $q6current);
                    //echo "ada value?";
                }
            }
		}
		
		$arr = $q6;
		asort($arr);
		$n = sizeof($arr); 
		$target = $_POST['level6'];
		$c = subsetAccurateSums($arr, $n, $target); 
		$listAccurate = $c[0];
		$sumAccurate = $c[1];

		/*echo "choice ";
		print_r($q1);*/
		
		if(empty($listAccurate)){
			$d = subsetNearestSums($arr, $n, $target);
			$listNearest = $d[0];
			$sumNearest = $d[1];
			/*print "<br> List of the values ".json_encode($arr)."<br>";
			print "Desired value ".$target."<br>";
			print "Nearest sum ".$sumNearest."<br>";
			print "Nearest list";
			print_r($listNearest);
			print ("<br> size of suggested combinations: " . sizeof($listNearest)."<br>");*/
			//print out each combination
			print "<br> <h4>List question for level 6</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Nearest sum :".$sumNearest."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listNearest); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listNearest[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listNearest[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listNearest[$i][$k]["marks"];
					print($mark);
					//print_r($listNearest[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumNearest."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listNearest[$i][$m]["marks"];
					//print($mark);
					$questionId = $listNearest[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}else{
			print "<br> <h4>List question for level 6</h4>";
			print "<h4>Target value :".$target."</h4><br>";
			print "<h4>Accurate sum :".$sumAccurate."</h4><br>";
			
			$o=1;
			for($i=0; $i<sizeof($listAccurate); $i++){
				//get length of each combination
				$combination = 0;
				$combination = sizeof($listAccurate[$i]);
				/*$n=1;
				for($j=0; $j<$combination; $j++){
					print("<br> combination ");
					print($n+$j." :");
					print_r($listAccurate[$i][$j]);
				}
				$l=1;
				$mark = 0;
				for($k=0; $k<$combination; $k++){
					print("<br> total marks: ");
					$mark += $listAccurate[$i][$k]["marks"];
					print($mark);
					//print_r($listAccurate[$i][$k][$k]);
				}*/
				
				print ("<h6>Set of question ".($o+$i)."</h6>");
				print "<h6>Total :".$sumAccurate."</h6><br>";
				for($m=0; $m<$combination; $m++){
					
					//$mark += $listAccurate[$i][$m]["marks"];
					//print($mark);
					$questionId = $listAccurate[$i][$m]["id"];
					$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

					if($resultQuestion = mysqli_query($link, $sqlQuestion)){
						//echo("1lvl masuk");
						if(mysqli_num_rows($resultQuestion) > 0){
							//echo("2lvl masuk");
							while($rowq = mysqli_fetch_array($resultQuestion)){
								?>

									<div class="card" style="width: 18rem;">
									<div class="card-body">
										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
									</div>
									</div>
									<br>

								<?php
								//echo "ada value?";
							}
						}else{
							echo "result tak keluar";
						}
					}else{
						echo "tak masuk";
					}
					//print_r($listNearest[$i][$k][$k]);
				}
			}
		}
	
	
    }else{
        echo "macam tak masuk 1?";
    }
}else{
    echo "ni terus tak masukwei";
}

// Prints sums of all subsets of array 
function subsetAccurateSums($arr, $n, $target) 
{ 
	
		// There are totoal 2^n subsets 
		$total = 1 << $n; 
		$list = [];

	// Consider all numbers 
	// from 0 to 2^n - 1 
	for ($i = 0; $i < $total; $i++) 
	{ 
		$sum = 0;

		// Consider binary reprsentation of 
		// current i to decide which elements 
		// to pick.
		$hold = array();		
		for ($j = 0; $j < $n; $j++){	
			if ($i & (1 << $j)){
				$sum += $arr[$j]["marks"];
				array_push($hold, $arr[$j]);
			}
		}
		
		if($sum == $target){
			$list[] = $hold;
		}
		// Print sum of picked elements. 
		//echo $sum , " "; 
	}

		return array($list,$target, $arr);
} 

function subsetNearestSums($arr, $n, $target) 
{ 
	
		// There are totoal 2^n subsets 
		$total = 1 << $n; 
		$list = [];

		$near = 0;

		//array for max
		$forMax	= array();
		$max=0;

		//array for min
		$forMin = array();
		$min = 0;
		
	// Consider all numbers 
	// from 0 to 2^n - 1 
	
	for ($i = 0; $i < $total; $i++) 
	{ 
		$sum = 0;
		$hold = array();
		
		for ($j = 0; $j < $n; $j++){	
			if ($i & (1 << $j)){
				$sum += $arr[$j]["marks"];
				array_push($hold, $arr[$j]);
			}
		}
		
		if($sum <= $target){
			array_push($forMax, $sum);
		}
		if($sum >= $target){
			array_push($forMin, $sum);
		}
		//echo "forMin";
		//print json_encode($forMin);
		//echo "<br>";
		
		if(!empty($forMax)){
			$max = max($forMax);
		}
		
		if(!empty($forMin)){
			$min = min($forMin);
		}
	}
	
	$check = array();
		$max1 = $target - $max;
		$min1 = $min - $target;
		
		if($max1 > $min1){
			$near = $min;
		}else{
			$near = $max;
		}
	
	for ($i = 0; $i < $total; $i++) 
	{ 
		$sum = 0;
		$hold = array();
		
		for ($j = 0; $j < $n; $j++){	
			if ($i & (1 << $j)){
				$sum += $arr[$j]["marks"];
				array_push($hold, $arr[$j]);
			}
		}
		
		if($sum == $near){
			$list[] = $hold;
		}
		//print json_encode($hold);
	}
	//print json_encode($hold);
	if($near == 0){
		$list[0]=$arr;

		for ($i = 0; $i < $total; $i++) 
		{ 
			$sum = 0;
			
			for ($j = 0; $j < $n; $j++){	
				if ($i & (1 << $j)){
					$sum += $arr[$j]["marks"];
				}
			}
		}

		$near = $sum;
	}
		return array($list,$near, $arr);
		
} 