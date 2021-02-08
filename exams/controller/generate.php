<?php 
// Iterative PHP program to print 
// sums of all possible subsets. 

$subId = $_POST['subject_id'];
include('../../header.php');
require_once "../../config.php";
$subName = "";

$sqlSub = "SELECT * FROM subjects WHERE s_id = $subId";
if($resultSub = mysqli_query($link, $sqlSub)){
	if(mysqli_num_rows($resultSub) > 0){
		while($rowSub = mysqli_fetch_array($resultSub)){
			$subName = $rowSub['s_name'];
		}
	}
}
?>
	<div class="row justify-content-center">
		<div class="col-md-8">
		
		
<?php
if(isset($_POST['generate'])){
	?>	<div class="card mt-5">
			<div class="card-header">
				<div class="row">
					<div class="col-md-3">
						<?php
							echo "<a class='btn btn-primary' href=\"javascript:history.go(-1)\">Back</a>";
						?>
					</div>
					<div class="col-md-6 text-center">
						<h4>List questions selected (<?=$subName?>)</h4>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="generate_save_exam.php" method="POST">

					<div class="form-group">
						<label class="h5">Exam paper name:</label>
						<input type="text" class="form-control" name="exam_name" aria-describedby="emailHelp" placeholder="Enter name of exam papaer" required>
					</div>
					<?php
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
						?>
							<div class="card mt-5">
								<div class="card-header text-center">
									<h4>List question for level 1</h4>
								</div>
								<div class="card-body">
									
									<?php
										if(empty($listAccurate)){
											$d = subsetNearestSums($arr, $n, $target);
											$listNearest = $d[0];
											$sumNearest = $d[1];
											//print out each combination
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Nearest sum :<?php echo($sumNearest);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listNearest); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listNearest[$i]);
												//untuk store id question for each combo
												$near_lvl_one = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumNearest);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	$questionId = $listNearest[$i][$m]["id"];
																	$near_lvl_one.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			?>
																				<?php
																					while($rowq = mysqli_fetch_array($resultQuestion)){
																						?>
																							<div class="col-md-5">
																								<div class="card my-3" style="width: 18rem;">
																									<div class="card-body">
																										<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																										<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																										<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																									</div>
																								</div>
																							</div>
																						<?php
																					}
																				?>
																			<?php
																		}else{
																			echo "result tak keluar";
																		}
																	}else{
																		echo "tak masuk";
																	}
																}
															?>
														</div>
													</div>

													<div class="form-check text-right mr-3">
														<input type="radio" name="ques_level_one" value="<?php echo($near_lvl_one); ?>" style="transform: scale(2);">
														<label class="h4 ml-2">Add</label>
													</div>
												</div>
												<?php
											}
										}else{
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Accurate sum :<?php echo($sumAccurate);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listAccurate); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listAccurate[$i]);

												$acc_lvl_one = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumAccurate);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listNearest[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listAccurate[$i][$m]["id"];
																	$acc_lvl_one.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
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
															?>
														</div>

														<div class="form-check text-right mr-3">
															<input type="radio" name="ques_level_one" value="<?php echo($acc_lvl_one); ?>" style="transform: scale(2);">
															<label class="h4 ml-2">Add</label>
														</div>
													</div>
												</div>
												<?php
											}
										}
									?>
									
								</div>
							</div>
						<?php
						
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
						?>
							<div class="card mt-5">
								<div class="card-header text-center">
									<h4>List question for level 2</h4>
								</div>
								<div class="card-body">
									
									<?php 
										if(empty($listAccurate)){
											$d = subsetNearestSums($arr, $n, $target);
											$listNearest = $d[0];
											$sumNearest = $d[1];
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Nearest sum :<?php echo($sumNearest);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listNearest); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listNearest[$i]);
												$near_lvl_two = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumNearest);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listNearest[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listNearest[$i][$m]["id"];
																	$near_lvl_two.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
																				<?php
																			}
																		}else{
																			echo "result tak keluar";
																		}
																	}else{
																		echo "tak masuk";
																	}
																	//print_r($listNearest[$i][$k][$k]);
																}
															?>
															</div>
														</div>

														<div class="form-check text-right mr-3">
															<input type="radio" name="ques_level_two" value="<?php echo($near_lvl_two); ?>" style="transform: scale(2);">
															<label class="h4 ml-2">Add</label>
														</div>
													</div>
													<?php
											}
										}else{
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Accurate sum :<?php echo($sumAccurate);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listAccurate); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listAccurate[$i]);
												$acc_lvl_two = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumAccurate);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listNearest[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listAccurate[$i][$m]["id"];
																	$acc_lvl_two.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
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
															?>
														</div>
														
														<div class="form-check text-right mr-3">
															<input type="radio" name="ques_level_two" value="<?php echo($acc_lvl_two);?>" style="transform: scale(2);">
															
															<label class="h4 ml-2">Add</label>
														</div>
														
													</div>
												</div>
													<?php
											}
										}
									?>
									
								</div>
							</div>
						<?php
								
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
									array_push($q3, $q3current);
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

						?>
						<div class="card mt-5">
							<div class="card-header text-center">
								<h4>List question for level 3</h4>
							</div>
							<div class="card-body">
								
								<?php
									if(empty($listAccurate)){
										$d = subsetNearestSums($arr, $n, $target);
										$listNearest = $d[0];
										$sumNearest = $d[1];
										?>
											<div class="row">
												<div class="col-md-3">
													<h5>Target value :<?php echo($target);?></h5>
												</div>
												<div class="col-md-6"></div>
												<div class="col-md-3">
													<h5>Nearest sum :<?php echo($sumNearest);?></h5>
												</div>
											</div>
										<?php
										
										$o=1;
										for($i=0; $i<sizeof($listNearest); $i++){
											//get length of each combination
											$combination = 0;
											$combination = sizeof($listNearest[$i]);
											$near_lvl_three = "";
											?>
											
											<div class="card mt-3">
												<div class="card-header">
													<div class="row">
														<div class="col-md-3">
															<h6>Total : <?php echo($sumNearest);?></h6>
														</div>
														<div class="col-md-6 text-center">
															<h6>Set of question <?php echo($o+$i);?></h6>
														</div>
													</div>
												</div>
												<div class="card-body" >
													<div class="row justify-content-center">
														<?php
															for($m=0; $m<$combination; $m++){
																
																//$mark += $listNearest[$i][$m]["marks"];
																//print($mark);
																$questionId = $listNearest[$i][$m]["id"];
																$near_lvl_three.= $questionId."_";
																$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																	//echo("1lvl masuk");
																	if(mysqli_num_rows($resultQuestion) > 0){
																		//echo("2lvl masuk");
																		while($rowq = mysqli_fetch_array($resultQuestion)){
																			?>
																				<div class="col-md-5">
																					<div class="card my-3" style="width: 18rem;">
																						<div class="card-body">
																							<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																							<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																							<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																						</div>
																					</div>
																				</div>
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
														?>
													</div>
												</div>

												<div class="form-check text-right mr-3">
													<input type="radio" name="ques_level_three" value="<?php echo($near_lvl_three); ?>" style="transform: scale(2);">
													<label class="h4 ml-2">Add</label>
												</div>
											</div>
											<?php
										}
												
									}else{
										?>
											<div class="row">
												<div class="col-md-3">
													<h5>Target value :<?php echo($target);?></h5>
												</div>
												<div class="col-md-6"></div>
												<div class="col-md-3">
													<h5>Accurate sum :<?php echo($sumAccurate);?></h5>
												</div>
											</div>
										<?php
										
										$o=1;
										for($i=0; $i<sizeof($listAccurate); $i++){
											//get length of each combination
											$combination = 0;
											$combination = sizeof($listAccurate[$i]);
											$acc_lvl_three = "";
											?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumAccurate);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listAccurate[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listAccurate[$i][$m]["id"];
																	$acc_lvl_three.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
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
															?>
														</div>

														<div class="form-check text-right mr-3">
															<input type="radio" name="ques_level_three" value="<?php echo($acc_lvl_three); ?>" style="transform: scale(2);">
															<label class="h4 ml-2">Add</label>
														</div>
													</div>
											</div>
												<?php
										}
									}
									?>
									
								</div>
							</div>
						<?php
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

						?>
							<div class="card mt-5">
								<div class="card-header text-center">
									<h4>List question for level 4</h4>
								</div>
								<div class="card-body">
									
									<?php
										if(empty($listAccurate)){
											$d = subsetNearestSums($arr, $n, $target);
											$listNearest = $d[0];
											$sumNearest = $d[1];
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Nearest sum :<?php echo($sumNearest);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listNearest); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listNearest[$i]);
												$near_lvl_four = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumNearest);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listNearest[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listNearest[$i][$m]["id"];
																	$near_lvl_four.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
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
															?>
														</div>
													</div>

													<div class="form-check text-right mr-3">
														<input type="radio" name="ques_level_four" value="<?php echo($near_lvl_four); ?>" style="transform: scale(2);">
														<label class="h4 ml-2">Add</label>
													</div>
												</div>
												<?php
											}
										}else{
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Accurate sum :<?php echo($sumAccurate);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listAccurate); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listAccurate[$i]);
												$acc_lvl_four = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumAccurate);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listAccurate[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listAccurate[$i][$m]["id"];
																	$acc_lvl_four.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
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
															?>
															</div>

															<div class="form-check text-right mr-3">
																<input type="radio" name="ques_level_four" value="<?php echo($acc_lvl_four); ?>" style="transform: scale(2);">
																<label class="h4 ml-2">Add</label>
															</div>
														</div>
													</div>
													<?php
											}
										}
									?>
								
								</div>
							</div>
						<?php
						
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
									$q5current = array("marks" => $row['q_mark'], "id" => $row['q_id']);
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

						?>
							<div class="card mt-5">
								<div class="card-header text-center">
									<h4>List question for level 5</h4>
								</div>
								<div class="card-body">
									
									<?php
										if(empty($listAccurate)){
											$d = subsetNearestSums($arr, $n, $target);
											$listNearest = $d[0];
											$sumNearest = $d[1];
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Nearest sum :<?php echo($sumNearest);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listNearest); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listNearest[$i]);
												$near_lvl_five = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumNearest);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listNearest[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listNearest[$i][$m]["id"];
																	$near_lvl_five.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
																				<?php
																			}
																		}else{
																			echo "result tak keluar";
																		}
																	}else{
																		echo "tak masuk";
																	}
																}
															?>
															</div>
														</div>

														<div class="form-check text-right mr-3">
															<input type="radio" name="ques_level_five" value="<?php echo($near_lvl_five); ?>" style="transform: scale(2);">
															<label class="h4 ml-2">Add</label>
														</div>
													</div>
													<?php
											}
										}else{
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Accurate sum :<?php echo($sumAccurate);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listAccurate); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listAccurate[$i]);
												$acc_lvl_five = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumAccurate);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listAccurate[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listAccurate[$i][$m]["id"];
																	$acc_lvl_five.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																				<div class="col-md-5">
																					<div class="card my-3" style="width: 18rem;">
																						<div class="card-body">
																							<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																							<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																							<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																						</div>
																					</div>
																				</div>
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
															?>
															</div>

															<div class="form-check text-right mr-3">
																<input type="radio" name="ques_level_five" value="<?php echo($acc_lvl_five); ?>" style="transform: scale(2);">
																<label class="h4 ml-2">Add</label>
															</div>
														</div>
													</div>
													<?php
											}
										}
									?>
								
								</div>
							</div>
						<?php
						
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
						
						?>
							<div class="card mt-5">
								<div class="card-header text-center">
									<h4>List question for level 6</h4>
								</div>
								<div class="card-body">
									
									<?php
										if(empty($listAccurate)){
											$d = subsetNearestSums($arr, $n, $target);
											$listNearest = $d[0];
											$sumNearest = $d[1];
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Nearest sum :<?php echo($sumNearest);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listNearest); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listNearest[$i]);
												$near_lvl_six = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumNearest);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	$questionId = $listNearest[$i][$m]["id"];
																	$near_lvl_six.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
																				<?php
																			}
																		}else{
																			echo "result tak keluar";
																		}
																	}else{
																		echo "tak masuk";
																	}
																}
															?>
														</div>
													</div>

													<div class="form-check text-right mr-3">
														<input type="radio" name="ques_level_six" value="<?php echo($near_lvl_six); ?>" style="transform: scale(2);">
														<label class="h4 ml-2">Add</label>
													</div>
												</div>
												<?php
											}
										}else{
											?>
												<div class="row">
													<div class="col-md-3">
														<h5>Target value :<?php echo($target);?></h5>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-3">
														<h5>Accurate sum :<?php echo($sumAccurate);?></h5>
													</div>
												</div>
											<?php
											
											$o=1;
											for($i=0; $i<sizeof($listAccurate); $i++){
												//get length of each combination
												$combination = 0;
												$combination = sizeof($listAccurate[$i]);
												$acc_lvl_six = "";
												?>
												
												<div class="card mt-3">
													<div class="card-header">
														<div class="row">
															<div class="col-md-3">
																<h6>Total : <?php echo($sumAccurate);?></h6>
															</div>
															<div class="col-md-6 text-center">
																<h6>Set of question <?php echo($o+$i);?></h6>
															</div>
														</div>
													</div>
													<div class="card-body" >
														<div class="row justify-content-center">
															<?php
																for($m=0; $m<$combination; $m++){
																	
																	//$mark += $listAccurate[$i][$m]["marks"];
																	//print($mark);
																	$questionId = $listAccurate[$i][$m]["id"];
																	$acc_lvl_six.= $questionId."_";
																	$sqlQuestion = "SELECT * FROM questions WHERE q_id = $questionId";

																	if($resultQuestion = mysqli_query($link, $sqlQuestion)){
																		//echo("1lvl masuk");
																		if(mysqli_num_rows($resultQuestion) > 0){
																			//echo("2lvl masuk");
																			while($rowq = mysqli_fetch_array($resultQuestion)){
																				?>
																					<div class="col-md-5">
																						<div class="card my-3" style="width: 18rem;">
																							<div class="card-body">
																								<h5 class="card-title"><?php echo $rowq["q_question"];?></h5>
																								<h6 class="card-subtitle mb-2 text-muted">Question level: <?php echo $rowq["q_level"];?></h6>
																								<p class="card-text">Marks: <?php echo $rowq["q_mark"];?></p>
																							</div>
																						</div>
																					</div>
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
															?>
														</div>

														<div class="form-check text-right mr-3">
															<input type="radio" name="ques_level_six" value="<?php echo($acc_lvl_six); ?>" style="transform: scale(2);">
															<label class="h4 ml-2">Add</label>
														</div>
													</div>
												</div>
												<?php
											}
										}
									?>
								
								</div>
							</div>
						<?php
					}else{
						echo "macam tak masuk 1?";
					}
					?>

					<input type="hidden" name="subject_id" value="<?php echo($subId);?>">
					<input type="submit" name="submit" value="submit" class="btn btn-success my-3">
				</form>
			</div>
		</div>
		
	<?php
}else{
    echo "ni terus tak masuk wei";
}
?>
		</div>
	</div>
<?php
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