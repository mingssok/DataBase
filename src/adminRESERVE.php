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
<title>(관리자) 예약 조회/취소</title>
</head>
<body>
<div class="container">
<h1 class="text-center">(관리자) 예약 조회/취소</h1>
<table class="table table-bordered text-center">
<thead>
<tr>
<th>회원명</th>
<th>ISBN</th>
<th>도서명</th>
<th>출판사</th>
<th>예약일</th>
<th>예약취소</th>
</tr>
</thead>
<tbody>
<?php
session_start();
$myName = $_SESSION['user_id'];
$admin = '';

$stmt = $conn -> prepare("select isbn, datetime, title, NAME, publisher from (
SELECT reserve.ISBN, reserve.datetime, EBOOK.TITLE, NAME, AUTHORS.AUTHOR, PUBLISHER
FROM reserve, CUSTOMER, EBOOK, AUTHORS
WHERE reserve.CNO = CUSTOMER.CNO
AND CUSTOMER.CNO = :myName
AND reserve.isbn = EBOOK.isbn
AND reserve.isbn = AUTHORS.ISBN
ORDER BY authors.author)
group by isbn, datetime, title, publisher, NAME
order by datetime, isbn");
$stmt->bindParam(':myName', $myName);

if(isset($_SESSION['admin_id'])) {
  $stmt = $conn -> prepare("
SELECT isbn, datetime, title, NAME, cno, email, publisher from (
SELECT reserve.ISBN, reserve.datetime, EBOOK.TITLE, NAME, customer.cno, email, AUTHORS.AUTHOR, PUBLISHER
FROM reserve, CUSTOMER, EBOOK, AUTHORS
WHERE reserve.CNO = CUSTOMER.CNO
AND reserve.isbn = EBOOK.isbn
AND reserve.isbn = AUTHORS.ISBN
ORDER BY authors.author)
group by isbn, datetime, title, publisher, NAME, cno, email
order by datetime, isbn");
}

$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  if(isset($_SESSION['admin_id'])) {
    $admin = $row['CNO'];
    $email = $row['EMAIL'];
  }
?>
<tr>
<td><?= $row['NAME'] ?></td>
<td><?= $row['ISBN'] ?></td>
<td><a href="bookview.php?bookId=<?= $row['ISBN'] ?>"><?= $row['TITLE'] ?></a></td>
<td><?= $row['PUBLISHER'] ?></td>
<td><?= $row['DATETIME'] ?></td>
<td><a href="adminRESERVE_cancel.php?bookId=<?=$row['ISBN'] ?>&cno=<?=$admin ?>&email=<?=$email ?>" class="btn btn-warning">예약취소</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="home.php" class="btn btn-success">홈으로</a>
<a href="booklist.php" class="btn btn-primary">예약하기</a>
</div>
<form class="row">

</body></html>
