<?php   
include('init.php');
if(isset($_POST['submit']))
{
      $city = $_POST["city"];
      $fileds= "loc_id,city_name";
      $values= ":loc_id,:city_name";
      $exe= array(":loc_id"=>0,":city_name"=>$city);
      $save= save("city",$fileds,$values,$exe);
}
$findCity = find('all','city', '*', 'where 1',array());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <title>Tanzania || City || Admin </title>
    <!-- Favicon icon -->
    <?php include("csslink.php"); ?>
</head>
<body>
   <?php include("preloader.php") ?>

    <div id="main-wrapper">
        <?php include("navbar.php"); ?>
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>
        <!-----maincontent start----->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-6 col-xxl-12">
                    <form method="post" action="">
					<div class="from-group">
						
                        
						<div class="from-group">
                        <lable>Add City</lable>						
						<input type="text" name="city" class="form-control" placeholder="Enter City">
						</div>
						
					</div>
					
					
					<div id="" class="from-group" style="margin-top:10px">
						<input type="submit" value="submit" class="btn btn-success"  name='submit' class="submit">
					</div>
				</form>				
                    </div>
                </div>

            

            <div style='margin-top: 11px;'>
                <table id="Table_ID" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        <?php foreach($findCity as $key => $val) { 
                            $city_id = $val["city_id"];

                            
                            $i++;
                            ?>
                        <tr>
                            
                            <td><?=$i?></td>
                            <td><?=$val['city_name']?></td>
                            <td><button type="button" onclick="deletcity(<?=$city_id?>)" class="btn btn-danger">Delete</button></td>

                         
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>

            </div>
</div>

        <!-------main content end----->
        <?php include("footer.php"); ?>
    </div>
    <?php include("jslink.php"); ?>
	<?php include("indexjs.php") ?>
</body>
</html>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>



$(document).ready( function () {
    $('#Table_ID').DataTable();
} );

function deletcity(city_id) {

$.ajax({
   method: "POST",
   url: "ajax/delete_city.php",
   data: { city_id: city_id }
}).done(function(response) {
   // $('#TeacherModalres').html(response);
});

swal("Deleted","Deleted successfully","success"); 
}

</script>