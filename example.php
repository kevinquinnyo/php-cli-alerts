<?php
	// Most of this was borrowed from CakePHP
	// http://cakephp.org/
	
	require_once('Terminal.php');
	$Term = new Terminal();
	
	// Set up a few styles
	$Term->stdout->styles('title', array(
		'bold' => true,
		'text' => 'cyan'
	));
	$Term->stdout->styles('path', array('bold' => true));
	$Term->stdout->styles('path_alert', array(
		'text' => 'white',
		'blink' => true,
		'background' => 'red'
	));
	
	$Term->out();
	$Term->hr();
	$Term->out('<title>Welcome to a stylized terminal</title>');
	$Term->hr();
	$Term->out('<path>Path:</path> <path_alert>/path/to/something/goes/here</path_alert>');
	$Term->out('<path>Path:</path> /path/to/something/goes/here');
	$Term->out('<path>Path:</path> /path/to/something/goes/here');
	$Term->out('<path>Path:</path> /path/to/something/goes/here');
	$Term->hr();
	
?>