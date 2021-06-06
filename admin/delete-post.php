<?php
	$conn = mysqli_connect("localhost","root","","news-site");

	$post_id = $_GET['id'];
	$category = $_GET['cid'];

	$sql1 = "SELECT * FROM post WHERE post_id = {$post_id}";
	$result1 = mysqli_query($conn,$sql1);
	$row = mysqli_fetch_assoc($result1);
	unlink("upload/".$row['post_img']);

	
	$sql = "DELETE FROM post
			WHERE post_id = {$post_id};";
	$sql .= "UPDATE category
			 SET post = post - 1
			 WHERE category_id = {$category}";

	$result = mysqli_multi_query($conn,$sql);

	header("Location: http://localhost/news-site/admin/post.php");

	mysqli_close($conn);
?>