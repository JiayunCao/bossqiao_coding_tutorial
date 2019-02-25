<?php
//载入GO Menu
$menu_file_name = "go_menu2.txt";
$menu_file = fopen( $menu_file_name, "r" ) or die("Unable to open file!");
$go_menu=array();

while(!feof($menu_file)) {
    $line1 = fgets($menu_file); //echo $job.strlen($job).'<br/>';
    if(strlen($line1) <2) continue; //跳过空行,空行的长度为1,设置3是为了保险,不小心多了一个空格之类的
    $line1 = substr($line1, 0, -1); //去掉最后的换行符
	$line2 = fgets($menu_file); //$line1：关键词（快捷键）
    $line3 = fgets($menu_file); //$line3：描述
    
    $go_menu[$line1] = array($line2, $line3); //信息保存到go_menu二维数组中
}
fclose( $menu_file);
?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GO Menu</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="js/jquery.min.js" type="text/javascript"></script>
</head>

<body>
<div>
    <h4 style="color:steelblue;text-align:center">GO Menu</h4>
</div>

<!--<pre>
<?php echo print_r($go_menu);?>
</pre>-->
<!--<pre>
<?php echo json_encode($go_menu);?>
</pre>-->

<div class="container">
<p style="color:saddlebrown">用“/”分隔开的关键词，输入任意一个都可以</p>
<table class="table table-striped table-hover">
    <tbody>
    <?php
    foreach($go_menu as $key => $value){
        echo "
             <tr>
             <td><a href=$value[0] target=blank>$key</a></td>
             <td>$value[1]</td>
             </tr>";}
    ?>
    </tbody>
</table>
</div>
</body>

</html>