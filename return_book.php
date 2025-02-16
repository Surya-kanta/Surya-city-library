<?php
	$connection = mysqli_connect("localhost","root","tiger","lms");
	$query = "delete from issued_books where book_no = $_GET[bn]";
	$query_run = mysqli_query($connection,$query);
?>
<script type="text/javascript">
	alert("Book Returned successfully...");
	window.location.href = "admin_view_issued_book.php";
</script>