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
<title>대출 조회/연장</title>
</head>
<body>
<div class="container">
<h1 class="text-center">대출 조회/연장</h1>
<table class="table table-bordered text-center">
<thead>
<tr>
<th>회원명</th>
<th>ISBN</th>
<th>도서명</th>
<th>출판사</th>
<th>대출일</th>
<th>반납기한</th>
<th>연장횟수</th>
<th>연장하기</th>
<th>반납하기</th>

</tr>
</thead>
<tbody>
<?php
session_start();
$myName = $_SESSION['user_id'];

$stmt = $conn -> prepare("select *
from ebook, customer
where ebook.cno = customer.cno
and CUSTOMER.CNO = :myName
order by ebook.daterented");
$stmt->bindParam(':myName', $myName);
if(isset($_SESSION['admin_id'])) {
  $stmt = $conn -> prepare("select *
from ebook, customer
where ebook.cno = customer.cno
order by ebook.daterented");
}
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $title = $row['TITLE'];
  $extt = $row['EXTTIMES'];
  $dr = $row['DATERENTED'];
?>
<tr>
<td><?= $row['NAME'] ?></td>
<td><?= $row['ISBN'] ?></td>
<td><a href="bookview.php?bookId=<?= $row['ISBN']?>&mode=0"><?= $row['TITLE'] ?></a></td>
<td><?= $row['PUBLISHER'] ?></td>
<td><?= $row['DATERENTED'] ?></td>
<td><?= $row['DATEDUE'] ?></td>
<td><?= $row['EXTTIMES'] ?></td>
<td><a href="ext_ok.php?bookId=<?=$row['ISBN']?>&mode=<?= $extt ?>" class="btn btn-primary">연장하기</a></td>
<td><a href="return.php?bookId=<?=$row['ISBN'] ?>&dr=<?= $dr?>" class="btn btn-primary">반납하기</a></td>

</tr>
<?php
}
?>
</tbody>
</table>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="home.php" class="btn btn-success">홈으로</a>
<a href="booklist.php" class="btn btn-primary">대출하기</a>
</div>
<form class="row">

</body></html>
