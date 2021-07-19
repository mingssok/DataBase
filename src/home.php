<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>온라인 도서관</title>
    <body bgcolor="#F0FFFF"></body>
    </head>
<body>

	<header>
		<center>
	  <h1>온라인 도서관에 오신 것을 환영합니다!</h1>
	</center>
	</header>

  <div class="header">
    <h1 class="logo">
      <a href="./home.php" class="TopMainLogo">
        <center>
      <img src="./main.jpg" width="700" height="400" alt="온라인 도서관">
        </a>
        </center>
    </h1>

<div id="divWrapper">
	<nav>
		<ul>
			<li class="on"><a href="notice.php">이용안내</a></li>
			<li class="on"><a href="booklist.php">E-BOOK 자료검색</a></li>
<?php
session_start();
/* 주석 테스트 */

if(isset($_SESSION['user_id'])) {
?>
			<li><a href="rental.php">대출 조회/연장</a></li>
			<li><a href="reserve.php">예약 조회/취소</a></li>
			<li><a href="previous.php">이전 대출기록</a></li>
			<li><a href="myInfo.php">내 정보</a></li>
			<?php
			if(isset($_SESSION['admin_id'])) {
			?>
						<li class="on"><a href="adminRESERVE.php">예약취소 메일 보내기</a></li>
						<li><a href="valuable.php">유용한 통계</a></li>
			<?php
			}
			?>
			<li><?php echo $_SESSION['user_name']."님, "?><a href="logout.php">로그아웃</a></li>
<?php
} else {
?>
			<li><a href="login.php">로그인</a></li>
<?php
}
?>
		</ul>
	</nav>
			</div>
			<div class="footerInfo">
				<address>(201701984) 김민석 데이터베이스 텀프로젝트 과제</address>
        <address>E-MAIL : ming_ssok@g.cnu.ac.kr<p> </p></address>
			</div>
					</ul>
</div>
</body>
</html>
