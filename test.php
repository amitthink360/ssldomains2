<?php
$res = "/ewqeoj314/dkj4223/324323";
$parms = explode("/",$res);
echo"<pre/>";print_r($parms);
$parms = array_filter($parms, fn($value) => !is_null($value) && $value !== '');

if(isset($parms[1])){
	$array = array();
}

$array = array(
	
);


echo implode("&",$parms);
die;

//$queryString =  http_build_query($_GET);
	
?>