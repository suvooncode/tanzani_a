<?php
if(isset($_SESSION["user_id"]))
{
	 $user_id = $_SESSION["user_id"];
}
function setsessioncookie($id)
{
	if(isset($_SESSION["user_login_id"]))
	{
		$user_login_id= $_SESSION["user_login_id"];
		setcookie("user_login_id", $user_login_id, time() + (86400 * 30), "/");
	}
}
function login($data)
{
	$email = stripcleantohtml($data["email"]);
	$password= stripcleantohtml($data["password"]);
	$details["email"]=$email;
    $details["pass"]=$password;
    $details["is_admin"]="N";
    login_activity($details);
	$response= array();
	$find= find("first","users","*"," where email='$email' ",array());
	if($find)
	{
		$password= $find["password"];
		if( $find["password"] !=="")
		{
		    
		    
			if($password==md5($data["password"]))
			{
				$_SESSION["user_id"]=$find["user_id"];
				$_SESSION["name"]= $find["name"];
				$_SESSION["roll"]= $find["roll"];
				$response = array("data"=>$find,"login"=>true, "message"=>"Login Successfull");
			}
			else
			{
				$response = array("data"=>"","login"=>false, "message"=>"Password is not matching");
			}
		}
		else
		{
			$response = array("data"=>"","login"=>false, "message"=>"Please contact to admin");
		}
	}
	else{
		$response = array("data"=>"","login"=>false, "message"=>"Please contact to admin");
	}
	return json_encode($response);
}

function checklogin()
{
	$request = $_SERVER['REQUEST_URI'];
	$base="/SCM";
	$request= str_replace($base,"",$request);
}


function objectToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        }
        else {
            return $d;
        }
    }

function itemtoused()
{
	$find_item= find("all","items", "*" ,  "where status='Y'",array());
	return json_encode($find_item);
}

function warehouselist()
{
	$find_warehouse= find("all","warehouse", "*" ,  "where 1",array());
	return json_encode($find_warehouse);
}
function sendmailapi($data)
{
	$curl = curl_init("https://devenv-tdtl.online/mailapi/mailapi.php");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $data =  "success";
		//print_r($response );
}
function orderreverse($id,$order_id)
{
	$orderbydealerid= find("first","stockuseddetails","*","where stock_details_id='$order_id'",array());
	$dealer_id= $orderbydealerid["user_id"];
	$dealerdetails= find("first","users","*"," where user_id='$dealer_id'",array());
	$salesid= $dealerdetails["sales_executive_id"];
	$execname = $dealerdetails["name"];
	$execmail = $dealerdetails["email"];
	if($id == $salesid)
	{
		
		$message = "Dear ".$execname.", <br> Your : #". $order_id." order declined";
		/*********mail send  */   
		$data = [
			'mailto' => $execmail,
			'fullname' => "Order Declined",
			'message' => $message,
			'subject'  => "#".$order_id." Declined ",
			'fromname' => "Order Declined",
			'sendmail' => "sendmail"
				
			];
			sendmailapi($data);
			
			notify($id,	$salesid,$message);
			notify($id,	$dealer_id,$message);
	/**End mail Send  */
	}
	else{
		$findadminloop = find("first","admins","*","where admin_id='$salesid'",array());
		$parent_id= $findadminloop["parent_id"];
		echo $findadminloop["name"];
		orderprocessid($id,$order_id,$parent_id);
	}
	
}
function orderprocessid($id,$order_id,$parent_id)
{
	if($id==$parent_id)
	{
		$admindetails= find("first","admins","*"," where admin_id='$id'",array());
		$execname = $admindetails["name"];
		$execmail = $admindetails["email"];
			$message = "Dear ".$execname.", <br> Your : #". $order_id." order declined";
			/*********mail send  */   
			$data = [
				'mailto' => $execmail,
				'fullname' => "Order Declined",
				'message' => $message,
				'subject'  => "#".$order_id." Declined ",
				'fromname' => "Order Declined",
				'sendmail' => "sendmail"
					
				];
				sendmailapi($data);
				
				notify($id,$parent_id,$message);
				
		/**End mail Send  */
	}
	else{
		$findadminloop = find("first","admins","*","where admin_id='$parent_id'",array());
		$parent_idparent= $findadminloop["parent_id"];
		$admindetails= find("first","admins","*"," where admin_id='$parent_id'",array());
		$execname = $admindetails["name"];
		$execmail = $admindetails["email"];
			$message = "Dear ".$execname.", <br> Your : #". $order_id." order declined";
			/*********mail send  */   
			$data = [
				'mailto' => $execmail,
				'fullname' => "Order Declined",
				'message' => $message,
				'subject'  => "#".$order_id." Declined ",
				'fromname' => "Order Declined",
				'sendmail' => "sendmail"
					
				];
				sendmailapi($data);
				
				notify($id,$parent_idparent,$message);
		echo "<br>".$findadminloop["name"];
		orderprocessid($id,$order_id,$parent_idparent);
	}
}

