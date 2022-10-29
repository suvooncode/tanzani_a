<?php include('init.php');
$user_id= $_SESSION["user_id"];
$roll = $_SESSION["roll"];

    if(isset($_POST["save_customer"]))
    {
        $name = $_POST["customer_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];

        $fields = "c_name,email,phone";
        $values = ":c_name,:email,:phone";
        $exec = array(":c_name"=>$name,":email"=>$email,":phone"=>$phone);
        $save = save("customer",$fields,$values,$exec);

        exit();
    }
if(isset($_REQUEST["ActionToPerform"]))
{
    if($_REQUEST["ActionToPerform"]=="showskulist")
    {
        $itemID= $_REQUEST["itemID"];
        $details= SKUsBYITEM($itemID);

        //print_r($details);
        ?>
        <Table class="table">
        <?php
        foreach( $details as $k=>$v ){
            $sku_id= $v["sku_id"];
            $ProductName = json_decode(DetailsBySKU($sku_id))->name;
            $qnty= json_decode(InventoryBYSKU($sku_id,$user_id,$roll))->InventoryNow;
            $rate  =$v["rate"];
            ?>
             <tr>
            <td><?=$v["skucode"]?></td>
            <td><?=$qnty?></td>
            <td><?=$v["rate"]?></td>
            <td><span class="btn btn-warning btn-circle" onclick="addItemForCustomer('<?=$sku_id?>','<?=$rate?>','<?=$ProductName?>')">+</span></td>
            </tr>
            <?php
        }
        ?>
        </Table>
        <?php 
        exit();
    }
    if($_REQUEST["ActionToPerform"]=="addItemToCart")
    {
        addCUstomerCart($_REQUEST["sku_id"],$_REQUEST["rate"],$_REQUEST["ProductName"]);
        exit();
    }
     if($_REQUEST["ActionToPerform"]=="ShowCustomerCart")
    {
        print_r($_SESSION["sku_id"]);
        
        foreach($_SESSION["sku_id"] as $k){
            $sku_id=  $_SESSION["sku_id"][$k];
        ?>
        <tr>
            <td><?php echo $_SESSION["ProductName"][$sku_id] ?></td>
            <td><input type="text" name="qnty[<?=$sku_id?>][]" style="width:40px"></td>
            <td><?php echo $_SESSION["rate"][$sku_id] ?></td>
            <td><input type="text" name="selprice[<?=$sku_id?>][]" style="width:40px"></td>
            <td><input type="text" name="discount[<?=$sku_id?>][]" value='0' style="width:40px"></td>
            <td><input type="text" name="tax[<?=$sku_id?>][]" value='0' style="width:40px"></td>
        </tr>
        <?php
        }
        exit();
    }

}

    if(isset($_POST["sell"]))
    {
        $customerid = $_POST["customer_id"];
        $invoiceno = $_POST["invoiceNO"];
        $userid = $_SESSION["user_id"];
        $rollid = $_SESSION["roll"];

        $productname$_SESSION["ProductName"][$sku_id]
       
        $fields = "InvNo,User_id,Roll_id,Customer_id,InvAmount";
        $values = ":InvNo,:User_id,:Roll_id,:Customer_id,:InvAmount";
        $exes = array(":InvNo"=>$invoiceno,":User_id"=>$userid,":Roll_id"=>$rollid,":Customer_id"=>$customerid);
        $savesell = save("SellTOCustomer",$fields,$values,$exes);
        
        exit();
    }

    $itemstbl = "items";

    $find_items = find("all", $itemstbl, "*", "where status='Y'", array());
?>
<?php   include('header.php');?>
<style>
	table.table-bordered.dataTable th,
	table.table-bordered.dataTable td,
	.table-bordered td,
	.table-bordered thead th {
		text-align: center;
	}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />

<body>
	<?php include('header-top.php'); ?>
	<?php include('sidebar.php'); ?>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header-top">
			<br>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="row"> </div>
				<!-- /.row -->
				<div class="row">
					<div class="col-12">
						<div class="card">
							<!-- /.card-header -->
							<div class="card-body">
								<h4 class="no-margin font-bold"><i class="fa fa-list menu-icon menu-icon" aria-hidden="true"></i> Customer Invoice</h4>
								<!-- <h5 style="color: red">It is advisable to refesh to view current inventory Stock<h5> -->
                                <br> 
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for=""> Select Customer </label>
                                            <select class="js-data-example-ajax form-control" onchange="getcustid(this.value);"></select>
                                        </div>
                                        <div class="col-md-2">
                                           <button style="margin-top: 31px;" class="btn btn-info" onclick="addcustomerform()"><i class="fas fa-plus"></i> Add Customer</button>
                                        </div>

                                        <div class="col-md-2">
                                           <button style="margin-top: 31px;" class="btn btn-info" onclick="randomno()"><i class="fas fa-plus"></i>Generate Invoice No</button>
                                        </div>
                                        <div class="col-md-2">
                                            <label for=""> Invoice No </label>
                                           <input type="text" name="" id="invoice" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row" id="customer_form" style="display:none;">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="" method="POST" id="customerform">
                                                        <label for="">Customer Name : </label>
                                                        <input type="text" name="customer_name" class="form-control" id="">
                                                        
                                                        <label for="">Email</label>
                                                        <input type="email" name="email" class="form-control" id="">

                                                        <label for="">Phone No : </label>
                                                        <input type="text" required name="phone" class="form-control" max="10" id="">

                                                        <br>
                                                        <input type="text" style="display:none;" class="btn btn-info" name="save_customer" >
                                                        <span class="btn btn-primary" onclick="savecustomer()">Save Customer</span>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                            <table id="MyShop" class="table table-bordered table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Items</th>
                                                    <th>Details</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $srno = 1;
                                                foreach ($find_items as $key => $val) {
                                                    $itemid = $val["id"];
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <img src="<?= $val["imgitem"]; ?>" style="width:82px;">
                                                            <br>
                                                            <?php echo $val["name"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo json_decode(ItemInventory($itemid))->InventoryNow; ?>
                                                            <br>
                                                            <span class="btn btn-success" onclick='addForCustomer(<?= $val["id"]; ?>)'> <i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                } ?>
                                                </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-8">
                                        <br>
                                        <br>
                                        <form action="" method="POST" id="ItemSell">
                                            <input type="text" name="customer_id" id="customer_id" style="">
                                            <input type="text" name="invoiceNO" id="invoiceNO" style="">
                                            <table id="MyShop" class="table table-bordered table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>MRP</th>
                                                    <th>Selling price</th>
                                                    <th>Discount</th>
                                                    <th>Tax</th>
                                                </tr>
                                            </thead>
                                            <tbody id="getCustomerItem">

                                            </tbody>
                                        </table>
                                        <span class="btn btn-success" name="sell" onclick="sell()">Sell</span>
                                        </form>
                                    </div>
                                </div>

								<div class="col-md-12" style="<?= $responsealertbgcolor ?>"> <?= $responsealert ?></div>
								<br>
							
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	
	<?php include('footer.php'); ?>

	<!--------------- Request popup ---------------->
	<div id="addForCustomerPanel" class="modal fade" role="dialog">
		<div class="modal-dialog" style="max-width: 700px;">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Request</h4>
				</div>
				<div class="modal-body" id="addForCustomer">
					We are collecting the data . Kindly wait.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
			<!-- Modal content-->
		</div>
	</div>
	<!--------------- Request popup ---------------->

	<script>
		$(function() {
			$("#MyShop").DataTable({
				responsive: true
			});
            $("#mypushID").click();
            getCustomerItem();
		});

        function addcustomerform()
        {
            $("#customer_form").toggle("slow");   
        }

        function randomno()
        {
            var number = Math.floor(Math.random() * 1000) + 1;
            $("#invoice").val(number);
            $('#invoiceNO').val(number);
        }

        function savecustomer()
        {
            $('#customerform').ajaxForm(function(data) {
				swal("Customer Added !","Customer added successfully.","success");
			}).submit();
        }
        function addForCustomer(itemID)
        {
            $("#addForCustomerPanel").modal("show");
            $.ajax({
					method: "POST",
					url: "",
					data: {
						itemID : itemID,
                        ActionToPerform : "showskulist"
					}
				})
				.done(function(response) {
					$("#addForCustomer").html(response);
				});

        }

        function addItemForCustomer(sku_id,rate,ProductName)
        {
            $("#addForCustomerPanel").modal("show");
            $.ajax({
					method: "POST",
					url: "",
					data: {
						sku_id : sku_id,
                        rate : rate,
                        ProductName : ProductName ,
                        ActionToPerform : "addItemToCart"
					}
				})
				.done(function(response) {
					getCustomerItem();
				});
        }
        function getCustomerItem() {
            $.ajax({
                    method: "POST",
                    url: "",
                    data: {
                        ActionToPerform : "ShowCustomerCart"
                    }
                })
                .done(function(response) {
                    $("#getCustomerItem").html(response);
                });
        }
       
       function getcustid(custid)
       {
           $("#customer_id").val(custid);
       }

       function sell()
       {
        $('#ItemSell').ajaxForm(function(data) {
				swal("Items Sold !","Items Sold successfully.","success");
			}).submit();
       }
		
	</script>
</body>

</html>