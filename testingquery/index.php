<?php
require_once("connection.php");
$sqlSearchtext = "";
$sqlSearchdate = "";
$sqlCategory = "";
$search = "test";
//$year = 2016;
//$month = 11;
//$category_id = 0;
$year = 2014;
$month = 06;
$category_id = 1;

//echo $sqlQuery = "SELECT it.`item_id`,it.`title`,it.`alias`,it.`description`,it.`short_description`,it.`status`,it.`category_id`,DATE_FORMAT(`created_date`,'%Y,%D %M') as date FROM `item` as it  WHERE 1=1 AND 
//CASE WHEN FIND_IN_SET('2',it.`category_id`) > 0 THEN FIND_IN_SET('2',it.`category_id`) END AND
//CASE WHEN `$search` IS NOT NULL THEN (CONCAT_WS(it.`title`,it.`alias`,it.`description`,it.`short_description`) LIKE'%1%') END AND (YEAR(it.`created_date`) = '$year' AND MONTH(it.`created_date`) = '$month');";

if ($search != "") {
    $sqlSearchtext = " AND (CONCAT_WS(it.`title`,it.`alias`,it.`description`,it.`short_description`) LIKE'%$search%') ";
}
if($category_id > 0){
    $sqlCategory = "AND FIND_IN_SET('$category_id',it.`category_id`)";
}
if ($year != "" && $month != "") {
    $sqlSearchdate = " AND (YEAR(it.`created_date`) = '$year' AND MONTH(it.`created_date`) = '$month')";
}

echo $sqlQuery = "SELECT it.`item_id`,it.`title`,it.`alias`,it.`description`,it.`short_description`,it.`status`,it.`category_id`,DATE_FORMAT(`created_date`,'%D %M %Y') as date FROM `item` as it  WHERE 1=1 $sqlSearchtext $sqlCategory $sqlSearchdate";


$stmt = $db->prepare($sqlQuery);
$stmt->execute();
$result = $stmt->fetchAll();
$rows = $stmt->rowCount();
echo "<pre>";
print_r($result);