 <b>Server Time:</b> <?php  $vowels = array('(', ')', '"' );
$serveamostrar = str_replace($vowels, "", $Server_time);   echo $serveamostrar;   

date_default_timezone_set('America/New_York'); // CDT

$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

$current_date = "$date/$month/$year == $hour:$min:$sec";
echo "--->".	$current_date;
?>####