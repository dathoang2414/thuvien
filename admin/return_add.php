<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$student = $_POST['student'];
		
		$sql = "SELECT * FROM students WHERE student_id = '$student'";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			if(!isset($_SESSION['error'])){
				$_SESSION['error'] = array();
			}
			$_SESSION['error'][] = 'Không tìm thấy sinh viên';
		}
		else{
			$row = $query->fetch_assoc();
			$student_id = $row['id'];

			$return = 0;
			foreach($_POST['isbn'] as $isbn){
				if(!empty($isbn)){
					$sql = "SELECT * FROM books WHERE isbn = '$isbn'";
					$query = $conn->query($sql);
					if($query->num_rows > 0){
						$brow = $query->fetch_assoc();
						$bid = $brow['id'];

						$sql = "SELECT * FROM borrow WHERE student_id = '$student_id' AND book_id = '$bid' AND status = 0";
						$query = $conn->query($sql);
						if($query->num_rows > 0){
							$borrow = $query->fetch_assoc();
							$borrow_id = $borrow['id'];
							$sql = "INSERT INTO returns (student_id, book_id, date_return) VALUES ('$student_id', '$bid', NOW())";
							if($conn->query($sql)){
								$return++;
								$sql = "UPDATE books SET status = 0 WHERE id = '$bid'";
								$conn->query($sql);
								$sql = "UPDATE borrow SET status = 1 WHERE id = '$borrow_id'";
								$conn->query($sql);
							}
							else{
								if(!isset($_SESSION['error'])){
									$_SESSION['error'] = array();
								}
								$_SESSION['error'][] = $conn->error;
							}
						}
						else{
							if(!isset($_SESSION['error'])){
								$_SESSION['error'] = array();
							}
							$_SESSION['error'][] = 'Chi tiết mượn không tìm thấy: Mã sách - '.$isbn.', Mã SV: '.$student;
						}

						

					}
					else{
						if(!isset($_SESSION['error'])){
							$_SESSION['error'] = array();
						}
						$_SESSION['error'][] = 'Không tìm thấy: Mã sách - '.$isbn;
					}
		
				}
			}

			if($return > 0){
				$book = ($return == 1) ? 'Sách' : 'Nhiều sách';
				$_SESSION['success'] = $return.' '.$book.' Trả lại thành công';
			}

		}
	}	
	else{
		$_SESSION['error'] = 'Điền vào biểu mẫu thêm trước';
	}

	header('location: return.php');

?>