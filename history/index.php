<?php
error_reporting(0);
//参数判断
$param['type'] = $_GET['type'] == 'json' || $_GET['type'] == 'text' || $_GET['type'] == 'xml' ? $_GET['type'] : "text";
$param['date'] = strtotime(date('Y-m-d', strtotime("2016{$_GET['date']}"))) === strtotime("2016{$_GET['date']}") ? $_GET['date'] : date('md');

$month = date("m", strtotime("2016{$param['date']}"));
$day = date("d", strtotime("2016{$param['date']}"));

$data = json_decode(file_get_contents("./data/{$month}.json"), true);
$data = $data["{$day}"];

$count = count($data);

$param['count'] = $_GET['count'] <= $count && $_GET['count'] > 0 && intval($_GET['count']) == $_GET['count'] ? $_GET['count'] : $count;

$output = array();
for ($i = 0; $i < $param['count']; $i++) {
	$output[$i] = $data[$i];
}
//判断类型进行输出
switch ($param['type']) {
	case "json":
		header("Content-type:text/json");
		echo json_encode($output);
		break;
	case "xml":
		require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/array2xml/function.php");
		header("Content-type:text/xml");
		echo arr2xml($output);
		break;
	case "text":
	header("Content-type:text/text");
	    foreach($output as $tmp){
			echo "{$tmp['year']}年 {$tmp['event']}";
			echo PHP_EOL;
		}
		break;
	default:
	header("Content-type:text/text");
	    foreach($output as $tmp){
			echo "{$tmp['year']}年 {$tmp['event']}";
			echo PHP_EOL;
		}
		break;
}
?>
