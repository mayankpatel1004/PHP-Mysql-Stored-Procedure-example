<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "premedics");
ini_set("display_errors", 0);

//$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
//$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
$dbh = new PDO('localhost', 'root', '', 'premedics');

$setSql = "SELECT `name` as 'Name',`device_id` as 'Device Name',`serial_number` as 'Serial Number',`tracking_number` as 'Tracking Number',`last_inspection_date` as 'Last Inspection Date',`inspected_by` as 'Inspected Person',`shipped_to` as 'Shipped To',`location_id` as 'Location ID' FROM installations_installation";
fnExportexcel($setSql);

function fnExportexcel($setSql) {
    ini_set("display_errors", "0");
    $setRec = mysql_query($setSql);
    $setCounter = 0;
    $setCounter = mysql_num_fields($setRec);

    for ($i = 0; $i < $setCounter; $i++) {
        $setMainHeader .= mysql_field_name($setRec, $i) . "\t";
    }

    while ($rec = mysql_fetch_row($setRec)) {
        $rowLine = '';
        foreach ($rec as $value) {
            if (!isset($value) || $value == "") {
                $value = "\t";
            } else {
                $value = strip_tags(str_replace('"', '""', $value));
                $value = '"' . $value . '"' . "\t";
            }
            $rowLine .= $value;
        }
        $setData .= trim($rowLine) . "\n";
    }
    $setData = str_replace("\r", "", $setData);

    if ($setData == "") {
        $setData = "\nno matching records found\n";
    }

    $setCounter = mysql_num_fields($setRec);



//This Header is used to make data download instead of display the data
    header("Content-type: application/octet-stream");
    $setExcelName = "Report_" . date('Ymdhis');
    header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");

    header("Pragma: no-cache");
    header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
    echo ucwords($setMainHeader) . "\n" . $setData . "\n";
}

?>