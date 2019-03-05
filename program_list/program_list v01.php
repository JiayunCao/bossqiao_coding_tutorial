<?php
class Program
{
    public $program_info=array();
}

$filename = "cs1.txt";
$myfile = fopen( $filename, "r" ) or die("Unable to open file!");

while(!feof($myfile)) {
	$line1 = fgets($myfile);
	switch($line1){
		case stristr($line1,"ddl") == True:
			echo $line1.'<br>';
			$line2 = fgets($myfile);
			echo $line2.'<br>';
			break;
			
		case stristr(substr($line1,0,-1),"网申链接") == True:
			echo $line1.'<br>';
			$line2 = fgets($myfile);
			echo $line2.'<br>';
			break;		
	}
}

fclose( $myfile );

?>



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




