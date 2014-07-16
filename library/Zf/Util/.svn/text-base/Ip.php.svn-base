<?php

class Zf_Util_Ip {
	
	/**
	 * @return string The IP address
	 */
	public static function sz_fGetIp() {
		
		//check ip from share internet
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			
			$sz_IpAddr = $_SERVER['HTTP_CLIENT_IP'];
		
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
			
			$sz_IpAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
		
		} else {

			$sz_IpAddr = $_SERVER['REMOTE_ADDR'];
		
		}
		
		return $sz_IpAddr;
	}
	
	public static function a_fGetGeoIP()
	{
		$sz_IpAddr = Zf_Util_Ip::sz_fGetIp();
		
		//check, if the provided ip is valid
		if(!filter_var($sz_IpAddr, FILTER_VALIDATE_IP))
		{
			throw new InvalidArgumentException("IP is not valid");
		}
	
		//contact ip-server
		$sz_Response = @file_get_contents('http://www.netip.de/search?query=' . $sz_IpAddr);
		
		if (empty($sz_Response))
		{
			throw new InvalidArgumentException("Error contacting Geo-IP-Server");
		}
		
		//Array containing all regex-patterns necessary to extract ip-geoinfo from page
		$a_Patterns = array();
		$a_Patterns["country"] = '#Country: (.*?)&nbsp;#i';
		$a_Patterns["state"] = '#State/Region: (.*?)<br#i';
		$a_Patterns["city"] = '#City: (.*?)<br#i';
	
		//Array where results will be stored
		$a_IpInfo = array();
	
		//check response from ipserver for above patterns
		foreach ($a_Patterns as $sz_Key => $sz_Pattern)
		{
			//store the result in array
			$a_IpInfo[$sz_Key] = preg_match($sz_Pattern, $sz_Response, $a_Value) && !empty($a_Value[1]) ? $a_Value[1] : 'Unknown';
		}
		
		return $a_IpInfo;
	}
}