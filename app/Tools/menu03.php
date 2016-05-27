<?php
require "menu.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$data=array(
	array(
		"id" => "1",
		"name"=>"Menu 1",
		"parent" => "0"
	),
	array(
		"id" => "2",
		"name"=>"Menu 2",
		"parent" => "0"
	),
	array(
		"id" => "3",
		"name"=>"Menu 3",
		"parent" => "0"
	),
	array(
		"id" => "4",
		"name"=>"Menu 1.1",
		"parent" => "1"
	),			
	array(
		"id" => "5",
		"name"=>"Menu 1.2",
		"parent" => "1"
	),
	array(
		"id" => "6",
		"name"=>"Menu 2.1",
		"parent" => "2"
	),
	array(
		"id" => "7",
		"name"=>"Menu 2.2",
		"parent" => "2"
	),		
	array(
		"id" => "8",
		"name"=>"Menu 1.2.1",
		"parent" => "5"
	),	
);

$config=array(
	"open" => "<ul class='test'>",
	"close" => "</ul>",
	"openitem" => "<li>",
	"closeitem" => "</li>",
	"baseurl" => "http://www.qhonline.edu.vn/viewcate",
);

$menu=new Menu($config);
$menu->setMenu($data);
echo $menu->callMenu();
?>
</body>
</html>
