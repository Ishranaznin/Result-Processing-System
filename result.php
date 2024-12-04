<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CESC Result Management System</title>
        <style>
           /*body {
            text-align: right;  Align content to the right 
        }*/
        .signature-container {
            position: relative;
            margin-bottom: 20px; /* Adjust as needed */
            display: inline-block; /* Make the container inline-block so it doesn't span the entire width */
            margin-right: 60px; /* Add margin between signatures */
        }
        .signature {
            border: 0;
            border-bottom: 1px solid #000;
            font-size: 16px;
            padding: 5px;
            width: 150px; /* Adjust width as needed */
        }
        .signature-label {
            position: absolute;
            top: 100%; /* Position label below the signature line */
            left: 0;
            font-size: 16px; /* Adjust font size as needed */
        }
         .table-container {
         /* Adjust the gap between the table and signatures */
         margin-top: 20px; 
    }
    .table2 {
        margin-bottom: 100px; /* Adjust the gap between the table and signatures */
    }
    </style>
        <style>
        .container-fluid {
            width: 100%; /* Adjust the width as needed */
            margin: 0 auto; /* Center the container */
        }
        </style>
        <style>
        /* Hide the print button by default */
        .print-button {
            display: block;
        }
        .back-button {
            display: block;
        }
        /* Hide the print button when printing */
        @media print {
            body * {
              visibility: hidden;
            }
            #contentToPrint, #contentToPrint * {
              visibility: visible;
            }
            #contentToPrint {
              position: absolute;
              left: 0;
              top: 0;
            }
            .print-button {
                display: none;
            }
            .back-button {
                display: none;
            }
        }
    </style>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
        table {
            border:1px solid #b3adad;
            border-collapse:collapse;
            padding:3px;
        }
        table th {
            border:1px solid #b3adad;
            padding:3px;
            background: #f0f0f0;
            color: #313030;
        }
        table td {
            border:1px solid #b3adad;
            text-align:center;
            padding:3px;
            background: #ffffff;
            color: #313030;
        }
    </style>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="content-wrapper">
                <div class="content-container">         
                    <!-- /.left-sidebar -->
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-12">
                                    
                                </div>
                            </div>
                            <!-- /.row -->                      
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->
                        <section class="section" id="exampl">
                            <div class="container-fluid">
                                <div class="row">                           
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel border border-secondary" id="contentToPrint">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                     <div style="float:left; width:30%; align-items: left">
                                                    
                                        <?php
                                        // code Student Data
                                        $rollid=$_POST['rollid'];
                                        $classid=$_POST['class'];                                      
                                        $exam_id=$_POST['exam_id'];
                                        $assessment_exam_id=$_POST['assessment_exam_id']; //25% marking type
                                        //$exam_paper=$_POST['exam_paper'];
                                        $_SESSION['rollid']=$rollid;
                                        $_SESSION['classid']=$classid;                                     
                                        $_SESSION['exam_id']=$exam_id;
                                        $_SESSION['assessment_exam_id']=$assessment_exam_id;
                                        //$_SESSION['exam_paper']=$exam_paper;
                                        $qery = "SELECT   tblstudents.Student_ID,tblstudents.StudentName,tblstudents.Roll,tblstudents.StudentId,tblstudents.Science_Business_group,tblstudents.Optional_Subject,tblstudents.Compulsory_Subject,tblclasses.ClassName,tblclasses.Section from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.Roll=:rollid and tblstudents.ClassId=:classid ";
                                        $stmt = $dbh->prepare($qery);
                                        $stmt->bindParam(':rollid',$rollid,PDO::PARAM_STR);
                                        $stmt->bindParam(':classid',$classid,PDO::PARAM_STR);
                                        $stmt->execute();
                                        $resultss=$stmt->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($stmt->rowCount() > 0)
                                        {
                                        foreach($resultss as $row)
                                        {   ?>
                                        <b>Student Id: </b> <?php echo htmlentities($row->Student_ID);?><br>
                                        <b>Name : </b> <?php echo htmlentities($row->StudentName);?><br>
                                        <b>Class: </b> <?php echo htmlentities($row->ClassName);?><br>
                                        <b>Section: </b><?php echo htmlentities($row->Section);?><br>
                                        <b>Group: </b><?php echo htmlentities($row->Science_Business_group);?><br>
                                        <b>Roll: </b><?php echo htmlentities($row->Roll);?><br>
                                        <?php $optional_subject_name=$row->Optional_Subject;
                                         $compulsory_subject_name=$row->Compulsory_Subject;
                                        
                                         }
                                            

    //code for Exam type:halfy yearly, test, final,pretest
    $sql3 = "SELECT * FROM tbleexams WHERE id =:exam_id";
    $query4 = $dbh->prepare($sql3);
    $query4->bindParam(':exam_id',$exam_id,PDO::PARAM_STR);
    $query4->execute();
    $results4=$query4->fetchAll(PDO::FETCH_OBJ);
    if($query4->rowCount() == 1) {
        foreach ($results4 as $row4) {
            $exam_type=($row4->Exam_name);
            $exam_year=($row4->Exam_year);
            
        }
    }?>
                                    </div>
<div style="float:left; width:40%;">
    <div class="card" style="width: 18rem;">
    <img src="images/cantlogo.png" class="card-img-top" style="display: block; margin: 0 auto;">
    <div class="card-body">
    <h8 class="card-title">Cantonment English School & College<br>
    Result Sheet<br>
    Chattogram Cantonment<br>
    Academic Year <?php echo htmlentities($exam_year -1);?></h8>
    
    </div>
    </div>
</div>
<!-- Right side with table -->
<div style="float:left; width:30%;">
    <?php
        if($exam_type=="Test"){?>
            <table border="1">
                <thead>
                    <tr>
                     <th>SN</th>    <th>Class Interval</th>    <th>Grade Point</th>   <th>Grade Letter</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                     <td>1&nbsp;</td>   <td>0-32&nbsp;</td>  <td>&nbsp;0</td>  <td>F&nbsp;</td>
                    </tr>
                    <tr>
                      <td>2</td>  <td>33-39&nbsp;</td>  <td>&nbsp;1</td> <td>D&nbsp;</td>
                    </tr>
                    <tr>
                      <td>3</td>  <td>40-49&nbsp;</td>  <td>&nbsp;2</td> <td>C&nbsp;</td>
                    </tr>
                    <tr>
                       <td>4&nbsp;</td>       <td>50-59</td>     <td>3&nbsp;</td>    <td>B&nbsp;</td>
                    </tr>
                    <tr>
                        <td>5&nbsp;</td>    <td>60-69&nbsp;</td>    <td>&nbsp;3.5</td>  <td>&nbsp;A-</td>
                    </tr>
                    <tr>
                        <td>&nbsp;6</td>    <td>70-79</td>    <td>&nbsp;4</td>  <td>&nbsp;A</td>
                    </tr>
                    <tr>
                       <td>&nbsp;7</td>     <td>80-100&nbsp;</td>   <td>&nbsp;5</td>  <td>&nbsp;A+</td>
                    </tr>
                </tbody>
            </table>
    <?php
    }
    if($exam_type=="Half Yearly" || $exam_type=="Final" || $exam_type=="Pre Test"){
        ?>
          <table border="1">
            <thead>
                <tr>
                 <th>SN</th>    <th>Class Interval</th>    <th>Grade Point</th>   <th>Grade Letter</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                 <td>1&nbsp;</td>   <td>0-39&nbsp;</td>  <td>&nbsp;0</td>  <td>F&nbsp;</td>
                </tr>
                <tr>
                  <td>2</td>  <td>40-49&nbsp;</td>  <td>&nbsp;2</td> <td>C&nbsp;</td>
                </tr>
                <tr>
                   <td>3&nbsp;</td>       <td>50-59</td>     <td>3&nbsp;</td>    <td>B&nbsp;</td>
                </tr>
                <tr>
                    <td>4&nbsp;</td>    <td>60-69&nbsp;</td>    <td>&nbsp;3.5</td>  <td>&nbsp;A-</td>
                </tr>
                <tr>
                    <td>&nbsp;5</td>    <td>70-79</td>    <td>&nbsp;4</td>  <td>&nbsp;A</td>
                </tr>
                <tr>
                   <td>&nbsp;6</td>     <td>80-100&nbsp;</td>   <td>&nbsp;5</td>  <td>&nbsp;A+</td>
                </tr>
            </tbody>
        </table>
        
    <?php
    }
    ?>
      
</div>
<div style="clear:both;"></div> <!-- Clear floating elements -->
  </div>
                                            <div class="panel-body p-20 table-container">
                                                <table class="table2 table-hover" border="1" width="100%">
<thead>
        <tr style="text-align: center">
            <th style="text-align: center">SN</th>
            <th style="text-align: center"> Subject Name</th> 
            <th style="text-align: center"> Subject Code</th>    
            <th style="text-align: center">Full Mark</th>
            <th style="text-align: center"> Subjective</th>
            <th style="text-align: center"> MCQ</th>
            <?php
            $sql2 = "SELECT Exam_name from tbleexams where id=:assessment_exam_id";
            $query2 = $dbh->prepare($sql2);
            $query2->bindParam(':assessment_exam_id', $assessment_exam_id, PDO::PARAM_INT); 
            $query2->execute();
            $results2=$query2->fetchAll(PDO::FETCH_OBJ);
            if($query2->rowCount() ==1)
            {   foreach ($results2 as $row) {
            $assessment_exam_name=($row->Exam_name);
            if($assessment_exam_name == "ET" ){
            ?>
            <th style="text-align: center"> ET Subjective</th>
            <th style="text-align: center"> ET MCQ</th>
            <?php } 


            else if($assessment_exam_name == "Practical"){
            ?>
            <th style="text-align: center"> Practical</th>                      
            <?php  }
            else{
            ?>
            <th style="text-align: center"> Converted Subjective</th>
            <th style="text-align: center"> Converted MCQ</th>
            <?php   }}}
            ?>        
                        <th style="text-align: center"> Total</th>
                        <?php
                            if($exam_paper=="3"){
                        ?>
                                <th style="text-align: center"> Total Average</th>
                        <?php   
                         }
                        ?>
                        <th style="text-align: center"> GP</th>
                        <th style="text-align: center"> Grade</th>

                    </tr>
</thead>
<tbody>
    <?php 
    //code for optional subject
   /* $sql4 = "SELECT SubjectName from tblsubjects where id=:optional_subject";
    $query5 = $dbh->prepare($sql4);
    $query5->bindParam(':optional_subject',$optional_subject,PDO::PARAM_STR);
    $query5->execute();
    $results5=$query5->fetchAll(PDO::FETCH_OBJ);
    if($query5->rowCount() == 1) {
        foreach ($results5 as $row5) {
            $optional_subject_name=($row5->SubjectName);
            $optional_subject_code=($row5->SubjectCode);
        }
    }*/                                             
// Code for result

 /*$query3 ="SELECT t.SubjectName, t.Exam_year,t.SubjectCode,
            SUM(CASE WHEN t.Exam_name = 'Half Yearly' THEN t.Subjective END) AS Half_Subjective,
            SUM(CASE WHEN t.Exam_name = 'Half Yearly' THEN t.MCQ END) AS Half_MCQ,
            SUM(CASE WHEN t.Exam_name = 'Final' THEN t.Subjective END) AS Final_Subjective,
            SUM(CASE WHEN t.Exam_name = 'Final' THEN t.MCQ END) AS Final_MCQ,
            SUM(CASE WHEN t.Exam_name = 'Pre Test' THEN t.Subjective END) AS Pre_Subjective,
            SUM(CASE WHEN t.Exam_name = 'Pre Test' THEN t.MCQ END) AS Pre_MCQ,
            SUM(CASE WHEN t.Exam_name = 'Test' THEN t.Subjective END) AS Test_Subjective,
            SUM(CASE WHEN t.Exam_name = 'Test' THEN t.MCQ END) AS Test_MCQ,
            SUM(CASE WHEN t.Exam_name = 'ET' THEN t.Subjective END) AS ET_Subjective,
            SUM(CASE WHEN t.Exam_name = 'ET' THEN t.MCQ END) AS ET_MCQ,
            SUM(CASE WHEN t.Exam_name = 'Practical' THEN t.Subjective END) AS Practical_Subjective,
            SUM(CASE WHEN t.Exam_name = 'Practical' THEN t.MCQ END) AS Practical_MCQ
        FROM (
            SELECT sts.StudentName, sts.Roll, sts.ClassId, tr.Subjective, tr.MCQ, 
                   SubjectId, tbleexams.id AS Exam_id, tbleexams.Exam_name, 
                   tbleexams.Exam_year, tblsubjects.SubjectName,tblsubjects.SubjectCode 
            FROM tblstudents AS sts 
            JOIN tblresult AS tr ON tr.StudentId = sts.StudentId 
            JOIN tbleexams ON tr.Exam_ID = tbleexams.id
            JOIN tblsubjects ON tblsubjects.id = tr.SubjectId
            WHERE (sts.Roll = :rollid AND sts.ClassId = :classid 
                AND (tbleexams.id = :exam_id OR tbleexams.id = :assessment_exam_id))
        ) AS t 
        GROUP BY t.SubjectName, t.Exam_year
        ORDER BY t.SubjectName, t.Exam_year;";*/
    $query3="SELECT sts.StudentName, sts.Roll, sts.ClassId, tr.Subjective, tr.MCQ, tr.Practical,tr.ET_sub,tr.ET_MCQ, SubjectId, tbleexams.id AS Exam_id, tbleexams.Exam_name, 
     tbleexams.Exam_year, tblsubjects.SubjectName,tblsubjects.SubjectCode 
     FROM tblstudents AS sts 
     JOIN tblresult AS tr ON tr.StudentId = sts.StudentId 
     JOIN tbleexams ON tr.Exam_ID = tbleexams.id
     JOIN tblsubjects ON tblsubjects.id = tr.SubjectId
      WHERE (sts.Roll = :rollid AND sts.ClassId = :classid  AND tbleexams.id = :exam_id)
      ORDER BY FIELD(tblsubjects.SubjectName, 'Bangla', 'English', 'Information and Communication Technology', 'Physics','Chemistry','Biology','Higher Mathematics','Accounting','Finance Banking and Insurance','Business Organization and Management','Statistics');";
    $query3= $dbh -> prepare($query3);
    $query3->bindParam(':rollid',$rollid,PDO::PARAM_STR);
    $query3->bindParam(':classid',$classid,PDO::PARAM_STR);
    $query3->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
    //$query3->bindParam(':assessment_exam_id', $assessment_exam_id, PDO::PARAM_INT);
    $query3-> execute();  
    $results3 = $query3 -> fetchAll(PDO::FETCH_OBJ);
    $cnt=1;

if(($query3->rowCount())>0)
{    
foreach($results3 as $result3) { 
    $cnt_sub=1; 
    $Subjec_name=($result3->SubjectName);  
    if(($Subjec_name=="Higher Mathematics" && ($optional_subject_name!="Higher Mathematics" && $compulsory_subject_name!="Higher Mathematics")) || ($Subjec_name=="Biology" && ($Subjec_name!=$optional_subject_name && $Subjec_name!=$compulsory_subject_name)) || ($Subjec_name=="Statistics" &&($optional_subject_name!="Statistics" && $compulsory_subject_name!="Statistics")) || ($Subjec_name=="Finance Banking and Insurance" && ($optional_subject_name|="Finance Banking and Insurance" && $compulsory_subject_name!="Finance Banking and Insurance"))){
        continue;
    } 
    ?>                                                 		
    <tr>
    <th scope="row" style="text-align: center"><?php echo htmlentities($cnt);?></th>
    <td style="text-align: center"><?php echo htmlentities($Subjec_name);?></td>
    <td style="text-align: center"><?php echo htmlentities($Subjec_code=($result3->SubjectCode));?></td>
    <td style="text-align: center">100</td>
    <?php
    
    if($Subjec_name != "English"  && $Subjec_code!=102 ) {
        if($exam_type=="Half Yearly" || $exam_type=="Final"|| $exam_type=="Pre Test"||$exam_type=="Test"){        
            ?>
            <td style="text-align: center"><?php echo htmlentities($Subjective=$result3->Subjective);?></td>
            <td style="text-align: center"><?php echo htmlentities($MCQ=$result3->MCQ);?></td>
            <?php
        }
       
        if($assessment_exam_name == "ET") {  
            if($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || ($Subjec_name=="Higher Mathematics" && ($optional_subject_name=="Higher Mathematics" || $compulsory_subject_name=="Higher Mathematics"))|| ($Subjec_name=="Biology" && ($Subjec_name==$optional_subject_name || $Subjec_name==$compulsory_subject_name)) || $Subjec_name=="Information and Communication Technology"|| ($Subjec_name=="Statistics" &&($optional_subject_name=="Statistics" || $compulsory_subject_name=="Statistics"))) {   
            ?>
               <td style="text-align: center"><?php echo htmlentities($et_Subjective=$result3->ET_Subjective) ;?></td>
               <td style="text-align: center"><?php echo htmlentities($et_mcq=$result3->ET_MCQ)  ;?></td>
               <?php
               $total = ((($Subjective + $MCQ)/75) *80) + $et_Subjective+$et_mcq;
               $total = round($total, 3);
            }
            if($Subjec_name=="Business Organization and Management" ||($Subjec_name=="Finance Banking and Insurance" && ($optional_subject_name=="Finance Banking and Insurance" || $compulsory_subject_name=="Finance Banking and Insurance")) || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)){   
                 ?>
               <td style="text-align: center"><?php echo htmlentities($et_Subjective=$result3->ET_Subjective) ;?></td>
               <td style="text-align: center"><?php echo htmlentities($et_mcq=$result3->ET_MCQ)  ;?></td>
               <?php
               $total = ((($Subjective + $MCQ)/100) *80) + $et_Subjective+$et_mcq;
               $total = round($total, 3);
            }
        }

        if($assessment_exam_name == "Practical"){
           if($Subjec_name=="Physics" || $Subjec_name=="Chemistry" || ($Subjec_name=="Higher Mathematics" && ($optional_subject_name=="Higher Mathematics" || $compulsory_subject_name=="Higher Mathematics"))|| ($Subjec_name=="Biology" && ($optional_subject_name=="Biology" || $compulsory_subject_name=="Biology")) || $Subjec_name=="Information and Communication Technology"|| ($Subjec_name=="Statistics" &&($optional_subject_name=="Statistics" || $compulsory_subject_name=="Statistics"))) {   
              ?>
               <td style="text-align: center"><?php echo htmlentities($practical=$result3->Practical) ;?></td>  
             
              <?php
               $total = $Subjective + $MCQ + $practical;
               $total = round($total, 3);
            }
         if($Subjec_name=="Business Organization and Management" || ($Subjec_name=="Finance Banking and Insurance" && ($optional_subject_name=="Finance Banking and Insurance" || $compulsory_subject_name=="Finance Banking and Insurance")) || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)){   
               ?>
               <td style="text-align: center"></td>  
               <?php
               $total = $Subjective + $MCQ;
               $total = round($total, 3);
            }
        
        }
        if( $assessment_exam_name == "Conversion"){
            if($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || ($Subjec_name=="Higher Mathematics" && ($Subjec_name==$optional_subject_name || $Subjec_name==$compulsory_subject_name))|| ($Subjec_name=="Biology" && ($Subjec_name==$optional_subject_name || $Subjec_name==$compulsory_subject_name)) || $Subjec_name=="Information and Communication Technology"|| ($Subjec_name=="Statistics" &&($Subjec_name==$optional_subject_name || $Subjec_name==$compulsory_subject_name))) {   
                $Converted_sub= $Subjective * 1.333;
                $Converted_mcq= $MCQ * 1.333;
                $total = $Converted_sub + $Converted_mcq;
                $total=round($total, 3);
                ?>
                <td style="text-align: center"><?php echo $Converted_sub ;?></td>
                <td style="text-align: center"><?php echo $Converted_mcq;?></td>
                <?php
                }
                if($Subjec_name=="Business Organization and Management" || ($Subjec_name=="Finance Banking and Insurance" && ($Subjec_name==$optional_subject_name || $Subjec_name==$compulsory_subject_name)) || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)){   
                   $total = $Subjective + $MCQ;
                   $total = round($total, 3);
                   ?>
                <td style="text-align: center"><?php echo $Subjective ;?></td>
                <td style="text-align: center"><?php echo $MCQ;?></td>
                <?php

            }          
           
        }
    }
    //for bangla 2nd and english
    if($Subjec_name == "English" || ($Subjec_name == "Bangla" && $Subjec_code== 102 )) {
        if( $exam_type=="Half Yearly" || $exam_type=="Final" || $exam_type=="Pre Test" ||$exam_type=="Test"){        
            ?>
            <td style="text-align: center"><?php echo htmlentities($Subjective=$result3->Subjective);?></td>
            <td style="text-align: center"></td>
            <?php
        }
        
        if($assessment_exam_name == "ET"){       
        ?>
           <td style="text-align: center"><?php echo htmlentities($et_Subjective=$result3->ET_Subjective) ;?></td>
           <td style="text-align: center"></td>
           <?php
           $total = ((($Subjective)/100) *80) + $et_Subjective;
           $total = round($total,3);
        }
         if( $assessment_exam_name == "Practical"){
           ?>
           <td style="text-align: center"></td>   
           
           <?php
           $total = $Subjective ;
           $total = round($total, 3);
        }
        
        if($assessment_exam_id=="5" && $assessment_exam_name == "Conversion"){
            $Converted_sub= $Subjective ;          
            $total = $Converted_sub  ;
            ?>
           <td style="text-align: center"><?php echo $Converted_sub ;?></td>  
            <td style="text-align: center"></td>        
           <?php
        }
    }
    ?>
    
    <?php
   
    if($assessment_exam_name == "ET" || $assessment_exam_name == "Conversion"){
        if($exam_type=="Test"){
             // For Science Group subject
             if(($Subjective < 17 || $MCQ <8) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Mathematics"|| $Subjec_name=="Biology" || $Subjec_name=="Information and Communication Technology"|| $Subjec_name=="Statistics") && ($Subjec_name != $optional_subject_name)) {
            $Grade_letter = 'F';
            $check_fail = 1;
            $Grade_point = 0;   
            }
             // For Business Group
            else if (($Subjective < 23 || $MCQ <10) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)) && ($Subjec_name != $optional_subject_name)){
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
            else if(($Subjective < 33)  && ($Subjec_name == "English" || ($Subjec_name == "Bangla" && $Subjec_code ==102 ))) {
                $Grade_letter = 'F';
                $check_fail=1;
                $Grade_point= 0;   
            }
        }
        if($exam_type=="Half Yearly" || $exam_type=="Final" || $exam_type=="Pre Test"){
            if(($Subjective < 20 || $MCQ <10) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Mathematics"|| $Subjec_name=="Biology" || $Subjec_name=="Information and Communication Technology"|| $Subjec_name=="Statistics") && ($Subjec_name != $optional_subject_name)) {
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
        
            // For Business Group
            else if (($Subjective < 28 || $MCQ <12) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)) && ($Subjec_name != $optional_subject_name)){
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
            else if(($Subjective < 40)  && ($Subjec_name == "English" || ($Subjec_name == "Bangla" && $Subjec_code ==102 ))) {
                $Grade_letter = 'F';
                $check_fail=1;
                $Grade_point= 0;   
            }
        }
    }
    if($assessment_exam_name == "Practical" ){
        if($exam_type=="Test"){
            // For Science Group subject
            if(($Subjective < 17 || $MCQ <8 || $practical<8) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Mathematics"|| $Subjec_name=="Biology" || $Subjec_name=="Information and Communication Technology"|| $Subjec_name=="Statistics") && ($Subjec_name != $optional_subject_name)) {
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
            // For Business Group
            else if (($Subjective < 23 || $MCQ <10) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)) && ($Subjec_name != $optional_subject_name)){
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
            else if(($Subjective < 33 )  && ($Subjec_name == "English" || ($Subjec_name == "Bangla" && $Subjec_code ==102 ))) {
                $Grade_letter = 'F';
                $check_fail=1;
                $Grade_point= 0; 
            }  
        }
        if($exam_type=="Half Yearly" || $exam_type=="Final" || $exam_type=="Pre Test"){
              // For Science Group subject
            if(($Subjective < 20 || $MCQ <10 || $practical<10) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Physics" ||$Subjec_name=="Chemistry" || $Subjec_name=="Higher Mathematics"|| $Subjec_name=="Biology" || $Subjec_name=="Information and Communication Technology"|| $Subjec_name=="Statistics") && ($Subjec_name != $optional_subject_name)) {
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
            // For Business Group
            else if (($Subjective < 28 || $MCQ <12) && ($Subjec_name!="English" || ($Subjec_name != "Bangla" && $Subjec_code!=102 )) && ($Subjec_name=="Business Organization and Management" ||$Subjec_name=="Finance Banking and Insurance" || $Subjec_name=="Accounting"|| ($Subjec_name=="Bangla" && $Subjec_code==101)) && ($Subjec_name != $optional_subject_name)){
                $Grade_letter = 'F';
                $check_fail = 1;
                $Grade_point = 0;   
            }
            else if(($Subjective < 40 )  && ($Subjec_name == "English" || ($Subjec_name == "Bangla" && $Subjec_code ==102 ))) {
                $Grade_letter = 'F';
                $check_fail=1;
                $Grade_point= 0; 
            } 
        }
    } 
    if ($total>=0 && $total<33 && $exam_type =="Test") {
            $Grade_letter = 'F';
            $check_fail = 1;
            $Grade_point = 0;
    }
    if ($total>=0 && $total<40 && ($exam_type=="Half Yearly" || $exam_type=="Final" || $exam_type=="Pre Test")) {
            $Grade_letter = 'F';
            $check_fail = 1;
            $Grade_point = 0;
    }
    if ($total>=33 && $total<40 && $exam_type =="Test") {
            $Grade_letter = 'D';
            $Grade_point = 1;
    }
    if ($total>=40 && $total<50) {
            $Grade_letter = 'C';
            $Grade_point= 2;
    }
    if ($total>=50 && $total<60) {
       $Grade_letter = 'B';
        $Grade_point= 3;
    }
    if ($total>=60 && $total<70) {
       $Grade_letter = 'A-';
        $Grade_point= 3.5;
    }
    if ($total>=70 && $total<80) {
       $Grade_letter = 'A';
        $Grade_point = 4;
    }
    if ($total>=80 && $total<=100) {
       $Grade_letter = 'A+';
        $Grade_point = 5;
    }
    if($Subjec_name == $optional_subject_name){
        $optional_grade=$Grade_point;
    }
    ?>
    <td style="text-align: center"><?php echo $total ;?></td>
    <td style="text-align: center"><?php echo $Grade_point ;?></td>
    <td style="text-align: center"><?php echo $Grade_letter ;?></td>                                                  </tr>
        <?php 
        $totlcount+=$total;
        if($Subjec_name == $optional_subject_name){
            continue;}
            
            $GPAcount+=$Grade_point;
            $cnt++;
            $cnt_sub++;}
        if($check_fail==1){
            $GPAcount=0;
        }
        ?>
