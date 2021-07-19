<?php
$tns = "
(DESCRIPTION=
(ADDRESS_LIST= (ADDRESS=(PROTOCOL=TCP)(HOST=175.195.43.71)(PORT=1521)))
(CONNECT_DATA= (SERVICE_NAME=XE))
)
";
$dsn = "oci:dbname=".$tns.";charset=utf8";
$username = "d201701984";
$password = "ABCD";
try {
$conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
echo("에러 내용: ".$e -> getMessage());
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
crossorigin="anonymous">
<style>
a {
text-decoration: none;
}
</style>
<title>(관리자) 회원 별 대출 건수</title>
</head>
<body>
<div class="container">
<h1 class="text-center">(관리자) 회원 별 대출 건수</h1>
<table class="table table-bordered text-center">
<thead>
<tr>
<th>회원번호</th>
<th>회원명</th>
<th>대출건수</th>

</tr>
</thead>
<tbody>
<?php
session_start();

$myName = $_SESSION['user_id'];
if(isset($_SESSION['admin_id'])) {
  $stmt = $conn -> prepare("SELECT P.CNO, C.NAME, COUNT(P.CNO) 대출건수
FROM PREVIOUSRENTAL P, CUSTOMER C
WHERE P.CNO = C.CNO
GROUP BY P.CNO, C.NAME
ORDER BY COUNT(P.CNO) DESC, C.NAME ASC");
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><a href="customerview.php?cno=<?= $row['CNO'] ?>"><?= $row['CNO'] ?></a></td>
<td><?= $row['NAME'] ?></td>
<td><?= $row['대출건수'] ?></td>


</tr>
<?php
}
} else {
  echo "<script>alert('잘못된 접근입니다!');</script>";
}
?>
* 그룹함수를 이용해 회원 별 대출 건수를 출력하라<br>
<strong>* 과제 2장 5절 그룹함수</strong>
</tbody>
</table>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="home.php" class="btn btn-success">홈으로</a>
</div>
<form class="row">

</body></html>
