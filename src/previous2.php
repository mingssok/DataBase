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
<title>(관리자) 이전 대출기록 통계</title>
</head>
<body>
<div class="container">
<h1 class="text-center">(관리자) 이전 대출기록 통계</h1>
<table class="table table-bordered text-center">
<thead>
<tr>
<th>회원명</th>
<th>ISBN</th>
<th>대출도서명</th>
<th>대출일자</th>
<th>반납일자</th>
<th>대출기간</th>
</tr>
</thead>
<tbody>
<?php
session_start();

$myName = $_SESSION['user_id'];
if(isset($_SESSION['admin_id'])) {
  $stmt = $conn -> prepare("SELECT CUSTOMER.NAME, PREVIOUSRENTAL.ISBN, EBOOK.TITLE, PREVIOUSRENTAL.DATERENTED, PREVIOUSRENTAL.DATERETURNED, round(PREVIOUSRENTAL.DATERETURNED - PREVIOUSRENTAL.DATERENTED,0) || '일' 대출기간
FROM PREVIOUSRENTAL, EBOOK, CUSTOMER
WHERE PREVIOUSRENTAL.ISBN = EBOOK.ISBN AND PREVIOUSRENTAL.CNO = CUSTOMER.CNO");
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><a href="customerview.php?cno=<?= $row['NAME'] ?>"><?= $row['NAME'] ?></a></td>
<td><?= $row['ISBN'] ?></td>
<td><a href="bookview.php?bookId=<?= $row['ISBN'] ?>"><?= $row['TITLE'] ?></a></td>
<td><?= $row['DATERENTED'] ?></td>
<td><?= $row['DATERETURNED'] ?></td>
<td><?= $row['대출기간'] ?></td>

</tr>
<?php
}
} else {
  echo "<script>alert('잘못된 접근입니다!');</script>";
}
?>
<br>
 * PREVIOUSRENTAL 테이블을 기반으로 도서를 대출한 회원명, 도서명, 대출일자, 반납일자, 대출기간을 출력하라<br>
 <strong>* 과제 1장 9절 조인 및 2장 1절 표준조인</strong>
</tbody>
</table>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="home.php" class="btn btn-success">홈으로</a>
</div>
<form class="row">

</body></html>
