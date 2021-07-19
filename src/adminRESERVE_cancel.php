<?php
$tns = "
(DESCRIPTION=
(ADDRESS_LIST= (ADDRESS=(PROTOCOL=TCP)(HOST=175.195.43.71)(PORT=1521)))
(CONNECT_DATA= (SERVICE_NAME=XE))
)
";
$dsn = "oci:dbname=".$tns.";charset=utf8";
$username = 'd201701984';
$password = 'ABCD';
$dbh = new PDO($dsn, $username, $password);
$bookId = $_GET['bookId'];
$cno = $_GET['cno'];
$email = $_GET['email'];

session_start();

$user = $_SESSION['user_id'];
$stmt = $dbh->prepare("DELETE FROM RESERVE WHERE ISBN = '$bookId' AND CNO = '$cno'");
$stmt->execute();
header("Location: adminRESERVE_cancel2.php?bookId=$bookId&cno=$cno&email=$email");
?>
