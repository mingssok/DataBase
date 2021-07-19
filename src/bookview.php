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
$bookId = $_GET['bookId'];
try {
$conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
echo("에러 내용: ".$e -> getMessage());
}

$stmt = $conn -> prepare("SELECT TITLE, PUBLISHER, author, YEAR FROM EBOOK, authors WHERE EBOOK.ISBN = ? and ebook.isbn = authors.isbn");
$stmt -> execute(array($bookId));
$bookName = '';
$publisher = '';
$author = '';
if ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
$bookName = $row['TITLE'];
$publisher = $row['PUBLISHER'];
$author = $row['AUTHOR'];
$year = $row['YEAR'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-
wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<style>
a { text-decoration: none; }
</style>
<title>Book VIEW</title>
</head>
<body>
<div class="container">
<h2 class="display-6">E-BOOK 정보</h2>
<table class="table table-bordered text-center">
<tbody>
<tr>
<td>제목</td>
<td><?= $bookName ?></td>
</tr>
<tr>
<td>출판사</td>
<td><?= $publisher ?></td>
</tr>
<tr>
<td>대표작가</td>
<td><?= $author ?></td>
</tr>
<tr>
<td>발행일자</td>
<td><?= $year ?></td>
</tr>
</tbody>
</table>
<?php
}
?>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">


  <a href="booklist.php" class="btn btn-success">목록</a>

<?php

$mode = '';
if (isset($_GET['mode'])) {
  $mode = $_GET['mode'];
}

session_start();
if(isset($_SESSION['admin_id'])) {
?>
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bstarget="#
deleteConfirmModal">수정</button>
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bstarget="#
deleteConfirmModal">삭제</button>
  <?php
} else if (isset($_SESSION['user_id'])) {
   if($mode > 0 && isset($mode)) {
  ?>
  <a href="reserving_ok.php?bookId=<?= $bookId ?>" class="btn btn-warning">예약하기</a>
  <?php
} else if($mode == 0 && isset($mode)) {
  ?>
  <a href="rent_ok.php?bookId=<?= $bookId ?>" class="btn btn-success">대출하기</a>
  <?php
} else if(!isset($mode)) {
  ?>
  <?php
} } else {
  ?>
  <a href="login.php" class="btn btn-success">로그인</a>
  <?php
}
?>

</div>
</div>
<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteConfirmModal" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="deleteConfirmModalLabel"><?= $bookName ?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
위의 책을 삭제하시겠습니까?
</div>
<div class="modal-footer">
<form action="process.php?mode=delete" method="post" class="row">
<input type="hidden" name="bookId" value="<?= $bookId ?>">
<button type="submit" class="btn btn-danger">삭제</button>
</form>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
</div>
</div>
</div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-
gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>
