<?php
session_start();
error_reporting(0);
include('config.php');
if(strlen($_SESSION['login'])==0)
	{	
header('location:index.php');
}
else{
$StudentID=$_GET['StudentID'];
#$ISBNNumber=$_GET['ISBNNumber'];
$BookID=$_GET['BookID'];
#$AuthorName=$_GET['AuthorName'];
#$CategoryName=$_GET['CategoryName'];
#$BookPrice=$_GET['BookPrice'];
$sql = "SELECT * from tblrequestedbookdetails where StudentID=:StudentID and BookID=:BookID";
$query = $dbh -> prepare($sql);
$query->bindParam(':StudentID',$StudentID,PDO::PARAM_INT);
$query->bindParam(':BookID',$BookID,PDO::PARAM_INT);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
$_SESSION['msg']="You have already requested this book";
header('location:request-a-book.php');
}
else{
  $sql = "SELECT * from tblrequestedbookdetails where StudentID=:StudentID";
  $query = $dbh -> prepare($sql);
  $query->bindParam(':StudentID',$StudentID,PDO::PARAM_INT);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query->rowCount() == 2)
  {
	$_SESSION['msg']="You cannot request more than 2 books at a time";
	header('location:request-a-book.php');
  }
  else 
  {
	$sql="INSERT INTO tblrequestedbookdetails(StudentID,BookID) VALUES(:StudentID,:BookID)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':StudentID',$StudentID,PDO::PARAM_INT);
	$query->bindParam(':BookID',$BookID,PDO::PARAM_INT);
	$query->execute();
	$lastInsertId = $dbh->lastInsertId();
	$_SESSION['msg']="Book requested successfully";
	header('location:request-a-book.php');
  }
}
}?>