<?php
	include 'includes/session.php';

	if(isset($_POST['login'])){
		$student = $_POST['student'];
		$sql = "SELECT * FROM students WHERE student_id = '$student'";
		$query = $conn->query($sql);
		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
			$_SESSION['student'] = $row['id'];
			header('location: transaction.php');
		}
		else{
			$_SESSION['error'] = 'Không tìm thấy sinh viên';
			header('location: index.php');
		}

	}
	else{
		$_SESSION['error'] = 'Nhập Mã SV trước';
		header('location: index.php');
	}


?>