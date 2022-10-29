<?php include("../init.php");
$responsestatus= 1;
$responsemessage="Saved Recipt";
$rowcount=0;



 
if(isset($_SESSION["itemid"])){
    $user_id= $_SESSION["user_id"];
    $warehouse_id="1"; //$_POST["warehouse"];
    $accountingdate = date("Y-m-d") ; // $_POST["accountingdate"];
    
    $finduserdetail =  find("first","users","*","where user_id = $user_id",array());
    $executive_id = $finduserdetail["sales_executive_id"];
    $dist_name = $finduserdetails["name"];
    $findexecutivemail = find("first","admins","*","where admin_id = '$executive_id'",array());
    $execmail = $findexecutivemail["email"];
    $execname = $findexecutivemail["name"];
    
	$items= $_SESSION["itemid"]; //$_POST["item"];
    //$qnty = $_POST["quantity"];
   // $units= $_POST["units"];
    //$rates=  $_POST["rate"];
	//$skuq = $_SESSION["skuid"] ; //$_POST["sku"];
	
	/*
	$_SESSION["itemid"][]= $_POST["itemid"];
	$_SESSION["skuid"][]=  $_POST["skuid"];
	$_SESSION["lotqnty"][]=  $_POST["lotqnty"];
	*/
	
	$qnty = array();
	$rates =array();
	$units =array();
	$skuq= array();
	
	$sumofamount = 0;
	foreach($_SESSION["itemid"] as $k=>$v) { 
		if($v!=""){
		$itemarq = find("first","items","*"," where id= '$v' ",array());
		$lot = $itemarq["min_quantity_order"];
		$unitarq= $itemarq["units"];
		$si= $_SESSION["skuid"][$k];
		$lotqnty = $_SESSION["lotqnty"][$k];
		$skuar = find("first","sku","*"," where sku_id= '$si' ",array());
		$skucodearq = $skuar["skucode"];
		$ratear = find("first","stockimportdetails","*"," where sku_id= '$si' ",array());
		$ratearq = $ratear["rate"];
		$amnt=  ($ratearq * $lotqnty * $lot );
		$tqnty = ($lotqnty * $lot);
		$cartvalue =$cartvalue + $amnt;
		array_push($qnty , $tqnty);
		array_push($rates , $ratearq );
		array_push($units , $unitarq );
		array_push($skuq, $skucodearq );
		}

	}
	
	$sumofamount = $cartvalue;
	
    $lastorder_no= find("first","stockuseddetails","order_no","where 1 order by stock_details_id DESC",array());
    $order_no= $lastorder_no["order_no"] + 1;
    
   $subject ="New Order Request";
   $message = "Dear".$execname.", <br> Kindly check My new Order : ". $order_no." . <br> <a href='https://gardensneed.online/order/history.php'>Click here to view</a>";
 /*********mail send  */   
   $data = [
       'mailto' => $execmail,
       'fullname' => $dist_name." New Order",
       'message' => $message,
       'subject'  => $dist_name." New Order",
       'fromname' => $fromname,
       'sendmail' => "sendmail"
        
    ];
	sendmailapi($data);
	
	/**End mail Send  */
		
	$Billing_datetime= date("Y-m-d H:i:s", strtotime($accountingdate));
    $fieldsn= "order_no,warehouse_id,Created_datetime,Billing_datetime,Total_amount,stockeusedstatus,user_id";
    $valuesn= ":order_no,:warehouse_id,:Created_datetime,:Billing_datetime,:Total_amount,:stockeusedstatus,:user_id";
    $executen= array(":order_no"=>$order_no,":warehouse_id"=>$warehouse_id,":Created_datetime"=>date("Y-m-d H:i:s"),
    ":Billing_datetime"=>$Billing_datetime,":Total_amount"=>$sumofamount,":stockeusedstatus"=>"Y",":user_id"=>$user_id);
    $save= save("stockuseddetails",$fieldsn,$valuesn,$executen);
		
	$statusitem=array(1);
    foreach ($items as $key=>$val)
    {
		if($val!=""){
        $order_id = $order_no;
        $product_id = $val;
		$skuucode = $skuq[$key];
		
		$sku = find("first","sku","*","where status='Y' and skucode = '$skuucode'", array());		
		$sku_id = $sku['sku_id'];
		$pid= $sku["product_id"];
		
		$sku_code = $sku['skucode'];
		//exit();
		
		if($skuucode==$sku_code && $val != $pid){
			$responsestatus=1;
			$responsemessage="Duplicate SKU code found";
			$rowcount=$key;
			array_push($statusitem,$responsestatus); 
		}
		else{
			array_push($statusitem,"1");
		}
	}
    }
	
	if(in_array("0", $statusitem))
	{
		
	}
	else 
	{
			foreach ($items as $key=>$val)
			{
				if($val!=""){
				$order_id= $order_no;
				$product_id = $val;
				$skuucode = $skuq[$key];
				
				$sku = find("first","sku","*","where status='Y' and skucode = '$skuucode'", array());		
				$sku_id = $sku['sku_id'];
				$pid= $sku["product_id"];
				
				$sku_code = $sku['skucode'];
											
				$fieldsn1= "skucode,product_id,status";
				$valuesn1= ":skucode,:product_id,:status";
				$executen1= array(":skucode"=>$skuucode,":product_id"=>$product_id,":status"=>"Y");
				
				if($val != $pid){
				$save2= save("sku",$fieldsn1,$valuesn1,$executen1);
				}
				else{
					$save2= $sku_id;
				}
				
				$commo_code= find("first","items","*","where status='Y' and id='$product_id'", array());		
				$commodity_code = $commo_code['commodity_code'];
		
				//$commodity_code ="";
				$quantity= $qnty[$key];
				$rate= $rates[$key];
				$total_payment= $quantity * $rate; 
				$note = "";
				$status = "Y";
				$created_time= date("Y-m-d H:i:s", strtotime($accountingdate));
				
				$fields= "order_no,sku_id,order_id,commodity_code,quantity,rate,total_payment,note,status,created_time";
				$values= ":order_no,:sku_id,:order_id,:commodity_code,:quantity,:rate,:total_payment,:note,:status,:created_time";
				$execute= array(":order_no"=>$order_no,":sku_id"=>$sku_id,":order_id"=>$order_id,":commodity_code"=>$commodity_code,":quantity"=>$quantity,":rate"=>$rate,":total_payment"=>$total_payment,":note"=>$note,":status"=>$status,":created_time"=>$created_time);
				$save= save("stockused",$fields,$values,$execute);
				$sumofamount = $total_payment + $sumofamount;
			}
			
			}
	}


	unset($_SESSION["itemid"]);
	unset($_SESSION["skuid"]);
	unset($_SESSION["lotqnty"]);

	$response =array("message"=>$responsemessage, "order_no"=>$order_no , 'responsestatus'=>$responsestatus , "rowcount"=>$rowcount);
    echo json_encode($response);
}
?>