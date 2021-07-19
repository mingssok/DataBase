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
session_start();
$user = $_SESSION['user_id'];
$stmt = $dbh->prepare("SELECT * FROM EBOOK WHERE ISBN = '$bookId'");
$stmt->execute();

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
$temp = (int) $row['RESERVED'];
$extt = $row['EXTTIMES'];

if($temp != 0) {
  echo "<script>alert('타 회원이 예약 중인 도서이므로, 연장이 불가능합니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=rental.php'>";
}
else {
  header("Location: ext.php?bookId=$bookId&mode=$extt");
}
}
?>
