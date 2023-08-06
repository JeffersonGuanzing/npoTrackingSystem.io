<?php 
    include 'operations/db.php';
    if(isset($_GET['id'])) {
        $id = $_GET['id']; 
        $sql = "SELECT * FROM main WHERE work_order_number = '$id'";
        if($result = mysqli_query($conn, $sql)) {
            $record = mysqli_fetch_assoc($result);
            $data = array(
                'id' => $record['id'],
                'work_order_number' => $record['work_order_number'],
                'monitoring_received' => $record['monitoring_received'],
                'work_order_writer_section' => $record['work_order_writer_section'],
                'agency' => $record['agency'],
                'title' => $record['title'],
                'quantity' => $record['quantity'],
                'pre_press_received' => $record['pre_press_received'],
                'pre_press_released' => $record['pre_press_released'],
                'press_press_released' => $record['press_press_released'],
                'target_date_of_completion' => $record['target_date_of_completion'],
                'press_received' => $record['press_received'],
                'press_released' => $record['press_released'],
                'finishing_received' => $record['finishing_received'],
                'finishing_released' => $record['finishing_released'],
                'smd' => $record['smd'],
                'status_remarks' => $record['status_remarks']
            );
            echo json_encode($data);
        }
    } else {
        echo "no record";
    }
?> 