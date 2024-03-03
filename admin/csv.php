<?php
include '../top.php';
include_once '../includes/database.php';


$taskData = $database->getallData('user_task');


foreach ($taskData as $key => $value) {

    array_shift($value);
    array_pop($value);
    $where = "id = $value[0]";
    $taskData = $database->getDatawhere('users', $where);
    $value[0] = $taskData[0][1];
    $arrData[] = $value;
}
// Start the output buffer.
ob_start();

// Set PHP headers for CSV output.
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=csv_export.csv');

// Create the headers.
$header_args = array('User Name', 'Start Time', 'Stop Time', 'Note', 'Description');

// Prepare the content to write it to CSV file.


$data = $arrData;

// Clean up output buffer before writing anything to CSV file.
ob_end_clean();

// Create a file pointer with PHP.
$output = fopen('php://output', 'w');

// Write headers to CSV file.
fputcsv($output, $header_args);

// Loop through the prepared data to output it to CSV file.
foreach ($data as $data_item) {
    fputcsv($output, $data_item);
}

// Close the file pointer with PHP with the updated output.
fclose($output);
exit;


header("Location: http://localhost/user-management/admin/userTasks.php");
exit;
