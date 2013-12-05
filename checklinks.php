<?php


	$action = isset($_GET['action'])?preg_replace('#([^a-z]+)#iu', '', $_GET['action']): '';
	
	if($action=='') {
		include_once('checklinks.html');
	} else if($action=='ajax') {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		header('Content-type: application/json');
		$result = array();
		if(isset($_GET['url'], $_GET['i'], $_GET['keyword'], $_GET['link'])) {
			$url = &$_GET['url'];
			$link = &$_GET['link'];
			$keyword = &$_GET['keyword'];
			include_once('curl.php');
			$data = curl($url, true);
			$data = str_replace(array("\n", "\t"), array('','',''), $data);
			
			
			if(isset($_GET['ext'])) {
				$whatever = $_GET['ext']?true:false;
			} else {
				$whatever = false;
			}
			preg_match_all('#<a.*?href="([^"]+)"[^>]*>(.*?)</a>#iu', $data, $preg);
			
			$result['status'] = 0;
			$result['follow'] = '';
			$result['url'] = $url;
			$result['i'] = intval($_GET['i']);
			$result['whatever'] = $whatever;
			$result['keyword'] = $keyword;	
			$result['link'] = $link;		
			foreach($preg[0] as $key=>$value) {			
				if($preg[1][$key]==$link) {				
					if($whatever || preg_match('#'.str_replace('#', '\#', $keyword).'#iu', strip_tags($preg[2][$key]))) {						
						$result['status'] = 1;						
						preg_match('#rel="([^"]*)"#iu', $value, $matches); 
						
						if(isset($matches[1])) {
							if($matches[1]=='follow') {
								$result['follow'] = 1;
							} elseif($matches[1]=='nofollow') {
								$result['follow'] = 0;
							}
						}
						$result['whatever'] = $whatever;
						$result['name'] = $preg[2][$key];						
						break;
						
					}				
				}				
			}
			
		
			//echo $data;
			
		}
		die(json_encode($result));		
	} else{
		echo '<h1>404 Not Found</h1>';
		header("HTTP/1.0 404 Not Found");
	}
