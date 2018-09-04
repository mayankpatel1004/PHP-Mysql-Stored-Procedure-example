<?php 
mysql_connect("localhost","root","");
mysql_select_db("pagination");

function pagination($per_page = 10, $page = 1, $url = '', $total)
{   
	$adjacents = "2";
	
	$page = ($page == 0 ? 1 : $page); 
	$start = ($page - 1) * $per_page;                              
	 
	$prev = $page - 1;                         
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;
	 
	$pagination = "";
	if($lastpage > 1)
	{  
		$pagination .= "<ul class='pagination'>";
				$pagination .= "<li class='details'>Page $page of $lastpage</li>";
		if ($lastpage < 7 + ($adjacents * 2))
		{  
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><a class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))    
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href='{$url}1'>1</a></li>";
				$pagination.= "<li><a href='{$url}2'>2</a></li>";
				$pagination.= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
				}
				$pagination.= "<li class='dot'>..</li>";
				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
			}
			else
			{
				$pagination.= "<li><a href='{$url}1'>1</a></li>";
				$pagination.= "<li><a href='{$url}2'>2</a></li>";
				$pagination.= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
				}
			}
		}
		 
		if ($page < $counter - 1){
			$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
			$pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
		}else{
			$pagination.= "<li><a class='current'>Next</a></li>";
			$pagination.= "<li><a class='current'>Last</a></li>";
		}
		$pagination.= "</ul>\n";     
	}          
	return $pagination;
} 	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Paging</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php	
$page=1;//Default page
$limit=4;//Records per page
$start=0;//starts displaying records from 0
if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
}
	$start=($page-1)*$limit;
?>


<?php
//Get total records (you can also use MySQL COUNT function to count records)
$sql = "select id from article";
$query=mysql_query($sql);
$rows=mysql_num_rows($query);

$query=mysql_query("select * from article order by id ASC LIMIT $start, $limit");
if(mysql_num_rows($query)>0){
while($data=mysql_fetch_array($query,1)){
?>
<div class="article">
<div class="title"><?php echo $data['title'];?></div>
<?php echo $data['description'];?>
</div>
<?php }} ?>
<?php
echo pagination($limit,$page,'index.php?page=',$rows);	//call function to show pagination
?>
</body>
</html>


