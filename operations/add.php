<?php
	include 'db.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$work_order_number = $_POST['work_order_number'];
		$title = $_POST['title'];
		$agency = $_POST['agency'];
		$pre_press_received = $_POST['pre_press_received'];
		$monitoring_received = $_POST['monitoring_received'];
		$quantity = $_POST['quantity'];
		$status = $_POST['status'];

		$stmt = mysqli_prepare($conn, "INSERT INTO main (work_order_number, agency, title, pre_press_received, monitoring_received, quantity, status_now) VALUES (?, ?, ?, ?, ?, ?, ?)");

		mysqli_stmt_bind_param($stmt, "sssssss", $work_order_number, $agency, $title, $pre_press_received, $monitoring_received, $quantity, $status);

		if (mysqli_stmt_execute($stmt)) {
			echo 'success';
		} else {
			echo mysqli_stmt_error($stmt);
		}
		
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
?>
