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
	  	$program_list[]=$program;	
	  	unset($program);
	  	continue;
	  }
	$line2 = fgets($myfile);

	if($program->program_info['name'] == Null){//mark the start of a master program
		$program->program_info['name'] = $line1;
		$program->program_info['link'] = $line2;
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

<pre>
<?php print_r($program_list); ?>
</pre>

<?php 
	/*
	//echo "text array: "; var_dump($school_array[0]->text); echo "<br>";
    foreach($school_array as $school){
    	//echo var_dump($school->text), "<br>";
    	for($i=0; $i<count($school->text); $i++)
    		if(stristr(substr($school->text[$i],0,-1),"录取数据统计"))
    	    	{echo "<a href=\"", $school->link[$i], "\" target=\"frame2\">", $school->text[$i], "</a><br>";}
    	    else	
    	    	{echo "<a href=\"", $school->link[$i], "\" target=\"_blank\">", $school->text[$i], "</a><br>";}
    	echo "<br>";
    	}
    	//}
            //echo "<a href=\"$item->line2 \" target=\"frame2\">$item->line1</a><br><br>";} */
?> 




