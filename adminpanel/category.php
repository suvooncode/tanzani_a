<?php   
include('init.php');




if(isset($_POST['submit']))
{
      $category = $_POST["category"];
      $subcat = $_POST["subcat"];


      

      $fileds= "cat_name,parent_id";
      $values= ":cat_name,:parent_id";
      $exe= array(":cat_name"=>$subcat,":parent_id"=>$category);
      $save= save("category",$fileds,$values,$exe);

	
}
$findCategory = find('all','category', '*', 'where 1 order by cat_id desc',array());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <title>Tanzania || Category || Admin </title>
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
					<div class="from-box">
						<select name="category" class="form-control">
                        <option value="" selected>Select Your Category</option>

                        <?php foreach ($findCategory as $key => $val) { ?>
                            <option value="<?php echo $val["cat_id"]; ?>"><?php echo $val["cat_name"]; ?></option>
                        <?php }?>
						</select>
                        
						<div class="from-group">						
						<input type="text" name="subcat" class="form-control" placeholder=" Enter Sub Category" >
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
                            <th>Category</th>
                            <th>Parent </th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        <?php foreach($findCategory as $key => $val) { 
                            $cat_id = $val["cat_id"];
                            $parentcategory = '<label  class="p-1 btn-info" >Parent</label>';
                            if($val["parent_id"]!="0")
                            {
                                $parent_id= $val["parent_id"];
                                $findparent = find("first","category","cat_name","where cat_id='".$parent_id."'",array());
                                $parentcategory =  $findparent["cat_name"];
                            }


                            $i++;
                            ?>
                        <tr>
                            
                            <td>#<?=$i?></td>
                            <td><?=$val['cat_name']?></td>
                            <td><?=$parentcategory?></td>
                            <td>
                                <?php if($val["parent_id"]!="0")
                            { ?>
                                <button type="button" onclick="deletcat(<?=$cat_id?>)" class="btn btn-danger">Delete</button>
                                <?php } else {
                                    {
                                        ?>
                                <label type="button"  class="p-1 btn-secondary" >Not Allowed</label>
                                        <?php
                                    }
                                } ?>
                            </td>

                         
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

function deletcat(cat_id) {

$.ajax({
   method: "POST",
   url: "ajax/delete_category.php",
   data: { cat_id: cat_id }
}).done(function(response) {
   // $('#TeacherModalres').html(response);
});

swal("Deleted","Deleted successfully","success"); 
}




$(document).ready( function () {
    $('#Table_ID').DataTable();
} );



</script>