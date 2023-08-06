<?php 
	include "db.php";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
		$agency = mysqli_real_escape_string($conn, $_POST['agency']);
		$monitoring_received = mysqli_real_escape_string($conn, $_POST['monitoring_received']);
		$work_order_writer_section = mysqli_real_escape_string($conn, $_POST['work_order_writer_section']);
		$pre_press_received = mysqli_real_escape_string($conn, $_POST['pre_press_received']);
		$pre_press_released = mysqli_real_escape_string($conn, $_POST['pre_press_released']);
		$photo_released = mysqli_real_escape_string($conn, $_POST['photo_released']);
		$target_date_of_completion = mysqli_real_escape_string($conn, $_POST['target_date_of_completion']);
		$press_received = mysqli_real_escape_string($conn, $_POST['press_received']);
		$press_released = mysqli_real_escape_string($conn, $_POST['press_released']);
		$press_dar = mysqli_real_escape_string($conn, $_POST['dar_number-press']);
		$finishing_received = mysqli_real_escape_string($conn, $_POST['finishing_received']);
		$finishing_released = mysqli_real_escape_string($conn, $_POST['finishing_released']);
		$finishing_dar = mysqli_real_escape_string($conn, $_POST['dar_number-finishing']);
		$smd = mysqli_real_escape_string($conn, $_POST['smd']);
		$status_remarks = mysqli_real_escape_string($conn, $_POST['status_remarks']);
		$status = mysqli_real_escape_string($conn, $_POST['status']);
		$work_order_number = mysqli_real_escape_string($conn, $_POST['work_order_number']);; // Set new value for work_order_number
		
		$sql = "UPDATE main SET 
		work_order_number = '$work_order_number',
		agency = '$agency', 
		title = '$title', 
		quantity = '$quantity', 
		monitoring_received = '$monitoring_received', 
		work_order_writer_section = '$work_order_writer_section', 
		pre_press_received = '$pre_press_received', 
		pre_press_released = '$pre_press_released', 
		press_press_released = '$photo_released',
		target_date_of_completion = '$target_date_of_completion', 
		press_received = '$press_received', 
		press_released = '$press_released', 
		press_dar_number = '$press_dar',
		finishing_received = '$finishing_received', 
		finishing_released = '$finishing_released', 
		finishing_dar_number = '$finishing_dar',
		smd = '$smd', 
		status_remarks = '$status_remarks',
		status_now = '$status'
		WHERE work_order_number = '$work_order_number'";

		if (mysqli_query($conn, $sql)) {
			echo 'success';
		} else {
			echo 'fail';
		}
		
	}
?>