<tr>
<th scope="row" colspan="2" style="text-align: center">Total Marks</th>
<td style="text-align: center"><b><?php echo htmlentities(round($totlcount)); ?></b></td>
                                                        
<th scope="row" colspan="2" style="text-align: center">GPA</th>
<?php
    if( $check_fail ==1 ){
        $totalGPa=0;
    ?>           
    <td style="text-align: center"><b><?php echo  htmlentities(round($totalGPa,2)); ?></b></td>
<?php
    }
    else if( $optional_grade > 3 ){
          $totalGPa=$GPAcount/($cnt-1) + (($optional_grade-3)/10);        
    ?>           
    <td style="text-align: center"><b><?php echo  htmlentities(round($totalGPa,2)); ?></b></td>
<?php
    }
    else{
        $final_GPA=$GPAcount/($cnt-1);
        ?>
        
        <td style="text-align: center"><b><?php echo  htmlentities(round($final_GPA,2)); ?></b></td>
<?php
    }
    ?>
</tr>

<!-- <tr>
                              
<td colspan="3" align="center"><i class="fa fa-print fa-2x" aria-hidden="true" style="cursor:pointer" OnClick="CallPrint(this.value)" ></i></td>
                                                             </tr> -->

 <?php } else { ?>     
<div class="alert alert-warning left-icon-alert" role="alert">
                                            <strong>Notice!</strong> Your result not declare yet
 <?php }
