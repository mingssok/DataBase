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
$stmt = $dbh->prepare("SELECT count(*) as A FROM EBOOK WHERE EBOOK.CNO = '$user'");
$stmt->execute();

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
$temp = (int) $row['A'];

if($temp == 3) {
  echo "<script>alert('대출 가능한 도서는 최대 3권입니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=rental.php'>";
}
else {
  header("Location: renting.php?bookId=$bookId");
}
}
?>
