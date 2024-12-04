<?php
include('includes/config.php');
if(!empty($_POST["classid"])) 
{
	 //$cid=intval($_POST['classid']);
	$scid= $_POST['classid'];
	$data = array();
	$data=explode("$",$scid);
	$sid=$data[0];//subject id
	$cid=$data[1];//class
	$aid=$data[2];//25% marking type
	$eid=$data[3]; //exam name:test,half yearly...

	if(!is_numeric($cid)){	 
	 	echo htmlentities("invalid Class");exit;
	}
	else{
		//code for subject name
		$sql_sub = "SELECT SubjectName,SubjectCode from tblsubjects where id=:sid";
		$query_sub = $dbh->prepare($sql_sub);
		$query_sub->bindParam(':sid',$sid,PDO::PARAM_STR);
		$query_sub->execute();
		$result_sub=$query_sub->fetchAll(PDO::FETCH_OBJ);
		if($query_sub->rowCount() == 1) {
		    foreach ($result_sub as $row_sub) {
		        $Subjec_name=($row_sub->SubjectName);
		        $Subjec_code=($row_sub->SubjectCode);
		    }
		}
		$query_result = $dbh->prepare("SELECT ClassId,SubjectID,Exam_ID FROM tblresult WHERE ClassId=:cid and  SubjectID=:sid and Exam_ID=:eid");
	
		$query_result-> bindParam(':cid', $cid, PDO::PARAM_STR);
		$query_result-> bindParam(':sid', $sid, PDO::PARAM_STR);
		$query_result-> bindParam(':eid', $eid, PDO::PARAM_STR);
		$query_result-> execute();
		$result_dubresult = $query_result -> fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
		if($query_result -> rowCount() > 0)
		{ ?>
		<p>
		<?php
		echo "<span style='color:red'> Result Already Declared .</span>";
		 ?></p>
		<?php }
 
		else
		{			
			//code for ET,Prcatical,convertion
			$sql_25 = "SELECT Exam_name from tbleexams where id=:aid";
	        $query_25 = $dbh->prepare($sql_25);
	        $query_25->bindParam(':aid', $aid, PDO::PARAM_INT); 
	        $query_25->execute();
	        $results_25=$query_25->fetchAll(PDO::FETCH_OBJ);
	        if($query_25->rowCount() ==1)
	        {foreach ($results_25 as $row_25) {
	            $exam_name=($row_25->Exam_name);
	           if($exam_name == "ET-1" ){
				
	           		if(($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) 
						&& ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Math"|| $Subjec_name=="Biology" 
						|| $Subjec_name=="Information & Communication Technology"|| $Subjec_name=="Statistics")){
							$stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
							$stmt->execute(array(':cid' => $cid));
							?>
						<table class="table table-hover">
							<thead>
								<tr>
								
									<th>Student Name</th> 
									<th>Student Roll</th> 
									<th>Subjective</th> 
									<th>MCQ</th> 
									<th>ET Subjective</th>
									<th>ET MCQ</th>
								</tr>
							</thead>
							<tbody>
							<?php
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							?>
								<tr>
								
									<td><?php echo htmlentities($row['StudentName']); ?></td> 
									<td><?php echo htmlentities($row['Roll']); ?></td>
									<td>
										<input type="number" name="subective[]" placeholder="Subjective" required min="0" max="50">
										<span class="error-message"></span>
									</td>
									<td>
										<input type="number" name="mcq[]" placeholder="MCQ" required min="0" max="25">
										<span class="error-message"></span>
									</td>
									<td>
										<input type="number" name="et_sub[]" placeholder="ET Subjective" min="0" max="10">
										<span class="error-message"></span>
									</td>
									<td>
										<input type="number" name="et_mcq[]" placeholder="ET MCQ" min="0" max="10">
										<span class="error-message"></span>
									</td>
								</tr>
							<?php
							}
							?>
							</tbody>
						</table>
						<script>
							
							const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
							const mcqInputs = document.querySelectorAll('input[name="mcq[]"]');
							const etSubInputs = document.querySelectorAll('input[name="et_sub[]"]');
							const etMcqlInputs = document.querySelectorAll('input[name="et_mcq[]"]');

							subjectiveInputs.forEach(function(input) {
								input.addEventListener('input', function() {
									validateInput(input, 'Please enter a valid number between 0 and 50.');
								});
							});

							mcqInputs.forEach(function(input) {
								input.addEventListener('input', function() {
									validateInput(input, 'Please enter a valid number between 0 and 25.');
								});
							});

							etSubInputs.forEach(function(input) {
								input.addEventListener('input', function() {
									validateInput(input, 'Please enter a valid number between 0 and 10.');
								});
							});
							etMcqlInputs.forEach(function(input) {
								input.addEventListener('input', function() {
									validateInput(input, 'Please enter a valid number between 0 and 10.');
								});
							});

							function validateInput(input, errorMessage) {
								const errorSpan = input.nextElementSibling;
								if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
									errorSpan.textContent = errorMessage;
								} else {
									errorSpan.textContent = '';
								}
							}
						</script>
						<?php
					}
				// Business studies subject
					else if(($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101))) {
						 $stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						 $stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            <th>MCQ</th>
						            <th>ET Subjective</th>
						            <th>ET MCQ</th> 
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective" required min="0" max="70">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="mcq[]" placeholder="MCQ" required min="0" max="30">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="et_sub[]" placeholder="ET Subjective" min="0" max="10">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="et_mcq[]" placeholder="ET MCQ" min="0" max="10">
						                <span class="error-message"></span>
						            </td>
						           
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
					<script>
					    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
					    const mcqInputs = document.querySelectorAll('input[name="mcq[]"]');
					    const etSubInputs = document.querySelectorAll('input[name="et_sub[]"]');
					    const etMcqlInputs = document.querySelectorAll('input[name="et_mcq[]"]');

					    subjectiveInputs.forEach(function(input) {
					        input.addEventListener('input', function() {
					            validateInput(input, 'Please enter a valid number between 0 and 70.');
					        });
					    });

					    mcqInputs.forEach(function(input) {
					        input.addEventListener('input', function() {
					            validateInput(input, 'Please enter a valid number between 0 and 30.');
					        });
					    });

					    etSubInputs.forEach(function(input) {
					        input.addEventListener('input', function() {
					            validateInput(input, 'Please enter a valid number between 0 and 10.');
					        });
					    });
					    etMcqlInputs.forEach(function(input) {
					        input.addEventListener('input', function() {
					            validateInput(input, 'Please enter a valid number between 0 and 10.');
					        });
					    });
					    function validateInput(input, errorMessage) {
					        const errorSpan = input.nextElementSibling;
					        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
					            errorSpan.textContent = errorMessage;
					        } else {
					            errorSpan.textContent = '';
					        }
					    }
					</script>
					  <?php
					}
					//For Bangla 2nd and English
					else if(($Subjec_name=="English" || ($Subjec_name == "Bangla" && $Subjec_code==102 ))) {
						 $stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						 $stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            <th>ET Subjective</th>
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective" required min="0" max="100">
						                <span class="error-message"></span>
						            </td>
						           <td>
						                <input type="number" name="et_sub[]" placeholder="ET Subjective" min="0" max="20">
						                <span class="error-message"></span>
						            </td>
						           
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
					<script>
					    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
					    const etSubInputs = document.querySelectorAll('input[name="et_sub[]"]');

					    subjectiveInputs.forEach(function(input) {
					        input.addEventListener('input', function() {
					            validateInput(input, 'Please enter a valid number between 0 and 100.');
					        });
					    });
					     etSubInputs.forEach(function(input) {
					        input.addEventListener('input', function() {
					            validateInput(input, 'Please enter a valid number between 0 and 20.');
					        });
					    });
					    
					    function validateInput(input, errorMessage) {
					        const errorSpan = input.nextElementSibling;
					        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
					            errorSpan.textContent = errorMessage;
					        } else {
					            errorSpan.textContent = '';
					        }
					    }
					</script>
					  <?php
					}
		           	
		        }// end ET if 
	             //Start practical if block      
	            if($exam_name == "Practical"){
	                if(($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Mathematics"|| $Subjec_name=="Biology" || $Subjec_name=="Information and Communication Technology"|| $Subjec_name=="Statistics")){
						 $stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						 $stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            <th>MCQ</th> 
						            <th>Practical</th>
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective"  min="0" max="50">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="mcq[]" placeholder="MCQ"  min="0" max="25">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="practical[]" placeholder="Practical" min="0" max="25">
						                <span class="error-message"></span>
						            </td>
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
						<script>
						    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
						    const mcqInputs = document.querySelectorAll('input[name="mcq[]"]');
						    const practicalInputs = document.querySelectorAll('input[name="practical[]"]');

						    subjectiveInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 50.');
						        });
						    });

						    mcqInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 25.');
						        });
						    });

						    practicalInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 25.');
						        });
						    });

						    function validateInput(input, errorMessage) {
						        const errorSpan = input.nextElementSibling;
						        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
						            errorSpan.textContent = errorMessage;
						        } else {
						            errorSpan.textContent = '';
						        }
						    }
						</script>
					  <?php
					}
					// Business studies subject
					else if(($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101))) {
							 $stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						 $stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            <th>MCQ</th> 
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective"  min="0" max="70">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="mcq[]" placeholder="MCQ"  min="0" max="30">
						                <span class="error-message"></span>
						            </td>
						           
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
						<script>
						    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
						    const mcqInputs = document.querySelectorAll('input[name="mcq[]"]');
						   
						    subjectiveInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 70.');
						        });
						    });

						    mcqInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 30.');
						        });
						    });


						    function validateInput(input, errorMessage) {
						        const errorSpan = input.nextElementSibling;
						        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
						            errorSpan.textContent = errorMessage;
						        } else {
						            errorSpan.textContent = '';
						        }
						    }
						</script>
					  <?php
					}
					//For Bangla 2nd and English
					else if(($Subjec_name=="English" || ($Subjec_name == "Bangla" && $Subjec_code==102 ))) {
						 $stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						 $stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective"  min="0" max="100">
						                <span class="error-message"></span>
						            </td>
						           
						           
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
						<script>
						    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
						   

						    subjectiveInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 100.');
						        });
						    });
						    function validateInput(input, errorMessage) {
						        const errorSpan = input.nextElementSibling;
						        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
						            errorSpan.textContent = errorMessage;
						        } else {
						            errorSpan.textContent = '';
						        }
						    }
						</script>
					  <?php
					}
			                  
	            } // end practical else if 
	            //start convertion if block
	            if($exam_name == "Conversion"){
	                if(($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Mathematics"|| $Subjec_name=="Biology" || $Subjec_name=="Information and Communication Technology"|| $Subjec_name=="Statistics")){
						 $stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						 $stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            <th>MCQ</th> 
						            
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective"  min="0" max="50">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="mcq[]" placeholder="MCQ"  min="0" max="25">
						                <span class="error-message"></span>
						            </td>
						            
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
						<script>
						    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
						    const mcqInputs = document.querySelectorAll('input[name="mcq[]"]');
						    
						    subjectiveInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 50.');
						        });
						    });

						    mcqInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 25.');
						        });
						    });					 
						    function validateInput(input, errorMessage) {
						        const errorSpan = input.nextElementSibling;
						        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
						            errorSpan.textContent = errorMessage;
						        } else {
						            errorSpan.textContent = '';
						        }
						    }
						</script>
					  <?php
					}
					// Business studies subject
					else if(($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101))) {
						$stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						$stmt->execute(array(':cid' => $cid));
						 ?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            <th>MCQ</th> 
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective"  min="0" max="70">
						                <span class="error-message"></span>
						            </td>
						            <td>
						                <input type="number" name="mcq[]" placeholder="MCQ"  min="0" max="30">
						                <span class="error-message"></span>
						            </td>
						           
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
						<script>
						    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
						    const mcqInputs = document.querySelectorAll('input[name="mcq[]"]');
						   
						    subjectiveInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 70.');
						        });
						    });

						    mcqInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 30.');
						        });
						    });


						    function validateInput(input, errorMessage) {
						        const errorSpan = input.nextElementSibling;
						        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
						            errorSpan.textContent = errorMessage;
						        } else {
						            errorSpan.textContent = '';
						        }
						    }
						</script>
					  <?php
					}
					//For Bangla 2nd and English
					else if(($Subjec_name=="English" || ($Subjec_name == "Bangla" && $Subjec_code==102 ))) {
						$stmt = $dbh->prepare("SELECT StudentName,Student_ID,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
						$stmt->execute(array(':cid' => $cid));
						?>
						<table class="table table-hover">
						    <thead>
						        <tr>
						            <th>Student Name</th> 
						            <th>Student Roll</th> 
						            <th>Subjective</th> 
						            
						        </tr>
						    </thead>
						    <tbody>
						    <?php
						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						    ?>
						        <tr>
						            <td><?php echo htmlentities($row['StudentName']); ?></td> 
						            <td><?php echo htmlentities($row['Roll']); ?></td>
						            <td>
						                <input type="number" name="subective[]" placeholder="Subjective"  min="0" max="100">
						                <span class="error-message"></span>
						            </td>
						           
						           
						        </tr>
						    <?php
						    }
						    ?>
						    </tbody>
						</table>
						<script>
						    const subjectiveInputs = document.querySelectorAll('input[name="subective[]"]');
						   

						    subjectiveInputs.forEach(function(input) {
						        input.addEventListener('input', function() {
						            validateInput(input, 'Please enter a valid number between 0 and 100.');
						        });
						    });
						    function validateInput(input, errorMessage) {
						        const errorSpan = input.nextElementSibling;
						        if (input.validity.rangeOverflow || input.validity.rangeUnderflow) {
						            errorSpan.textContent = errorMessage;
						        } else {
						            errorSpan.textContent = '';
						        }
						    }
						</script>
					  <?php
					}              
	           }// end convertion else block
	       }}		
		} //end duplicate result else block
	} //end else block
} //end first if
?>
<?php
// Code for Subjects teacher
if(!empty($_POST["subjectid"])) 
{
 $stid=intval($_POST['subjectid']);
 if(!is_numeric($stid)){
 
    echo htmlentities("invalid Subject");exit;
 }
 else{
 $stmt_subteacher= $dbh->prepare("SELECT TeacherName,id FROM tbleteachers WHERE Subject_ID= :id order by TeacherName");
 $stmt_subteacher->execute(array(':id' => $stid));
 ?><option value="">Select Teacher Name </option><?php
 while($row_subteacher=$stmt_subteacher->fetch(PDO::FETCH_ASSOC))
 {
  ?>
  <option value="<?php echo htmlentities($row_subteacher['id']); ?>"><?php echo htmlentities($row_subteacher['TeacherName']); ?></option>
  <?php
 }
 }
}

?>

 <?php
if (!empty($_POST["science_business_group"])) {
    $groupid = $_POST['science_business_group'];
    // Removed unnecessary code related to explode
    $stmt_subject = $dbh->prepare("SELECT SubjectName, SubjectCode, id FROM tblsubjects WHERE Group_Sub = :group ORDER BY SubjectName");
    $stmt_subject->execute(array(':group' => $groupid)); // Use $groupid directly
    ?>
   <option value="">Select Subject</option>
    <?php
    while ($row_sub = $stmt_subject->fetch(PDO::FETCH_ASSOC)) {
        ?>  
        <option value="<?php echo htmlentities($row_sub['id']); ?>">
            <?php echo htmlentities($row_sub['SubjectName'] . ' ' . $row_sub['SubjectCode']); ?>
        </option>
        <?php
    }
}
?>