function notify($send_form_id,$send_to_id,$notify_text){
    
    $fields = "send_form_id,send_to_id,notification_text";
    $values = ":send_form_id,:send_to_id,:notification_text";
    $exe = array(":send_form_id" => $send_form_id, ":send_to_id" =>$send_to_id, ":notification_text" =>$notify_text);
    $savenotification = save("Notification", $fields, $values, $exe);

}

function cust_notify($send_form_id,$send_to_id,$notify_text){
    
    $fields = "send_form_id,send_to_id,notification_text";
    $values = ":send_form_id,:send_to_id,:notification_text";
    $exe = array(":send_form_id" => $send_form_id, ":send_to_id" =>$send_to_id, ":notification_text" =>$notify_text);
    $savenotification = save("customer_Notification", $fields, $values, $exe); 
    
}

function login_activity($data)
{
    $email= $data["email"];
    $pass = $data["pass"];
    $is_admin = $data["is_admin"];
    $t= "login_activity";
    $f= "email,password,is_admin";
    $v= ":email,:password,:is_admin";
    $e= array(":email"=>$email,":password"=>$pass,":is_admin"=>$is_admin);
    $s= save($t,$f,$v,$e);
}

function ItemInventory($ItemID)
{
	$user_id= $_SESSION["user_id"];
	$roll= $_SESSION["roll"];
	$sku = find("all", "sku", "*", "where status='Y' and product_id = '$ItemID'", array());
		$s = array();
		foreach ($sku as $k => $v) {
			array_push($s, $v['sku_id']);
		}

		$sku_id = "(" . implode($s, ",") . ")";


		//$importqnty = find("first", "stockimportdetails", "sum(quanity) as importq", " where sku_id IN $sku_id", array());
		$table= "distributor_stockused as ds inner join distributor_stockuseddetails as dsdt on dsdt.stock_details_id=ds.order_no";
		$usedqnty = find("first", $table, "sum(quantity) as usedq", " where ds.sku_id in $sku_id and dsdt.user_id='".$user_id."' and dsdt.roll_id='".$roll."' ", array());
		$TotalBuy= $usedqnty["usedq"];
		
		$findlastsaledate = find("first",$table,"*","where ds.sku_id in $sku_id and dsdt.user_id='".$user_id."' and dsdt.roll_id='".$roll."' order by export_id desc",array());
		$lastselldate = $findlastsaledate["created_time"];

		$TotalSold= 0;
		$InventoryNow= $TotalBuy - $TotalSold;
		$array= array("TotalBuy"=>$TotalBuy,"TotalSold"=>$TotalSold,"InventoryNow"=>$InventoryNow,"lastsaleDate"=>$lastselldate);
		return json_encode($array);
    
}

