<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$code = $_POST['code'];
		$title = $_POST['title'];
		
		$sql = "INSERT INTO course (code, title) VALUES ('$code', '$title')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Đã thêm khóa học thành công';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Điền vào biểu mẫu thêm trước';
	}

	header('location: course.php');

?>