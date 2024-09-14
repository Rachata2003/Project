<?php
//db connecting
require('dbconnect.php'); //edit on the origin file only (more practical)

//receive values from insertform
$emp_title=$_POST["emp_title"];
$f_name=$_POST["f_name"];
$l_name=$_POST["l_name"];
$emp_bd=$_POST["emp_bd"];

//save data
$sql="INSERT INTO employee(emp_title,f_name,l_name,emp_bd) 
VALUE('$emp_title','$f_name','$l_name','$emp_bd')";

//run SQL command
$result=mysqli_query($con,$sql);

//error handling
if($result){ //กรณี result ทำงานถูกต้อง ให้ redirect ไปที่ location ก็คือวนกลับไปหน้าแรกเพื่อรับข้อมูลคนต่อๆ ไป
    header("location:index.php");
    exit(0);
}else{
    echo mysqli_error(con);
}