?>
                                        </div>
 <?php 
 }
else
 {?>

<div class="alert alert-danger left-icon-alert" role="alert">

<?php
echo htmlentities("Invalid Roll Id");
 }
?>
                                        </div>



                                                	</tbody>
                                                </table>
 <div >
       
    </div>
<div class="signature-container">
        <input type="text" id="signature1" name="signature1" class="signature">
        <label for="signature1" class="signature-label"> Principal</label>
    </div>
    <div class="signature-container">
        <input type="text" id="signature2" name="signature2" class="signature">
        <label for="signature2" class="signature-label">Coordinator</label>
    </div>
    <div class="signature-container">
        <input type="text" id="signature3" name="signature3" class="signature">
        <label for="signature3" class="signature-label">Class Teacher</label>
    </div>
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                    <div class="form-group">
                                                           
                                                            <div class="col-sm-6">
                                                               
                                                               <button class="back-button" onclick="backPage()">Back to Home</button>
                                                               <button class="print-button" onclick="printPage()">Print Page</button>

    <script>
        function printPage() {
            // Trigger printing
            window.print();
            // Hide the print button after printing
            var printButton = document.querySelector('.print-button');
            printButton.style.display = 'none';
        }
         function backPage() {
        // Specify the URL of the page you want to navigate to
        var specificPageUrl = 'index.php';
        // Navigate to the specific page
        window.location.href = specificPageUrl;
    }
    </script>
                                                            </div>
                                                        </div>

                                </div>
                                <!-- /.row -->
  
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                  
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {

            });


            function CallPrint(strid) {
var prtContent = document.getElementById("exampl");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
}
</script>

        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->

    </body>
</html>
