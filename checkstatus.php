<?php
	
	$action = isset($_GET['action'])?preg_replace('#([^a-z]+)#iu', '', $_GET['action']): '';
	
	if($action=='') {
		include_once('checkstatus.html');
	} else if($action=='ajax') {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		header('Content-type: application/json');
		$result = array();
		if(isset($_GET['url'], $_GET['i'])) {
			$url = &$_GET['url'];
			include_once('curl.php');
			$data = curl($url);
			
		
			$result['status'] = &$data['http_code'];
			if(isset($data['redirect_url']) && $data['redirect_url']!='') {
				$result['redirect'] = $data['redirect_url'];
			} else {
				$result['redirect'] = '';
			}			
			$result['i'] = intval($_GET['i']);
			
		}
		die(json_encode($result));		
	} else{
		echo '<h1>404 Not Found</h1>';
		header("HTTP/1.0 404 Not Found");
	}
