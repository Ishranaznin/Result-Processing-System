<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['update']))
{
$exam_id=$_POST['exam_id'];
$subjective=$_POST['subjective']; 
//$mcq=$_POST['mcq'];
//$et_mcq=$_POST['et_mcq'];
//$et_sub=$_POST['et_sub'];
//$practical=$_POST['practical'];
$cid=intval($_GET['studenteditid']);

$mcq=isset($_POST['mcq'])? $_POST['mcq'] : NULL;
$practical=isset($_POST['practical']) ? $_POST['practical'] : NULL;
$et_sub=isset($_POST['et_sub']) ? $_POST['et_sub'] : NULL;
$et_mcq=isset($_POST['et_mcq']) ? $_POST['et_mcq'] : NULL;

$sql_up="update tblresult set Subjective=:subjective, MCQ=:mcq, Practical=:practical, ET_sub=:et_sub, ET_MCQ=:et_mcq, Exam_ID=:exam_id where id=:cid ";
$query_up = $dbh->prepare($sql_up);
$query_up->bindParam(':subjective',$subjective,PDO::PARAM_STR);
$query_up->bindParam(':mcq',$mcq,PDO::PARAM_STR);
$query_up->bindParam(':practical',$practical,PDO::PARAM_STR);
$query_up->bindParam(':et_sub',$et_sub,PDO::PARAM_STR);
$query_up->bindParam(':et_mcq',$et_mcq,PDO::PARAM_STR);
$query_up->bindParam(':exam_id',$exam_id,PDO::PARAM_STR);
$query_up->bindParam(':cid',$cid,PDO::PARAM_STR);
$query_up->execute();
if($query_up->rowCount() > 0) {
        $msg = "Result has been updated successfully";
        // Redirect to next.php after successful update
        header("Location: manage-results.php");
        exit(); // Ensure that no other output is sent
    } else {
        $error = "Failed to update result";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin Update Class</title>
        <link rel="stylesheet" href="css/bootstrap.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php');?>   
          <!-----End Top bar>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

<!-- ========== LEFT SIDEBAR ========== -->
<?php include('includes/leftbar.php');?>                   
 <!-- /.left-sidebar -->

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Update Student Result</h2>
                                </div>
                                
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#">Resultes</a></li>
                                        <li class="active">Update Result</li>
                                    </ul>
                                </div>
                               
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                             

                              

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Update Student Result info</h5>
                                                </div>
                                            </div>
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

                                                <form class="form" method="post">
                                                     
        
            <p  align="center" style="background-color:Tomato;">Please Enter 0 for NULL fields.</p>   
  
<?php 
$cid=intval($_GET['studenteditid']);
$sql = "SELECT * from  tblresult where id=:cid";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>

    <div class="form-group has-success">
        <label for="success" class="control-label">Student Name</label>
        <?php
            $stId= $result->StudentId;
            $sql2= "SELECT * from tblstudents where StudentId=:stId";
            $query2 = $dbh->prepare($sql2);            
            $query2->bindParam(':stId',$stId,PDO::PARAM_STR);
            $query2->execute();
            $resultN=$query2->fetchAll(PDO::FETCH_OBJ);
        ?>
        <div class="">
            <input type="text" name="studentname" value="<?php echo htmlentities($resultN[0]->StudentName);?>" class="form-control" id="success" disabled>
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group has-success">
        <label for="success" class="control-label">Roll</label>
        <div class="">
            <input type="number" name="roll" value="<?php echo htmlentities($resultN[0]->Roll);?>" class="form-control" id="success" disabled>
            
        </div>
    </div>
    <div class="form-group has-success">
        <label for="success" class="control-label">Class</label>
        <?php
            $clId= $result->ClassId;
            $sql3= "SELECT * from tblclasses where id=:clId";
            $query3 = $dbh->prepare($sql3);            
            $query3->bindParam(':clId',$clId,PDO::PARAM_STR);
            $query3->execute();
            $resultC=$query3->fetchAll(PDO::FETCH_OBJ);
        ?>
        <div class="">
            <input type="text" name="roll" value="<?php echo htmlentities($resultC[0]->ClassName);?>" class="form-control" id="success" disabled>
            
        </div>
    </div>
    <div class="form-group has-success">
        <label for="success" class="control-label">Section</label>
        <div class="">
            <input type="text" name="sectionS" value="<?php echo htmlentities($resultC[0]->Section);?>" class="form-control" id="success" disabled>
            
        </div>
    </div>
    <div class="form-group has-success">
        <label for="success" class="control-label">Subject</label>
        <?php
            $subId= $result->SubjectId;
            $sql4= "SELECT * from tblsubjects where id=:subId";
            $query4 = $dbh->prepare($sql4);            
            $query4->bindParam(':subId',$subId,PDO::PARAM_STR);
            $query4->execute();
            $resultS=$query4->fetchAll(PDO::FETCH_OBJ);
        ?>
        <div class="">
            <input type="text" name="roll" value="<?php echo htmlentities($resultS[0]->SubjectName);?>" class="form-control" id="success" disabled>
            
        </div>
    </div>
    <div class="form-group ">
        <label for="default" class="control-label">Exam</label>
        <div class="">
            <select name="exam_id" class="form-control exid" id="exam_id">

              <?php
                $examId= $result->Exam_ID;
                $sql5= "SELECT * from tbleexams where id=:examId NOT IN ('ET','Practical','Conversion') order by Exam_year desc ";
                $query5 = $dbh->prepare($sql5);            
                $query5->bindParam(':examId',$examId,PDO::PARAM_STR);
                $query5->execute();
                $resultExam=$query5->fetchAll(PDO::FETCH_OBJ);
                if ($query5->rowCount() > 0) {
                    echo '<option value="' . htmlentities($resultExam[0]->id) . '">';
                    echo htmlentities($resultExam[0]->Exam_name) . ' - ' . htmlentities($resultExam[0]->Exam_year);
                    echo '</option>';
                }

                // Fetch and display the remaining exams as options
                $sqlRemainingExams = "SELECT * FROM tbleexams WHERE id != :examId ORDER BY Exam_name DESC";
                $queryRemainingExams = $dbh->prepare($sqlRemainingExams);            
                $queryRemainingExams->bindParam(':examId', $examId, PDO::PARAM_STR);
                $queryRemainingExams->execute();
                $remainingExams = $queryRemainingExams->fetchAll(PDO::FETCH_OBJ);

                foreach ($remainingExams as $exam) {
                    echo '<option value="' . htmlentities($exam->id) . '">';
                    echo htmlentities($exam->Exam_name) . ' - ' . htmlentities($exam->Exam_year);
                    echo '</option>';
                }
                    
                ?> 
                </select>
        </div>           
    </div>
  
    <div class="form-group ">
        <label for="default" class="control-label">Subjective</label>
        <div class="">
            <input type="number" name="subjective" value="<?php echo htmlentities($result->Subjective);?>" required="required" class="form-control" id="success">
            
        </div>
    </div>
     <div class="form-group has-success">
        <label for="success" class="control-label">MCQ</label>
        <div class="">
            <input type="number" name="mcq" value="<?php echo htmlentities($result->MCQ);?>" class="form-control" required="required" id="success">
            
        </div>
    </div>
    <div class="form-group has-success">
        <label for="success" class="control-label">Practical</label>
        <div class="">
            <input type="number" name="practical" value="<?php echo htmlentities($result->Practical);?>" class="form-control" id="success">
            
        </div>
    </div>
    <div class="form-group has-success">
        <label for="success" class="control-label">ET Subjective</label>
        <div class="">
            <input type="number" name="et_sub" value="<?php echo htmlentities($result->ET_sub);?>" class="form-control" id="success">     
        </div>
    </div>

    <div class="form-group has-success">
        <label for="success" class="control-label">ET MCQ</label>
        <div class="">
            <input type="number" name="et_mcq" value="<?php echo htmlentities($result->ET_MCQ);?>" class="form-control" id="success">
            
        </div>
    </div>

      <?php }} ?>
    <div class="form-group has-success">
        <div class="">
           <button type="submit" name="update" class="btn btn-success btn-labeled">Update<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
           <a href="manage-results.php" class="btn btn-default">Back</a>
        </div>
    </div>                                                  
</form>

                                              
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-8 col-md-offset-2 -->
                                </div>
                                <!-- /.row -->

                               
                               

                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

             
                    <!-- /.right-sidebar -->

                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>



        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
<?php  } ?>
