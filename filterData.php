<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="print.css" type="text/css" media="print">
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">
        <title>Print Record</title>
    </head>
    <body>
        <div class="container-fluid mt-2">
        <div class="header text-center">
                <img src="images/npo_logo.png" alt="National Printing Office Logo" id="footer_logo" class="mb-2">
                <h5>National Printing Office</h5>
                <h5>Edsa Corner NPO Rd, Diliman, Quezon City 1100 Philippines</h5>
            </div>
                        <div class="row">
                            <div class="col text-center align-items-center">	
                                <?php 
                                    include 'operations/db.php';
                                    if(isset($_GET['status_filter'])) {
                                        $selected_value = $_GET['status_filter'];
                                    }
                                ?>                   
                                <h1 class="display-5 text-center"><?php echo $selected_value; ?> Work Order </h1>
                            </div>
                        </div>
                        <table class="table table-hover mt-2 table-bordered">
                            <thead>
                                <tr>
                                    <th>Work Order Number</th>
                                    <th>Agency</th>
                                    <th>Job Description</th>
                                    <th>Quantity</th>
                                    <th>Pre-Press Received</th>
                                    <th>Pre-Press Released</th>
                                    <th>Target Date of Completion</th>
                                    <th>Press Received</th>
                                    <th>Press Released</th>
                                    <th>Finishing Received</th>
                                    <th>Finishing Released</th>
                                    <th>DAR #</th>
                                    <th>SMD</th>
                                    <th>DAR #</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                        <tbody>
                <?php 
                include 'operations/db.php';
                $from = $_GET['from'];
                $to = $_GET['to'];

                if(isset($_GET['status_filter'])) {
                    $selected_value = $_GET['status_filter'];
                    if ($selected_value == "All") {
                        $sql = "SELECT * FROM `main` WHERE
                        (`pre_press_received` BETWEEN '$from' AND '$to' AND `monitoring_received` IS NULL)
                        OR
                        (`monitoring_received` BETWEEN '$from' AND '$to' AND `pre_press_received` IS NULL)
                    ORDER BY `id` DESC";
                    } 
                    if ($selected_value == "On-Process" || $selected_value == "At Work Order Writer Section") {
                        $sql = "SELECT * FROM `main` 
                        WHERE
                            (`pre_press_received` BETWEEN '$from' AND '$to' AND `monitoring_received` IS NULL)
                            OR
                            (`monitoring_received` BETWEEN '$from' AND '$to' AND `pre_press_received` IS NULL)
                            AND `status_now` = '$selected_value'
                        ORDER BY `id` DESC;
                        ";
                    } 
                    if ($selected_value == "Completed") {
                        $sql = "SELECT * FROM `main` WHERE `smd` BETWEEN '$from' and '$to' ORDER BY id DESC";
                    } 
                } 
                
                    
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    if(mysqli_num_rows($result) > 0 ) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Process each row
                            echo "<tr style='white-space: nowrap'>";
                            echo "<td>".$row['work_order_number']."</td>";
                            echo "<td>".$row['agency']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['quantity']."</td>";
                            echo "<td>".(($row['pre_press_received'] == null || $row['pre_press_received'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['pre_press_received'])))."</td>";
                            echo "<td>".(($row['pre_press_released'] == null || $row['pre_press_released'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['pre_press_released'])))."</td>";
                            echo "<td>".(($row['target_date_of_completion'] == null || $row['target_date_of_completion'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['target_date_of_completion'])))."</td>";
                            echo "<td>".(($row['press_received'] == null || $row['press_received'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['press_received'])))."</td>";
                            echo "<td>".(($row['press_released'] == null || $row['press_released'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['press_released'])))."</td>";
                            echo "<td>".$row['press_dar_number']."</td>";
                            echo "<td>".(($row['finishing_received'] == null || $row['finishing_received'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['finishing_received'])))."</td>";
                            echo "<td>".(($row['finishing_released'] == null || $row['finishing_released'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['finishing_released'])))."</td>";
                            echo "<td>".$row['finishing_dar_number']."</td>";
                            echo "<td>".(($row['smd'] == null || $row['smd'] == "0000-00-00") ? "" : date('M d, Y', strtotime($row['smd'])))."</td>";
                            echo "<td style='white-space: pre-wrap;'>".$row['status_remarks']."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No records found.</td></tr>";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                ?>
                        </table>
                        <div class="container-fluid">
                            <div class="row mt-2 button-row">
                                <div class="button-container">
                                <button class="btn btn-light print-button" onclick="printWindowContents()"><i class="bi bi-printer"></i> Print</button>
                                </div>
                                <a href="dashboard.php" class="btn btn-light print-button"><i class="bi bi-box-arrow-left"></i></a>
                            </div>
                        </div>
            </div>
            
            <style>
                .container-fluid {
                    text-align: center;
                }
            #footer_logo {
                    height: 50px;
                }
                table {
                    font-size: 12px;
                    text-align: center;

                }
                .footer h5 {
                    font-size: 12px;
                }

@media print {
/* center the table */
table {
text-align: center;
margin: 0 auto;
}

/* set landscape orientation and add footer styling */
@page {
size: landscape;
}

.header p {
margin: 0;
}
.header img {
height: 25px;
margin-right: 5px;
vertical-align: middle;
}
.print-button {
display: none;
}

/* set zoom to fit page */
body {
zoom: 80%; / adjust as needed */
}      
}
            </style>
            <script>
                function printWindowContents() {
                    var originalContents = document.body.innerHTML;
                    window.print();
                    document.body.innerHTML = originalContents;
                }
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>