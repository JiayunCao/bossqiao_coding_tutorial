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
	  	if($program->program_info['01-name'] == Null) continue;//跳过连续的空格
	  	$program_list[]=$program;	
	  	unset($program);
	  	continue;
	  }
	$line2 = fgets($myfile);

	if($program->program_info['01-name'] == Null){//mark the start of a master program
		$program->program_info['01-name'] = array($line1, $line2);
	}
	
	switch($line1){
		case stristr($line1,"ddl") == True:
			$program->program_info['02-ddl']=array($line1, $line2);
			break;
			
		case stristr(substr($line1,0,-1),"网申链接") == True:
			$program->program_info['03-网申链接']=array($line1, $line2);
			break;		
			
		case stristr(substr($line1,0,-1),"TOEFL") == True:
			$program->program_info['04-TOEFL']=array($line1, $line2);
			break;	
			
		case stristr(substr($line1,0,-1),"录取数据") == True:
			if($program->program_info['05-录取数据'] == Null)
				$program->program_info['05-录取数据']=array($line1, $line2);
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
 	//处理缺失的信息列
 	if($program->program_info['04-TOEFL']==Null) {
 		$program->program_info['04-TOEFL'] = array('N/A', '#');
 	}
 	if($program->program_info['05-录取数据']==Null) {
 		$program->program_info['05-录取数据'] = array('N/A', '#');
 	}
 	//对associate数组进行排序，方便统一显示
 	ksort($program->program_info);
 	
 	//开始逐行显示表格
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

