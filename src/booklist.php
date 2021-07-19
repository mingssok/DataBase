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

$searchWord = $_GET['searchWord'] ?? '';
$searchAuthor = $_GET['searchAuthor'] ?? '';
$searchPublisher = $_GET['searchPublisher'] ?? '';

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
<title>E-BOOK 자료검색</title>
</head>
<body>
<div class="container">
<h1 class="text-center">E-BOOK 자료검색</h1>
<table class="table table-bordered text-center">
<thead>
<tr>
<th>ISBN</th>
<th>제목</th>
<th>출판사</th>
<th>대출/예약</th>
</tr>
</thead>
<tbody>
<?php
$stmt = $conn -> prepare("select ISBN, TITLE, PUBLISHER, CNO from (
SELECT AUTHORS.ISBN, TITLE, PUBLISHER, AUTHOR, CNO FROM EBOOK, AUTHORS
WHERE EBOOK.ISBN = AUTHORS.ISBN
AND ( LOWER(TITLE) LIKE '%' || :searchWord || '%'
AND LOWER(AUTHOR) LIKE '%' || :searchAuthor || '%'
AND LOWER(Publisher) LIKE '%' || :searchPublisher || '%' )
ORDER BY ISBN )
group by ISBN, TITLE, PUBLISHER, CNO
order by isbn");
$stmt -> execute(array($searchWord, $searchAuthor, $searchPublisher));
session_start();

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
$cno = $row['CNO'];
$temp = $row['CNO'];

if(!isset($_SESSION['user_id'])) {
  $temp = '<a href="login.php" class="btn btn-primary">로그인</a>';
} else if(!isset($temp)) {
 $temp = '<a class="btn btn-success">대출가능</a>';
} else {
 $temp = '<a class="btn btn-warning">예약가능</a>';
}

if (!isset($cno)) {
  $cno = 0;
}
?>

<tr>
<td><?= $row['ISBN'] ?></td>
<td><a href="bookview.php?bookId=<?= $row['ISBN'] ?>&mode=<?= $cno ?>"><?= $row['TITLE'] ?></a></td>
<td><?= $row['PUBLISHER'] ?></td>
<td><?= $temp ?></td>
</tr>
<?php
}
?>
</tbody>
</table>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="home.php" class="btn btn-success">홈으로</a>

<a href="input.php?mode=insert" class="btn btn-primary">등록</a>
</div>
<form class="row">
<div class="col-10">
<label for="searchWord" class="visually-hidden">Search Word</label>
<input type="text" class="form-control" id="searchWord" name="searchWord" placeholder="제목을 입력하세요" value="<?= $searchWord ?>">
</div>
<div class="col-auto text-end">
</div>

<div class="col-10">
<label for="searchAuthor" class="visually-hidden">Search Author</label>
<input type="text" class="form-control" id="searchAuthor" name="searchAuthor" placeholder="저자를 입력하세요" value="<?= $searchWord ?>">
</div>
<div class="col-auto text-end">
</div>

<div class="col-10">
<label for="searchPublisher" class="visually-hidden">Search Publisher</label>
<input type="text" class="form-control" id="searchPublisher" name="searchPublisher" placeholder="출판사를 입력하세요" value="<?= $searchWord ?>">
</div>
<div class="col-auto text-end">
<button type="submit" class="btn btn-primary mb-3">검색</button>
</div>

</form>
</div>
</body></html>
