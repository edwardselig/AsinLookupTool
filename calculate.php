<?php
	
	$asin = $_POST['asin'];
	$public_key = "public_key";
	$private_key = "private_key";
	$associate_tag = "associate_tage";
	
	

	include("../../aws_signed_request.php");
	$request = aws_signed_request('com', array(
                                'Operation' => 'ItemLookup',
                                'ItemId' => $asin,
                                'ResponseGroup' => 'Large'), $public_key,
	$private_key, $associate_tag);

                        $response = @file_get_contents($request);

                        if ($response === FALSE) {
                                echo "Request failed.<br>";
                        }

                        else {
                        // parse XML
                        	//echo '<pre>';
                            $pxml = simplexml_load_string($response);
                    		//var_dump($pxml);
                    		echo "Title: ";
                        	echo $pxml->Items->Item->ItemAttributes->Title;
                        	
                        	echo "</br></br>ASIN: ";
                        	echo $pxml->Items->Request->ItemLookupRequest->ItemId;
                        	
                        	echo "</br></br>Manufacturer: ";
                        	echo $pxml->Items->Item->ItemAttributes->Manufacturer;
                        	
                        	echo "</br></br>Part Number: ";
                        	echo $pxml->Items->Item->ItemAttributes->PartNumber;
                        	
                        	echo "</br></br>UPC: ";
                        	echo $pxml->Items->Item->ItemAttributes->UPC;
                        	
                        	echo "</br></br>Formatted Price: ";
                        	echo $pxml->Items->Item->ItemAttributes->ListPrice->FormattedPrice;
                        	
                        	echo "</br></br>Category: ";
                        	echo $pxml->Items->Item->ItemAttributes->ProductGroup;
                        	
                        	$weight = ($pxml->Items->Item->ItemAttributes->PackageDimensions->Weight)/100;
                        	$height = ($pxml->Items->Item->ItemAttributes->PackageDimensions->Height)/100;
                        	$length = ($pxml->Items->Item->ItemAttributes->PackageDimensions->Length)/100;
                        	$width = ($pxml->Items->Item->ItemAttributes->PackageDimensions->Width)/100;
                        	
                        	$array = array($height,$length,$width);
                        	sort($array);
                        	
                        	echo "</br></br>Weight: ";
                        	echo ($weight . " lbs");
                        	
                        	echo "</br></br>Height: ";
                        	echo ($pxml->Items->Item->ItemAttributes->PackageDimensions->Height)/100 . " in.";
                        	
                        	echo "</br></br>Length: ";
                        	echo ($pxml->Items->Item->ItemAttributes->PackageDimensions->Length)/100 . " in.";
                        	
                        	echo "</br></br>Width: ";
                        	echo ($pxml->Items->Item->ItemAttributes->PackageDimensions->Width)/100 . " in.";
                        	
                        	//echo "</br></br>" .$array[0] . $array[1] . $array[2];
                        	
                        	if($weight>18 or $array[2]> 18 or $array[1]>14 or $array[0]>8){
                        		echo "</br></br>Product Oversized";
                        	}else{echo "</br></br>Product Standard-size";}
                        	
            
                        	echo "</br></br><a href = " . ($pxml->Items->Item->DetailPageURL) . ">Link To Product</a>";
                 		}
				
?>
