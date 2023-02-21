<?php

function debug_print($info="ok now!",$counter=0,$html=false)
{
	static $c=0;
	$info_=debug_backtrace ();
	if(!isset($info_[1]))
		$func = "(unknow)"
	else
		$func = $info_[1]['function'];
	echo "<br>FILE : ".basename($info_[0]['file']).", FUNCTION : ".$func.", LINE :".$info_[0]['line']."\n <br><hr>";
	if(is_array($info) || is_object($info))
		$info=print_r($info,true);
	else if(is_bool($info))
		$info = $info?"True":"False";
	else if(empty($info))
		$info = "[EMPTY]";
	//echo "<div><b>System Debug information</b><div><br>";
	if($html)
		$info = nl2br(htmlentities($info))."<br>";
	echo "<pre>";	
	debug_print_backtrace ();
	echo "</pre>";
	echo $info;
	
	//print_r($info[0]['file']);
	//echo "<hr>";
	if($counter and $c==0)
	{
		$c=$counter;
	}
	$c--;
	if($c<=0)
	{
		exit;
	}
	
}
/*
if(!function_exists(debug_print_backtrace))
{
function debug_print_backtrace()
{
	$info=debug_backtrace ();
	//print_r($info[1]);
	echo "FILE : ".basename($info[1]['file']).", FUNCTION : ".$info[2]['function'].", LINE :".$info[1]['line']."\n";
}
}
*/

function debug_log($info="ok now!")
{
	if(is_array($info))
		$info=print_r($info,true);
	else if(is_bool($info))
		$info = $info?"True":"False";
	else if(empty($info))
		$info = "[EMPTY]";

	error_log(debug_string_backtrace());
	error_log($info);
}

function debug_string_backtrace() 
{
	ob_start();
	debug_print_backtrace();
	$trace = ob_get_contents(); 
	ob_end_clean();

	// Remove first item from backtrace as it's this function which
	// is redundant.
	//$trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1);

	// Renumber backtrace items.
	//$trace = preg_replace ('/^#(\d+)/me', '\'#\' . ($1 - 1)', $trace);

	return $trace;
} 


?>