function ItemInventoryForUser($ItemID,$user_id,$roll)
{
	$user_id= $user_id;
	$roll= $roll;
	$sku = find("all", "sku", "*", "where status='Y' and product_id = '$ItemID'", array());
		$s = array();
		foreach ($sku as $k => $v) {
			array_push($s, $v['sku_id']);
		}

		$sku_id = "(" . implode($s, ",") . ")";


		//$importqnty = find("first", "stockimportdetails", "sum(quanity) as importq", " where sku_id IN $sku_id", array());
		$table= "distributor_stockused as ds inner join distributor_stockuseddetails as dsdt on dsdt.stock_details_id=ds.order_no";
		$usedqnty = find("first", $table, "sum(quantity) as usedq", " where ds.sku_id in $sku_id and dsdt.user_id='".$user_id."' and dsdt.roll_id='".$roll."'", array());
		$TotalBuy= $usedqnty["usedq"];
		$TotalSold= 0;
		$InventoryNow= $TotalBuy - $TotalSold;
		$array= array("TotalBuy"=>$TotalBuy,"TotalSold"=>$TotalSold,"InventoryNow"=>$InventoryNow);
		return json_encode($array);
    
}

function InventoryBYSKU($sku_id,$user_id,$roll)
{
	$user_id= $user_id;
	$roll= $roll;

		//$importqnty = find("first", "stockimportdetails", "sum(quanity) as importq", " where sku_id IN $sku_id", array());
		$table= "distributor_stockused as ds inner join distributor_stockuseddetails as dsdt on dsdt.stock_details_id=ds.order_no  ";
		$usedqnty = find("first", $table, "sum(quantity) as usedq", " where ds.sku_id = '".$sku_id."' and dsdt.user_id='".$user_id."' and dsdt.roll_id='".$roll."'", array());
		$TotalBuy= $usedqnty["usedq"];

		$table= "SellTOCustomer as sltoC inner join SellCustomerDetails as scD on sltoC.Sell_id = scD.Sell_id";
		$where = " where scD.SkuID = $sku_id and sltoC.User_id='".$user_id."' and sltoC.Roll_id='".$roll."'";
		$sellqnty = find("first", $table, "sum(Qnty) as sellQnty", $where , array());

		$finddate = find("first","stockimportdetails","expirydate,mfg_date,mrp","where sku_id = '$sku_id' order by id desc",array());
		$expiry = $finddate["expirydate"];
	 	$mfg = $finddate["mfg_date"];
		$mrp = $finddate["mrp"];

		$wh =$where." order by scD.SellCustID desc";
		$findlastselldate = find("first",$table,"*",$wh,array());
		$lastsaledate = $findlastselldate["CreatedDate"];

		$wh =$where." order by scD.SellCustID asc";
		$findfirstselldate = find("first",$table,"*",$wh,array());
		$firstsaledate = $findfirstselldate["CreatedDate"];
		
		$firstdate = strtotime($firstsaledate);
		$lastdate = strtotime($lastsaledate);
		$difference = $lastdate - $firstdate;
		$monthsdiff = round($difference/86400)/30;

		$TotalSold=$sellqnty["sellQnty"];
		$Avgsellbymonth = $TotalSold / $monthsdiff;

		$InventoryNow= $TotalBuy - $TotalSold;
		$array= array("TotalBuy"=>$TotalBuy,"TotalSold"=>$TotalSold,"InventoryNow"=>$InventoryNow,"expiry"=>$expiry,"mfg"=>$mfg,"mrp"=>$mrp,"month_average_sell"=>$Avgsellbymonth,"firstsellDate"=>$firstdate,"lastsellDate"=>$lastdate);
		return json_encode($array);
    
}

function DetailsBySKU($sku)
{
	$table= "sku as sk inner join items as itm on itm.id=sk.product_id";
	$where = " where sk.sku_id='".$sku."'";
	$finddetails= find("first",$table,"*",$where,array());
	return json_encode($finddetails);
}

function SKUsBYITEM($itemID)
{
	$table= "sku as sk inner join items as itm on itm.id=sk.product_id inner join distributor_stockused as diST on sk.sku_id= diST.sku_id";
	$where = " where itm.id='".$itemID."'";
	$finddetails= find("all",$table,"*",$where,array());
	return $finddetails;
}

