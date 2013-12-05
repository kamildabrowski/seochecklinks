<?php 

function curl($url, $data=false) {
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_FILETIME, true);
	
    curl_setopt($curl, CURLOPT_NOBODY, ($data?false:true));	
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, ($data?true:false));
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); 
	curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	
    $get = curl_exec($curl);
    $header = 	curl_getinfo($curl);	    
    curl_close($curl);
	
	if($data==true) {
		return $get;
	} else {
		return $header;
	}
}
