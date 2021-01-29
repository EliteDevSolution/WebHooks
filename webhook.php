<?php
	include_once 'dbconfig.php';
	include_once 'process.php';

	$hookData = [];
	$testCase = [
		"eventType" => "OrderGenerated",
		"data" => [
			"orderCode" => "000000".date('YmdHis'),
			"orderDate" => date("Y-m-d H:i.s"),
			"orderDetails" => [
				"detailModelCode" => "BCTM".date('His'),
				"detailFiles" => [
					[
						"fileUrl" => "https://picsum.photos/200/300.jpg"
					],
					[
						"fileUrl" => "https://homepages.cae.wisc.edu/~ece533/images/fruits.png"
					]
				]
			]

		]
	];

	if($json = !json_decode(file_get_contents("php://input"), true)) {
		$hookData = $json;
		$hookData = $testCase;
		if(array_key_exists('data', $hookData))
		{
			$data = $hookData['data'];
			$orderCode = $data['orderCode'];
			$orderDate = $data['orderDate'];
			$detailModelCode = '';
			if(array_key_exists('orderDetails', $data))
			{
				$detailModelCode = $data['orderDetails']['detailModelCode'];
			}
			$fileList = [];
			if(array_key_exists('detailFiles', $data['orderDetails']))
			{
				foreach($data['orderDetails']['detailFiles'] as $file)
				{
					$fileList[] = $file['fileUrl'];
				}
			}

			$uploadUrlList = [];
			$hostUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                $_SERVER['REQUEST_URI']; 
  
			foreach($fileList as $url)
			{
				//check
				$name = basename($url);
				try {
					$files = file_get_contents($url);
					if ($files) {
						$stored_name = time() . $name;
						file_put_contents("../Download/$stored_name", $files);
						
						$uploadUrlList[] = $hostUrl.'/Download/'.$stored_name;
					}
				}catch (Exception $e){
					echo json_encode('{message:"error", code:402}'); 	
				}

			}
			
			$fileList = serialize($fileList);
			$uploadUrlList = serialize($uploadUrlList);
			//fileUpload owner Server

			$insertQuery = "Insert into orders values(NULL, '$orderDate', '$orderCode', '$detailModelCode', '$fileList', '$uploadUrlList')";
			insertData($connection, $insertQuery);

			// $myfile = fopen("temp.txt", "w") or die("Unable to open file!");
			// fwrite($myfile, $data['eventType']);
			// fclose($myfile);
			echo json_encode('{message:"success", code:200}'); 
		}
	}  else {
		echo json_encode('{message:"error", code:400}'); 
	}
?>