function SellCustomer($itemID,$customer)
{
	
}
function SellCustomerDetails($Sell_id)
{
	$table= "SellTOCustomer as sltoC inner join SellCustomerDetails as scD on sltoC.Sell_id = scD.Sell_id";
	$where = " where sltoC.Sell_id='".$Sell_id."'";
	$finddetails= find("all",$table,"*",$where,array());
	return json_encode($finddetails);
}
function addCUstomerCart($sku_id,$rate,$ProductName){
	$_SESSION["sku_id"][$sku_id]=$sku_id;
	$_SESSION["rate"][$sku_id]=$rate;
	$_SESSION["ProductName"][$sku_id]=$ProductName;
}
function returnVetrinaCart($sku_id,$rate,$ProductName){
	$_SESSION["return_sku_id"][$sku_id]=$sku_id;
	$_SESSION["return_rate"][$sku_id]=$rate;
	$_SESSION["return_ProductName"][$sku_id]=$ProductName;
}


function NumberToIndianCurrency($paisa)
{
	$number = $paisa;
		$no = floor($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
			'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			'7' => 'seven', '8' => 'eight', '9' => 'nine',
			'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			'13' => 'thirteen', '14' => 'fourteen',
			'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
			'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			'60' => 'sixty', '70' => 'seventy',
			'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += ($divider == 10) ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] .
					" " . $digits[$counter] . $plural . " " . $hundred
					:
					$words[floor($number / 10) * 10]
					. " " . $words[$number % 10] . " "
					. $digits[$counter] . $plural . " " . $hundred;
			} else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$points = ($point) ?
			"And " . $words[$point / 10] . " " . 
				$words[$point = $point % 10] : '';

		return $result . "Rupees  " . $points . " Paise";
}

