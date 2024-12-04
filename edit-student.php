<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

$stid=intval($_GET['stid']);

if(isset($_POST['update']))
{
$studentname=$_POST['fullname'];
$studentid=$_POST['studentid']; 
$roolid=$_POST['rollid'];
$optional_subject=$_POST['optional_subject'];
$compulsory_subject=$_POST['compulsory_subject']; 
$gender=$_POST['gender']; 
$science_business_group=$_POST['science_business_group']; 
$classid=$_POST['classname']; 

$sql="update tblstudents set Student_ID=:studentid,
     StudentName=:studentname,
     Roll=:roolid,Gender=:gender,
     Science_Business_group=:science_business_group,
     ClassId=:classid,Optional_Subject=:optional_subject,
     Compulsory_Subject=:compulsory_subject where StudentId=:stid ";
$query = $dbh->prepare($sql);
$query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':science_business_group',$science_business_group,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query->bindParam(':compulsory_subject',$compulsory_subject,PDO::PARAM_STR);
$query->bindParam(':optional_subject',$optional_subject,PDO::PARAM_STR);
//$query->bindParam(':rank',$rank,PDO::PARAM_STR);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();
if($query->rowCount() > 0) {
        $msg = "Student info updated successfully";
        // Redirect to next.php after successful update
        header("Location: manage-students.php");
        exit(); // Ensure that no other output is sent
    } else {
        $error = "Failed to update student info";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Edit Student < </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
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
                                    <h2 class="title">Student Admission</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Student Admission</li>
                                    </ul>/
                                </div>
                             
                            </div>
                            <!-- /.row -->
                    </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Update Student info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg);
  echo '<script>window.location.href = "manage-students.php";</script>';
  ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                             <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form" method="post">
<?php 

$sql = "SELECT tblstudents.Student_ID,tblstudents.StudentName,tblstudents.Roll,tblstudents.Gender,tblstudents.StudentId,tblstudents.Science_Business_group,tblclasses.ClassName,tblclasses.Section,tblstudents.ClassId,tblstudents.Optional_Subject,tblstudents.Compulsory_Subject from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.StudentId=:stid";
$query = $dbh->prepare($sql);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

    <div class="form-group">
        <label for="default" class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-10">
        <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlentities($result->StudentName)?>" required="required" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label for="default" class="col-sm-2 control-label">Student Id</label>
        <div class="col-sm-10">
        <input type="text" name="studentid" class="form-control" id="studentid" value="<?php echo htmlentities($result->Student_ID)?>" maxlength="12" required="required" autocomplete="off">
        </div>
    </div>

   
    <div class="form-group">
        <label for="default" class="col-sm-2 control-label">Roll Id</label>
        <div class="col-sm-10">
        <input type="text" name="rollid" class="form-control" id="rollid" value="<?php echo htmlentities($result->Roll)?>" maxlength="5" required="required" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label">Class</label>
        <div class="col-sm-10">
         <select name="classname" class="form-control" id="classname" required="required">
       
            <?php 
            $classId= $result->ClassId;
            $sql2 = "SELECT * from tblclasses where id=:classId";
            $query2 = $dbh->prepare($sql2);
            $query2->bindParam(':classId',$classId,PDO::PARAM_STR);
            $query2->execute();
            $resultC=$query2->fetchAll(PDO::FETCH_OBJ);
            if($query2->rowCount() > 0)
            {
                echo '<option value="' . htmlentities($resultC[0]->id) . '">';
                            echo htmlentities($resultC[0]->ClassName) . ' - ' . htmlentities($resultC[0]->Section);
                echo '</option>';
            }
             // Fetch and display the remaining classes as options
                        $sqlRemainingCls = "SELECT * FROM tblclasses where id!=:classId";
                        $queryRemainingCls = $dbh->prepare($sqlRemainingCls);            
                        $queryRemainingCls->bindParam(':classId', $classId, PDO::PARAM_STR);
                        $queryRemainingCls->execute();
                        $remainingCls = $queryRemainingCls->fetchAll(PDO::FETCH_OBJ);

                        foreach ($remainingCls as $cls) {
                            echo '<option value="' . htmlentities($cls->id) . '">';
                            echo htmlentities($cls->ClassName) . ' - ' . htmlentities($cls->Section);
                            echo '</option>';
                        }
                        
                    ?> 
                    </select>
            </div>           
    </div>
         

    <div class="form-group">
          <label for="science_business_group" class="col-sm-2 control-label">Group</label>
          <div class="col-sm-10">
            <select name="science_business_group" class="form-control" id="science_business_group" required="required">
            <option value="">Select Group</option>
              <option value="Science">Science</option>
              <option value="Business Studies">Business Studies</option>
            </select>
          </div>
    </div>

   
    
    <div class="form-group">
        <label for="compulsory_subject" class="col-sm-2 control-label">Compulsory Subject</label>
            <div class="col-sm-10">
                <select name="compulsory_subject" class="form-control" id="compulsory_subject" required="required">
                    <option value="">Select Compulsory Subject</option>
                </select>
            </div>
    </div>

    <div class="form-group">
    <label for="optional_subject" class="col-sm-2 control-label">Optional Subject</label>
        <div class="col-sm-10">
            <select name="optional_subject" class="form-control" id="optional_subject" required="required">
                <option value="">Select Optional Subject</option>
            </select>
        </div>
    </div>

    <!-- <div class="form-group">
        <label for="default" class="col-sm-2 control-label">Gender</label>
        <div class="col-sm-10">
        <?php  $gndr=$result->Gender;
        if($gndr=="Male")
        {
        ?>
        <input type="radio" name="gender" value="Male" required="required" checked>Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required">Other
        <?php }?>
        <?php  
        if($gndr=="Female")
        {
        ?>
        <input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required" checked>Female <input type="radio" name="gender" value="Other" required="required">Other
        <?php }?>
        <?php  
        if($gndr=="Other")
        {
        ?>
        <input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required" checked>Other
        <?php }?>
        </div>
    </div> -->

<?php }} ?>                                                    

                                                    
<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
    
    
    <button type="submit" name="update" class="btn btn-success btn-labeled">Update<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
     <a href="manage-students.php" class="btn btn-default">Back</a>
