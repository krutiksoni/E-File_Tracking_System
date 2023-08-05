<?php
$userid=$_POST['userid'];
$pwd=$_POST['password'];
if ($userid==-1) {
	header('location: ../index.php');
}
session_start();
include('config.php');
$con= mysqli_connect($servername,$username,$password,$dbname);
if (!$con) {
	die("Connection failed: " . mysqli_connect_error());
}
$q="select privilege from user where user_id='$userid' && password='$pwd' limit 1";
$result=mysqli_query($con,$q);
$num=mysqli_num_rows($result);
if ($num==1) {
	$row=mysqli_fetch_array($result);
	session_start();
	$_SESSION["logged_in"]="true";
	$_SESSION["user_id"]=$userid;
	if($row['privilege']==1)
	{
		$_SESSION["privilege"]=1;
		header('location: ../admin.php');
	}
	else if($row['privilege']==0)
	{
		$_SESSION["privilege"]=0;
		header('location: ../inbox.php');
	}
}
else
{
	$_SESSION["error"] = "Invalid username or password";
	header('location: ../index.php');
}
mysqli_close($con);
?>
