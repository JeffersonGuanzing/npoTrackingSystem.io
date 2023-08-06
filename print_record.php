<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_autoconfig.php');
require_once('tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {
  
    // Load table data from file
    public function LoadData() {
        include 'operations/db.php';
           
        if (isset($_GET['status_filter'])) {
            $selected_value = $_GET['status_filter'];
            $fromDate = isset($_GET['from']) ? $_GET['from'] : null;
            $toDate = isset($_GET['to']) ? $_GET['to'] : null;
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
        
                
            try {  
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    throw new Exception(mysqli_error($conn));
                }
                $table_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $data = json_encode($table_data);
             
                if (!$data) {
                    throw new Exception("Error encoding data as JSON");
                }
                return $data;
            } catch (Exception $e) {
                // Handle the error in a way that's appropriate for your application
                // For example, you could log the error and return a specific error message
                return "Error: " . $e->getMessage();
            }
        } else {
            // Handle the case where the status_filter parameter is not set
            // For example, you could return an error message or an empty JSON array
            return "Error: status_filter parameter is not set";
        } 
    }
    
    public function displayTable($header,$data) {
        // Colors, line width and bold font
        $this->SetTextColor(255);
        $this->SetLineWidth(0.3);
        $fontSize = 8;
        $fill = (200);

        // Header
        $w = array(18, 20, 30, 12, 15, 15, 15, 18, 15, 15, 15, 15, 15, 15, 15, 30);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->MultiCell($w[$i], 12, $header[$i], 'LR', 'C', $fill, false);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('', '', $fontSize);
        // Data
        $data = json_decode($data, true);

        foreach($data as $row) {
            $this->Cell($w[0], 15, $row['work_order_number'], 'LR', 0, 'L', $fill);
            $this->MultiCell($w[1], 15, $row['agency'], 'LR', 'L', $fill, false);
            $this->MultiCell($w[2], 15, $row['title'], 'LR', 'L', $fill, false);
            $this->MultiCell($w[3], 15, $row['quantity'], 'LR', 'L', $fill, false);

            $monitoring_received = $row['monitoring_received'];
            if ($monitoring_received != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($monitoring_received)); // format date to mm/dd/yyyy
                $this->Cell($w[4], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[4], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }

            $pre_press_received = $row['pre_press_received'];
            if ($pre_press_received != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($pre_press_received)); // format date to mm/dd/yyyy
                $this->Cell($w[5], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[5], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }

            $pre_press_released = $row['pre_press_released'];
            if ($pre_press_released != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($pre_press_released)); // format date to mm/dd/yyyy
                $this->Cell($w[6], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[6], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }

            $todc = $row['target_date_of_completion'];
            if ($todc != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($todc)); // format date to mm/dd/yyyy
                $this->Cell($w[7], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[7], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }
        
            $press_received = $row['press_received'];
            if ($press_received != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($press_received)); // format date to mm/dd/yyyy
                $this->Cell($w[8], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[8], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }
        
            $press_released = $row['press_released'];
            if ($press_released != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($press_released)); // format date to mm/dd/yyyy
                $this->Cell($w[9], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[9], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }

            $this->Cell($w[10], 15, $row['press_dar_number'], 'LR', 0, 'L', $fill);

            $finishing_received = $row['finishing_received'];
            if ($finishing_received != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($finishing_received)); // format date to mm/dd/yyyy
                $this->Cell($w[11], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[11], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }            
            
            $finishing_released = $row['finishing_released'];
            if ($finishing_released != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($finishing_released)); // format date to mm/dd/yyyy
                $this->Cell($w[12], 15, $formatted_date, 'LR', 0, 'L', $fill);
            } else {
                $this->Cell($w[12], 15, '', 'LR', 0, 'L', $fill); // show empty cell if date is not set
            }        

            $this->Cell($w[13], 15, $row['finishing_dar_number'], 'LR', 0, 'L', $fill);

            $smd = $row['smd'];
            if ($finishing_released != '0000-00-00') { // check if date is set
                $formatted_date = date('m/d/Y', strtotime($smd)); // format date to mm/dd/yyyy
                $this->Cell($w[14], 15, $formatted_date, 'LR','LT', $fill, false);
            } else {
                $this->Cell($w[14], 15, '', 'LR', 0, 'LT', $fill, false); // show empty cell if date is not set
            }                 
            
            $this->MultiCell($w[15], 15, $row['status_remarks'], 'LR', 'LT', $fill, false);

            $this->Ln();
            $fill=!$fill;

            // check if content exceeds page height
            if ($this->GetY() > 250) { // adjust height value as needed
                // decrease font size and reset position
                $fontSize -= 1;
                $this->SetFont('Arial', '', $fontSize);
                $this->SetXY(10, 10); // adjust X and Y position as needed
            }
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 14);

        // Set the logo image
        $image_file = 'npo_logo.jpg';
        $this->Image($image_file, $this->getPageWidth()/2 - 80, 10, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add text "PRODUCTION PLANNING & CONTROL DIVISION MONITORING SECTION"
        $this->SetFont('helvetica', 'B', 10);
        $this->MultiCell(125, 0, 'PRODUCTION PLANNING & CONTROL DIVISION' . "\n" . 'MONITORING SECTION', 0, 'C', false, 0, '', '', true, 0, false, true, 0);

        // Add a line break
        $this->Ln(10);

        // Set the first column text
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 0, 'WORK ORDER ENVELOPE TRACKER', 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // Add a line break
        $this->Ln(8);

        // Add text "As of Date today" and center it
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 0,  date('F j, Y'), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // Add text "NPO-PPCD-MON-WOT-001-21" and align to the right
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 0, 'NPO-PPCD-MON-WOT-001-21', 0, false, 'R', 0, '', 0, false, 'T', 'M');

        // Add line break after header
        $this->Ln(10);
        $this->Line(10, $this->getY(), $this->getPageWidth()-10, $this->getY()); 
        }
    }

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPageOrientation('L');

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jefferson Guanzing');
$pdf->SetTitle('NPO Work Order Status Report');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 40, 10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// add a page
$pdf->AddPage();

// set font
$pdf->SetFont('times', '', 8); // Adjusted font size

// add a line break
$pdf->Ln();

// column titles
$header = array(
    'Work Order Envelope Number',
    'Agency',
    'Job Description',
    'Quantity',
    'Monitoring Received',
    'Pre-Press Received',
    'Pre-Press Released',
    'Target Date'."\n".'of Completion',
    'Press Received',
    'Press Released',
    'DAR #',
    'Finishing Received',
    'Finishing Released',
    'DAR #',
    'SMD',
    'Remarks'
  );
  
// data loading
$data = $pdf->LoadData('');

// // print colored table
$pdf->displayTable($header, $data);

// close and output PDF document
$pdf->Output('report.pdf', 'I');


?>