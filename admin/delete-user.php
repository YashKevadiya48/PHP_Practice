<?php
	$user_id = $_GET['id'];
	
	if($_SESSION['user_role'] == '0'){
    header("Location: http://localhost/news-site/admin/post.php");
  	}
  	
	$conn = mysqli_connect("localhost","root","","news-site");

	$sql = "DELETE FROM user
			WHERE user_id = '{$user_id}'";

	$result = mysqli_query($conn,$sql);

	header("Location: http://localhost/news-site/admin/users.php");

	mysqli_close($conn);	
?>