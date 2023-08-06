<?php // Your database connection code goes here
	include 'db.php';

	// Get page number from query string
	$page_number = isset($_GET['page']) ? $_GET['page'] : 1;

	// Get from_date and to_date from query string (if present)
	
	$descOrder = isset($_GET['order_by']) ? $_GET['order_by'] : null;
	// Set number of records per page
	$records_per_page = 5;

	// Calculate offset
	$offset = ($page_number - 1) * $records_per_page;

	if (isset($_GET['status_filter'])) {
		$selected_value = $_GET['status_filter'];
		$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : null;
		$toDate = isset($_GET['to_date']) ? $_GET['to_date'] : null;
		$sql = "SELECT * FROM `main`";
	
		if ($selected_value == "Completed") {
			if ($fromDate && $toDate) {
				$sql .= " WHERE `smd` BETWEEN '$fromDate' AND '$toDate'";
			} else {
				$sql .= " WHERE `status_now` = '$selected_value'";
			}
		} else if ($selected_value == "On-Process") {
			if ($fromDate && $toDate) {
				$sql .= " WHERE `monitoring_received` BETWEEN '$fromDate' AND '$toDate' AND `status_now` = 'On-Process'";
			} else {
				$sql .= " WHERE `status_now` = 'On-Process'";
			}
		} else if ($selected_value == "At Work Order Writer Section") {
			if ($fromDate && $toDate) {
				$sql .= " WHERE `work_order_writer_section` BETWEEN '$fromDate' AND '$toDate' AND `status_now` = 'At Work Order Writer Section'";
			} else {
				$sql .= " WHERE `status_now` = 'At Work Order Writer Section'";
			}
		} else if ($selected_value == "All") {
			if ($fromDate && $toDate) {
				$sql .= " WHERE `monitoring_received` BETWEEN '$fromDate' AND '$toDate'";
			}
		}
	
		$sql .= " ORDER BY `id` DESC";
	}
	
	
	$sql .= " LIMIT $offset, $records_per_page";
	$result = mysqli_query($conn, $sql);

	// Fetch table data as an associative array
	$table_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Query to get total number of records
	$sql_count = "SELECT COUNT(*) FROM main";
	if (isset($_GET['status_filter'])) {
		$selected_value = $_GET['status_filter'];
		$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : null;
		$toDate = isset($_GET['to_date']) ? $_GET['to_date'] : null;
	
		if ($selected_value == "Completed") {
			if ($fromDate && $toDate) {
				$sql_count .= " WHERE `smd` BETWEEN '$fromDate' AND '$toDate'";
			} else {
				$sql_count .= " WHERE `status_now` = '$selected_value'";
			}
		} else if ($selected_value == "On-Process") {
			if ($fromDate && $toDate) {
				$sql_count .= " WHERE `monitoring_received` BETWEEN '$fromDate' AND '$toDate' AND `status_now` = 'On-Process'";
			} else {
				$sql_count .= " WHERE `status_now` = 'On-Process'";
			}
		} else if ($selected_value == "At Work Order Writer Section") {
			if ($fromDate && $toDate) {
				$sql_count .= " WHERE `work_order_writer_section` BETWEEN '$fromDate' AND '$toDate' AND `status_now` = 'At Work Order Writer Section'";
			} else {
				$sql_count .= " WHERE `status_now` = 'At Work Order Writer Section'";
			}
		} else if ($selected_value == "All") {
			if ($fromDate && $toDate) {
				$sql_count .= " WHERE `monitoring_received` BETWEEN '$fromDate' AND '$toDate'";
			}
		}
	}

	$result_count = mysqli_query($conn, $sql_count);
	$total_records = mysqli_fetch_array($result_count)[0];

	// Calculate total number of pages
	$total_pages = ceil($total_records / $records_per_page);

	// Return table data and pagination information in JSON format
	echo json_encode(array(
		'table_data' => $table_data,
		'total_pages' => $total_pages
	));
?>