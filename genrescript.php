<?php
    require_once 'libconfig.php';

	$genre = array("Fantasy", "SciFi", "Romance", "Thriller", "Mystery", "Detective", "Biography");
	$query = "select isbn from books";
	$result = pg_query($query);
$i = 0;
//echo '<html><body><table><tr>';
while ($i < pg_num_fields($result))
{
	$fieldName = pg_field_name($result, $i);
	//echo '<td>' . $fieldName . '</td>';
	$i = $i + 1;
}
//echo '</tr>';
$i = 0;

while ($row = pg_fetch_row($result)) 
{
		$num = mt_rand(0,6);
		//echo $num;
		$query = "update books set genre = '$genre[$num]' where isbn='$row[0]'";
		//echo $query;
		pg_query($query);

	//echo '<tr>';
	$count = count($row);
	$y = 0;
	while ($y < $count)
	{
		$c_row = current($row);
	//	echo '<td>' . $c_row . '</td>';
		next($row);
		$y = $y + 1;
	}
	//echo '</tr>';
	$i = $i + 1;
}
//pg_free_result($result);

//echo '</table></body></html>';
?>