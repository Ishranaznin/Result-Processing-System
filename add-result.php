<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
{

$subective=array();
$mcq=array();
$practical=array();
$et_sub=array();
$et_mcq=array();

$class=$_POST['class'];
$subjectid=$_POST['subjectid'];
$teacherid=$_POST['teacherid']; 
$exam_id=$_POST['exam_id'];
$assessment=$_POST['assessment_name'];

$subjective_mark=$_POST['subective'];
$mcq_mark=isset($_POST['mcq'])? $_POST['mcq'] : NULL;
$practical_mark=isset($_POST['practical']) ? $_POST['practical'] : NULL;
$et_subjective=isset($_POST['et_sub']) ? $_POST['et_sub'] : NULL;
$et_mc=isset($_POST['et_mcq']) ? $_POST['et_mcq'] : NULL;

$stmt_1 = $dbh->prepare("SELECT StudentId,StudentName,Roll FROM tblstudents WHERE ClassId= :cid order by Roll");
$stmt_1->execute(array(':cid' => $class));
$stid11=array();
while($row_student=$stmt_1->fetch(PDO::FETCH_ASSOC))
{
    array_push($stid11,$row_student['StudentId']);
} 

for($i=0;$i<count($et_sub);$i++){
    
    $sub_mar=$subjective_mark[$i];
    $mcq_mar=$mcq_mark[$i];
    $etsub_mar=$et_subjective[$i];
    $etmcq_mar=$et_mc[$i];
    $prac_mar=$practical_mark[$i];
    $stuid=$stid11[$i];
    $sql_insert="INSERT INTO tblresult(StudentId,ClassId,SubjectId,Subjective,MCQ,Practical,ET_sub,ET_MCQ,Exam_ID,Teacher_ID)
     VALUES(:stuid,:class,:subjectid,:subective,:mcq,:practical,:et_sub,:et_mcq,:exam_id,:teacherid)";

    $query_insert = $dbh->prepare($sql_insert);
    $query_insert->bindParam(':stuid',$stuid,PDO::PARAM_STR);
    $query_insert->bindParam(':class',$class,PDO::PARAM_STR);
    $query_insert->bindParam(':subjectid',$subjectid,PDO::PARAM_STR);
    $query_insert->bindParam(':subective',$sub_mar,PDO::PARAM_STR);
    $query_insert->bindParam(':mcq',$mcq_mar,PDO::PARAM_STR);
    $query_insert->bindParam(':practical',$prac_mar,PDO::PARAM_STR);
    $query_insert->bindParam(':et_sub',$etsub_mar,PDO::PARAM_STR);
    $query_insert->bindParam(':et_mcq',$etmcq_mar,PDO::PARAM_STR);
    $query_insert->bindParam(':exam_id',$exam_id,PDO::PARAM_STR);
    $query_insert->bindParam(':teacherid',$teacherid,PDO::PARAM_STR);
    $query_insert->execute();
    
    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
    $msg="Result info added successfully";
    }
    else 
    {
    $error="Something went wrong. Please try again";
    }
}// end of mark for loop

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SRMS Admin| Add Result </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        <script>
function getStudent(val) {
    var subid=$(".slid").val();//subject
    var clid=$(".clid").val();//class
    var aeid=$(".aeid").val();// 25% marking type
    var examid=$(".exid").val();//exam
    var sub_cl_id=subid+'$'+clid+'$'+aeid+'$'+examid;
    var abh=examid+'$'+subid+'$'+clid;
    $.ajax({
    type: "POST",
    url: "get_student.php",
    data:'classid='+sub_cl_id,
    success: function(data){
        $("#studentid").html(data);      
    }
    });

}
    </script>
<script>
function getSubject(val, gid) {      
    var group = val; // Use the value passed as argument
    $.ajax({
        type: "POST",
        url: "get_student.php",
        data: { science_business_group: group }, // Send data as an object
        success: function(data) {
            $("#subjectid").html(data);
        }
    });
}
</script>
<script>

function getTeacher(val) {
    $.ajax({
    type: "POST",
    url: "get_student.php",
    data:'subjectid='+val,
    success: function(data){
        $("#teacherid").html(data);
        
    }
    });
}
</script>
<script>

function getSubresult(val,slid) 
{      
    var slid=$(".slid").val();
    var val=$(".ttid").val();;
    var abh=slid+'$'+val;
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data:'studclass='+abh,
            success: function(data){
                $("#teacher").html(data);
                
            }
            });
}
</script>
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
                                    <h2 class="title">Declare Result</h2>                           
                                </div>                           
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Student Result</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                           
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
             <?php echo htmlentities($error); ?>
    </div>
    <?php } ?>
<form class="form-horizontal" method="post">

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Exam</label>
    <div class="col-sm-10">
    <select name="exam_id" class="form-control exid" id="exam_id" required="required">
        <option value="">Select Exam</option>
        <?php $sql = "SELECT * FROM tbleexams WHERE Exam_name NOT IN ('ET-1','Practical','Conversion') ORDER BY Exam_year DESC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
        foreach($results as $result)
        {   ?>
        <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->Exam_name); ?>&nbsp; <?php echo htmlentities($result->Exam_year); ?></option>
        <?php }} ?>
     </select>
    </div>
</div>

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">25% Marking Type</label>
    <div class="col-sm-10">
    <select name="assessment_name" class="form-control aeid" id="assessment_type" required="required">
        <option value="">Select Assessment Type</option>
    
        <?php
        $sql = "SELECT * FROM tbleexams WHERE Exam_name NOT IN ('Half Yearly', 'First Year Final', 'Pre Test', 'Test') ORDER BY Exam_year DESC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
        ?>
            <option value="<?php echo htmlentities($result->id); ?>">

                <?php echo htmlentities($result->Exam_name); ?>&nbsp; <?php echo htmlentities($result->Exam_year); ?>                       
            </option>
    <?php
        }
    }
    ?>           
        </select>
    </div>
</div>

<div class="form-group">
      <label for="default" class="col-sm-2 control-label">Group</label>
      <div class="col-sm-10">
        <select name="science_business_group" class="form-control gid" id="science_business_group" onChange="getSubject(this.value);" required="required">
        <option value="">Select Group</option>
          <option value="Science">Science</option>
          <option value="All">Science & Business Studies</option>
          <option value="Business Studies">Business Studies</option>
        </select>
      </div>
</div>

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Subject</label>
    <div class="col-sm-10">
    <select name="subjectid" class="form-control slid" id="subjectid" onChange="getTeacher(this.value);" required="required">
    
    </select>
    </div>
</div>  

<div class="form-group">
    <label for="default" class="col-sm-2 control-label ">Subject Teacher Name</label>
    <div class="col-sm-10">
    <select name="teacherid" class="form-control ttid" id="teacherid" required="required">
    </select>
    </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Class</label>
    <div class="col-sm-10">
    <select name="class" class="form-control clid" id="classid" onChange="getStudent(this.value);" required="required">
    <option value="">Select Class</option>
    <?php $sql = "SELECT * from tblclasses";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
    foreach($results as $result)
    {   ?>
    <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>
    <?php }} ?>
    </select>
    </div>
</div>


<div class="form-group">
    <label for="default" class="col-sm-2 control-label ">Student List</label>
    <div class="col-sm-10">
    <div  id="studentid">
    </div>
    </div>
</div>



                                          
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" id="submit" class="btn btn-primary">Declare Result</button>
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
        
    </body>
</html>
<?PHP } ?>
