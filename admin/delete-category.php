<?php
	$conn = mysqli_connect("localhost","root","","news-site");

	$c_id = $GET['id'];

	$sql = "DELETE FROM category
			WHERE category_id = '{$c_id}'";
	$result = mysqli_query($conn,$sql);

	header("Location: http://localhost/news-site/admin/category.php");

	mysqli_close($conn);
?>