<?php 
include "db.php";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// get the record id from the form
		$record_id = $_POST['id'];
		// create the delete query
		$sql = "DELETE FROM main WHERE id = $record_id";
		// execute the query
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }   
		// close the database connection
		mysqli_close($conn);
	}
?>