function calculateTotalBillAmount($user_id)
{
	$tbl = "stockuseddetails as std inner join users as u on std.user_id= u.user_id";
	$wh = "where std.user_id='$user_id' order by stock_details_id  desc ";
	$findstock = find("all", $tbl, "*, u.name as customername", $wh, array());
	$noOfInvoice = count($findstock);
	$lastdateofinvoice = find("first",$tbl,"*","where std.user_id='$user_id' order by stock_details_id  desc",array());
	$lastdateraw = $lastdateofinvoice["Created_datetime"];
	if($lastdateraw == "")
	{
		$lastdate = "-";
	}
	else {
		$lastdate = date("d-m-Y",strtotime($lastdateraw));
	}

	$totalBilledAmount = 0;
	$totalBilledDiscount = 0;
	$totalInvoiceAmount = 0;

	foreach ($findstock as $key => $val) {

		$stock_details_id = $val["stock_details_id"];
		
		$tbl = "stockused as st inner join stockuseddetails as std on st.order_no = std.order_no inner join sku as s on s.sku_id = st.sku_id inner join  items as i on i.id = s.product_id inner join users as u on std.user_id= u.user_id ";

		$findeachstock= find("all",$tbl , "*, i.name as product_name , u.name as customername ", "where std.stock_details_id = '$stock_details_id' " , array());

		$findlastinvoiceamount = find("first",$tbl,"*","where std.user_id='$user_id' order by stock_details_id  desc ",array());
		$lastinvoiceamount = $findlastinvoiceamount["total_payment"];
		
		$toatlamount = 0;
		$taxamount = 0;
		$subtotal = 0;
		$totaldiscount = 0;

		foreach($findeachstock as $k=>$v) {
			$price = $v['quantity']*$v["rate"];
			$taxRate = $v['tax'];
			$tax=$price*$taxRate/100;
			$PriceIncTax = $price + $tax;
			$discountamt = $price*($v['discount']/100);
			$totalamt = $PriceIncTax - $discountamt;

			

			$discount = $v['discount'];
			$calDiscount = ($price*($v['discount']/100));

			$toatlamount = $toatlamount + $totalamt;
			$taxamount =  $taxamount + $tax;
			$subtotal = $subtotal + $price;
			$totaldiscount = $totaldiscount + $calDiscount;
		
			$verifylrno = find("all","verification_detail","*","where stockused_detail_id = '$stock_details_id'",array());
                                                            
			
		}

			if($verifylrno)
			{
				$totalInvoiceAmount = $totalInvoiceAmount + $toatlamount;
			}

		$totalBilledAmount = $totalBilledAmount + $toatlamount;
		$totalBilledDiscount = $totalBilledDiscount + $totaldiscount;
		

	}

	$findpayment = find("first","paid_invoice","amount as paidamount","where user_id='$user_id' and payment_status = 'paid' order by paid_invoice_id DESC ",array());
	$f= $findpayment["paidamount"];

	$result = array("BilledAmount"=>$totalBilledAmount,
					"DiscountAmount"=>$totalBilledDiscount,
					"NoOfInvoice"=>$noOfInvoice,
					"totalInvoiceAmount"=>$totalInvoiceAmount,
					"lastInvoiceDate"=>$lastdate,
					"lastInvoiceAmount"=>$f
				);
	return $result;
}

	function findPaymentDetails($user_id)
	{
		$findpayment = find("first","paid_invoice","sum(amount) as paidamount","where user_id='$user_id' and payment_status = 'paid'",array());
		return $findpayment["paidamount"];
	}

	function findPaymentDate($user_id)
	{
		$findpaymentdate = find("first","paid_invoice","*","where user_id='$user_id' and payment_status = 'paid' order by paid_invoice_id DESC",array());
		return $findpaymentdate["payment_date"];
	}

	function findDueAmount($user_id)
	{
		$invoiceAmountarr = calculateTotalBillAmount($user_id);
		$invoiceAmount = $invoiceAmountarr["BilledAmount"];

		$paidAmount = findPaymentDetails($user_id);

		$dueAmount = $invoiceAmount - $paidAmount;
		return $dueAmount;
		
	}

	
	function FindDristributorIDS($UserId) {
			$AdminTable= "admins";
			$EndUserTable= "users";
			$MyDistriborList= find("all",$EndUserTable,"*"," where sales_executive_id= '$UserId'",array());
			if($MyDistriborList)
			{
				foreach($MyDistriborList as $f=>$u){
					array_push($_SESSION["MyDistriborList"],$u["user_id"]);
				}
			}
			$AmIParent = find("all",$AdminTable,"*"," where parent_id= '$UserId'",array());
			if($AmIParent)
			{
				foreach($AmIParent as $c=> $k)
				{
					$MyNextChildId= $k["admin_id"];
					FindDristributorIDS($MyNextChildId);
				}
			}
			else {
				return $_SESSION["MyDistriborList"];
				
			}
	}

	function contractMailwithattach($to,$mailsubject,$mailcontent,$filename)
	{
		//echo $to." ".$mailsubject." ".$mailcontent." ".$filename;
		$data = [
			'mailto' => $to,
			'fullname' => "Performa Invoice",
			'message' => $mailcontent,
			'subject' => $mailsubject,
			'fromname' => "VETRINA HEALTHCARE",
			'sendmail' => "sendmail",
			'filename' => $filename
			];
			// print_r($data);
			$curl = curl_init("https://vetrinahealthcare.com/dms/PHPMailer/requisition.php");
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			curl_close($curl);
			$data = "success";
	}

	function FindMYTeam($UserId) {
		$AdminTable= "admins";
		$AmIParent = find("all",$AdminTable,"*"," where parent_id= '$UserId' ",array());
		if($AmIParent)
		{
			foreach($AmIParent as $c=> $k)
			{
				array_push($_SESSION["FindMYTeam"],$k["admin_id"]);
				$MyNextChildId= $k["admin_id"];
				FindMYTeam($MyNextChildId);
			}
		}
		else {
			return $_SESSION["MyDistriborList"];
			
		}
}


