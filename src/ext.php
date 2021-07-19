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
$extt = $_GET['mode'];
session_start();
$user = $_SESSION['user_id'];

if ($extt < 2) {
$stmt = $dbh->prepare("UPDATE ebook set exttimes = exttimes+1, datedue = datedue+10 where isbn = '$bookId'");
$stmt->execute();
header("Location: rental.php");
} else {
  echo "<script>alert('연장 횟수를 초과해서, 연장할 수 없습니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=rental.php'>";
}
?>
