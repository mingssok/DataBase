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
<title>(관리자) 인기 도서 순위</title>
</head>
<body>
<div class="container">
<h1 class="text-center">(관리자) 인기 도서 순위</h1>
<table class="table table-bordered text-center">
<thead>
<tr>
<th>ISBN</th>
<th>대출건수</th>
<th>대출순위</th>
</tr>
</thead>
<tbody>
<?php
session_start();

$myName = $_SESSION['user_id'];
if(isset($_SESSION['admin_id'])) {
  $stmt = $conn -> prepare("SELECT ISBN, count(*) || '건' 대출건수, dense_rank() over (order by count(*) desc) || '위' 대출순위
FROM PREVIOUSRENTAL
GROUP BY ISBN
ORDER BY 대출순위, ISBN");
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><a href="bookview.php?bookId=<?= $row['ISBN'] ?>"><?= $row['ISBN'] ?></a></td>
<td><?= $row['대출건수'] ?></td>
<td><?= $row['대출순위'] ?></td>

</tr>
<?php
}
} else {
  echo "<script>alert('잘못된 접근입니다!');</script>";
}
?>
<br>
 * 윈도우함수를 이용해, 대출된 적 있는 도서의 대출 건수와 대출 순위를 구하시오.<br>
 <strong>* 과제 2장 6절 윈도우 함수</strong>
</tbody>
</table>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="home.php" class="btn btn-success">홈으로</a>
</div>
<form class="row">

</body></html>