</div>
</div>
</form>

</div>
</div>
</div>
<!-- /.col-md-12 -->
</div>
</div>
</div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
        

        <script>
    document.getElementById('science_business_group').addEventListener('change', function() {
        var group = this.value;
        
        // Compulsory Subject Dropdown
        var compulsorySubject = document.getElementById('compulsory_subject');
        compulsorySubject.innerHTML = ''; // Clear previous options
        
        // Optional Subject Dropdown
        var optionalSubject = document.getElementById('optional_subject');
        optionalSubject.innerHTML = '';  // Clear previous options

        // Default 'Select Compulsory Subject' option
        var defaultCompulsoryOption = document.createElement('option');
        defaultCompulsoryOption.value = '';
        defaultCompulsoryOption.textContent = 'Select Compulsory Subject';
        compulsorySubject.appendChild(defaultCompulsoryOption);

        // Default 'Select Optional Subject' option
        var defaultOptionalOption = document.createElement('option');
        defaultOptionalOption.value = '';
        defaultOptionalOption.textContent = 'Select Optional Subject';
        optionalSubject.appendChild(defaultOptionalOption);

        // Define the compulsory and optional subjects based on the selected group
        var compulsorySubjects = [];
        var optionalSubjects = [];

        if (group === 'Science') {
            compulsorySubjects = ['Biology', 'Higher Math', 'Statistics'];
            optionalSubjects = ['Biology', 'Higher Math', 'Statistics'];
        } else if (group === 'Business Studies') {
            compulsorySubjects = ['Statistics', 'FBI'];
            optionalSubjects = ['Statistics', 'FBI'];
        }

        // Populate the compulsory subjects dropdown
        compulsorySubjects.forEach(function(subject) {
            var option = document.createElement('option');
            option.value = subject;
            option.textContent = subject;
            compulsorySubject.appendChild(option);
        });

        // Populate the optional subjects dropdown
        optionalSubjects.forEach(function(subject) {
            var option = document.createElement('option');
            option.value = subject;
            option.textContent = subject;
            optionalSubject.appendChild(option);
        });
    });
</script>

    </body>
</html>
<?PHP } ?>
