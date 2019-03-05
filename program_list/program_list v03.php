<?php
class Program
{
    public $program_info=array();
}

$filename = "cs1.txt";
$myfile = fopen( $filename, "r" ) or die("Unable to open file!");

$program_list = array();

$program=new Program();
while(!feof($myfile)) {
	$line1 = fgets($myfile);
	  if(strlen($line1) <3) {
	  	if($program->program_info['name'] == Null) continue;//跳过连续的空格
	  	$program_list[]=$program;	
	  	unset($program);
	  	continue;
	  }
	$line2 = fgets($myfile);

	if($program->program_info['name'] == Null){//mark the start of a master program
		$program->program_info['name'] = array($line1, $line2);
	}
	
	switch($line1){
		case stristr($line1,"ddl") == True:
			$program->program_info['ddl']=array($line1, $line2);
			break;
			
		case stristr(substr($line1,0,-1),"网申链接") == True:
			$program->program_info['网申链接']=array($line1, $line2);
			break;		
	}
}

fclose( $myfile );
?>

<!--
<pre>
<?php print_r($program_list); ?>
</pre>
-->

<html>
<head>
    <meta charset="utf-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>
<div>
    <h4 style="color:steelblue;text-align:center">CS项目信息</h4>
</div>

<div class=table-responsive">
<table class="table table-striped table-hover">
<tbody>
<?php
 foreach($program_list as $program){
 	echo '<tr>';
 	foreach($program->program_info as $item){
 		echo '<td>';
 		echo '<a href=', $item[1], ' target=blank>', $item[0], '</a>';
 		echo '</td>';
 	}
 	echo '</tr>';
	}
?>
</tbody>
</table>
</div>
</body>
</html>