function FindMYReportingManager($UserId) {
	$AdminTable= "admins";
	$AmIParent = find("first",$AdminTable,"*"," where admin_id= '$UserId' ",array());
	if($AmIParent["parent_id"]!="0")
	{
		
			array_push($_SESSION["FindMYReportingManager"],$AmIParent["parent_id"]);
			
			FindMYReportingManager($AmIParent["parent_id"]);
	}
	else {
		return $_SESSION["FindMYReportingManager"];
		
	}
}


 function MemberDetails($user_Id){


	$findUserDet=  find("first","admins","*"," where admin_id='$user_Id'",array());

	$heq_id= $findUserDet["headquarter_id"];

	$findRolename= find("first","admin_roles_permission as arp  inner join  roles as r on  arp.role_id= r.role_id ","*"," where arp.admin_id='$user_Id'",array());

	$findHeadQuaters= find("first","headquarters ","*"," where h_id='$heq_id'",array());

	$response= array("UserDet"=>$findUserDet, "RoleDet"=>$findRolename, "Headquaters"=>$findHeadQuaters );
	return $response;
 }
 
 
 
 function mobilenoti($email,$noticontent,$headernoti)
 {
     $email = $postdata->email;
     $noticontent = $postdata->noticontent;
     $headernoti = $postdata->headernoti;
     
     $findplayerid = find("first","users_player_id","*","where email= '$email' ",array());
     
     $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://onesignal.com/api/v1/notifications',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "app_id": "35223e20-084b-41df-b8c4-9a8480636279",
            
            
            "data": {"foo": "bar"},
            "contents": {"en": "'.$noticontent.'"},
            "headings": {"en": "'.$headernoti.'"},
            "include_player_ids": ["'.$findplayerid['player_id'].'"]
            }',
            CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ZmRmOGVjYWUtNDcwOS00YzE2LTg0YjktNjMxN2JkYTAwM2Q4'
            ),
        ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
 }

 
    function registrationProcess($data)
{
    $process_id = "1";
    $customer_id = $data["cust_id"];
    $action = $data["action"];

    $findapprovalstate = find("first","process_table","*","where customer_id='$customer_id' order by id desc",array());
    
    $from_desig = $findapprovalstate["form_desig_id"];
    $to_desig = $findapprovalstate["to_desig_id"];
    $manager = array(3,4,5);


    // from customer to admin 
    if($action == "approve")
    {
        if($to_desig == "")
        {
            $from_desig = 0;
            $from_admin_id = 0;
            $to_desig = 1;
            $to_admin_id = 1;

        }

		//Admin to ASM , ZSM , NSM

        if($to_desig == "1")
        {
            $from_desig = 1;
            $from_admin_id = 1;
            $to_desig = $data["to_desig_id"];
            $to_admin_id = $data["to_admin_id"];
        }

		// ZSM , NSM ,ASM to Finance

        if(in_array($to_desig,$manager))
        {
            $from_desig = $to_desig;
            $from_admin_id = $to_admin_id;
            $to_desig = 9;
            //$findfinance = find("first","admin as a inner join admin_roles as ar on a.admin_id='ar.admin_id'","*","where ar.desig_id='9'",array());
            $to_admin_id = 5;

        }

		// Finance to CEO

         if($to_desig == "9")
        {
            $from_desig = 9;
            $from_admin_id = 5;
            $to_desig = 11;
           // $findceo = find("first","admin as a inner join admin_roles as ar on a.admin_id='ar.admin_id'","*","where ar.desig_id='14'",array());
            $to_admin_id = 7;
        }

        $fields = "process_id,customer_id,from_desig_id,from_admin_id,to_desig_id,to_admin_id,action";
        $values = ":process_id,:customer_id,:from_desig_id,:from_admin_id,:to_desig_id,:to_admin_id,:action";
        $exe = array(
            ":process_id"=>$process_id,
            ":customer_id"=>$customer_id,
            ":from_desig_id"=>$from_desig,
            ":from_admin_id"=>$from_admin_id,
            ":to_desig_id"=>$to_desig,
            ":to_admin_id"=>$to_admin_id,
            ":action"=>$action
        );

        $saveprocess = save("process_table",$fields,$values,$exe);

		
    }
}

?>