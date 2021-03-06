<?php
	include_once 'dbconfig.php';
    include_once 'process.php';
    
    $mode = 'LIVE';

	$hookData = [];
    if($mode == 'TEST')
    {
        $myfile = fopen("test.txt", "r") or die("Unable to open file!");
        $testCase = json_decode(fread($myfile, filesize("test.txt")), true);
        fclose($myfile);
    }

    if($json = json_decode(file_get_contents("php://input"), true)) {
		$hookData = $json;
        if($mode == 'TEST') $hookData = $testCase;
        
        ////HookFile Write
        //$myfile = fopen("hookdata.txt", "w") or die("Unable to open file!");
        //fwrite($myfile, json_encode($hookData['data']));
        //fclose($myfile);
        ////--End File Write---////

        //echo (json_encode($hookData['data']));exit;
		if(array_key_exists('data', $hookData))
		{
			$data = $hookData['data'];
            $orderID = $data['orderID'];
            $orderCode = $data['orderCode'];
            $orderDate = $data['orderDate'];
            $insertQuery = "Insert into orders values('$orderID', '$orderDate', '$orderCode')";
            insertData($connection, $insertQuery);
            
            $hostUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

            if(array_key_exists('orderDetails', $data) && sizeof($data['orderDetails']) > 0)
			{
                foreach($data['orderDetails'] as $detail)
                {
                    $detailModelCode = $detail['detailModelCode'];
                    $detailQuantity = $detail['detailQuantity'];
                    $variantName = $detailModelCode;
                    $detailZipUrl = $detail['detailZipUrl'];
                    $detailPreviewUrl = $detail['detailPreviewUrl'];
                    if(sizeof($detail['detailFiles']) > 0) $variantName = $detail['detailFiles'][0]['variantName'];
                    try {
                        //Upload your server
                        $detailZipExtention = pathinfo($detailZipUrl, PATHINFO_EXTENSION); // to get extension
                        $detailZipFileName = pathinfo($detailZipUrl, PATHINFO_FILENAME); //file name without extension
                        $storeZipName = "$detailZipFileName---$variantName.$detailZipExtention";
                        $zipServerUrl = $hostUrl.'/Download/zip/'.$storeZipName;

                        $detailPreviewExtention = pathinfo($detailPreviewUrl, PATHINFO_EXTENSION); // to get extension
                        $detailPreviewFileName = pathinfo($detailPreviewUrl, PATHINFO_FILENAME); //file name without extension
                        $storePreviewName = "$detailZipFileName---$variantName.$detailPreviewExtention";
                        $previewServerUrl = $hostUrl.'/Download/png/'.$storePreviewName;
                        $created_at = date('Y-m-d H:i');
                        
                        //Db order_details table insert....
                        $insertQuery = "Insert into order_details values(NULL, '$orderID', '$detailQuantity', '$detailModelCode', '$detailZipUrl', '$detailPreviewUrl', '$zipServerUrl', '$previewServerUrl', '$variantName')";
                        insertData($connection, $insertQuery);
                        
                        $cronRowRes = getData($connection, "Select id From cron_jobs Where detail_zip_url='$detailZipUrl' AND detail_preview_url='$detailPreviewUrl'");
                        if(sizeof($cronRowRes) == 0)
                        {
                            $insertQuery = "Insert into cron_jobs values(NULL, '$detailZipUrl', '$detailPreviewUrl', '$zipServerUrl', '$previewServerUrl', '$storeZipName', '$storePreviewName', '0', '$created_at')";
                            insertData($connection, $insertQuery);
                        }
                    } catch (Exception $e){
                        echo json_encode('{message:"error", code:402}'); 	
                    }
                }
            } else 
            {
                echo json_encode('{message:"error", code:402}');
                exit;
            }
			echo json_encode('{message:"success", code:200}'); 
		}
	}  else {
		echo json_encode('{message:"error", code:400}'); 
	}
?>