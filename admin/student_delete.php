<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM students WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Sinh viên đã xóa thành công';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Chọn mụ cần xóa trước';
	}

	header('location: student.php');
	
?>