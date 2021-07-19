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
echo $bookId;
session_start();
$user = $_SESSION['user_id'];
$stmt = $dbh->prepare("INSERT INTO RESERVE VALUES('$bookId', '$user', sysdate)");
$stmt->execute();
header("Location: reserving2.php?bookId=$bookId");
?>
