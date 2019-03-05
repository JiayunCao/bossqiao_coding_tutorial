<?php
class Program
{
	public $program_info=array();
}

//用于存放CS项目信息
//$program_list_cs = array();
//$program_list_ds = array();

function generate_program_list($filename){
	$myfile = fopen( $filename, "r" ) or die("Unable to open file!");

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
		$program->program_info['02-ddl']=array(substr($line1,0,-1), substr($line2,0,-1));
		break;
		
		case stristr(substr($line1,0,-1),"网申链接") == True:
		$program->program_info['03-网申链接']=array(substr($line1,0,-1), substr($line2,0,-1));
		break;		
		
		case stristr(substr($line1,0,-1),"TOEFL") == True:
		$program->program_info['04-TOEFL']=array(substr($line1,0,-1), substr($line2,0,-1));
		break;	
		
		case stristr(substr($line1,0,-1),"录取数据") == True:
		if($program->program_info['05-录取数据'] == Null)
			$program->program_info['05-录取数据']=array(substr($line1,0,-1), substr($line2,0,-1));
		break;
	}
}
fclose( $myfile );
return $program_list;
}

//定义显示html的函数，$title是表格的标题，如：“CS项目信息”，“MIS项目信息”
function show_program_list($program_list, $title){
	echo '<br/><h4 style="color:steelblue;text-align:center">'.$title.'</h4>
	<div class=table-responsive">
	<table class="table table-striped table-hover">
	<tbody>';
	
	
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
			if(stristr($item[0],"录取数据") == True)
			//if(1==0)
				echo '<a href="#" onclick="window.open(\''.$item[1].'\' , \'录取数据\', \'width=600,height=600\' )">'.$item[0].'</a>';
			else
				echo '<a href=', $item[1], ' target=_blank>', $item[0], '</a>';
			echo '</td>';
		}
		echo '</tr>';
	}
	
	echo '</tbody>
	</table>
	</div>';
}

?>

<!--
<pre>
<?php print_r($program_list_cs); ?>
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

	<div class=table-responsive">
		<table class="table table-striped table-hover">
			<tbody><tr><td>
				<p style="color:saddlebrown">需要<a href="#" onclick="window.open('bossqiao.html','蟹老板介绍','width=500,height=456')">蟹老板</a>留学服务的,（￣︶￣）↗请加小助理微信：895718791（注明：留学申请服务）
				语音咨询：600元/小时（半小时起约）签约保录top 50全程服务（5万元/10所学校）</p>
			</td></tr></tbody>
		</table>
	</div>

	<?php
	$program_list_cs = generate_program_list("cs1.txt");
	$program_list_ds = generate_program_list("ds1.txt");
	$program_list_ba = generate_program_list("ba1.txt");
	$program_list_mis = generate_program_list("mis1.txt");
	show_program_list($program_list_cs, 'CS项目信息');
	show_program_list($program_list_ds, 'DS项目信息');
	show_program_list($program_list_ba, 'BA项目信息');
	show_program_list($program_list_mis, 'MIS项目信息');
	?>

</body>
</html>

