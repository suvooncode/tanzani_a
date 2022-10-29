<?php   
include('init.php');



if(isset($_POST['update']))
{
    
    
    $userid = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email']; $phone = $_POST['phone'];

    $update = update('user','fullname=:fullname,user_name=:user_name,phone_number=:phone_number','where user_id="'.$userid.'" ',array(':fullname'=>$name,':user_name'=>$email,':phone_number'=>$phone));
    
}

$finduser = find('all','user', '*', 'where 1',array());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <title>Tanzania || User || Admin </title>
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
                    
                    </div>
                </div>

            

            <div style='margin-top: 11px;'>
                <table id="Table_ID" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>User name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Password</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        <?php foreach($finduser as $key => $val) { 
                            $user_id = $val["user_id"];
                            $i++;
                            ?>
                        <tr>
                            
                            <td><?=$i?></td>
                            <td><?=$val['fullname']?></td>
                            <td><?=$val['user_name']?></td>
                            <td><?=$val['phone_number']?></td>
                            <td><?=$val['password']?></td>
                            <td>
                                <?php if($val["is_admin"]=="N"){ ?>
                                <button type="button" onclick="deletuser(<?=$user_id?>)" class="btn btn-danger">Delete</button>

                                <button type="button" onclick="edituser(<?=$user_id?>)" class="btn btn-danger">Edit</button>
                                <?php } ?>
                                <?php if($val["is_admin"]=="Y"){ ?>
                                <button   class="p-1 btn-secondary" style="color:white">Not Allowed</button>
                                <?php } ?>
                            </td>

                         
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>

            </div>
</div>


<!--------Modal------->
<div class="modal fade common-modal" id="exampleModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
            <div class="modal-header" style="border:none">
                <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
				<div class="modal-content-wrapper">
					<strong style="color:green;"><?=$response?></strong>
					<form action="" method="POST" style="width:95%;margin-left:5%">
                        <div class="form-group ">
                            <input type="hidden" id='userid' name="userid" class="form-control-plaintext">
							<label for="staticEmail" >Name</label>
							
								<input type="text" id='name' name="name" class="form-control-plaintext">
							
						</div>
                        <div class="form-group ">
                            
							<label for="staticEmail" >Phone no</label>
								<input type="number" id='phone' name="phone" class="form-control-plaintext">
						</div>
						<div class="form-group ">
							<label for="staticEmail" >Email</label>
							
								<input type="email" id='email' name="email" class="form-control-plaintext">
							
						</div>
						
						<div class="form-group  mb-3">
							<div class="col-sm-12 text-right submit-button">
								<button class='btn btn-primary' type="submit" id='update' name="update" >Update</button>
							</div>
						</div>
					</form>
				</div>
				
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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>

function deletuser(user_id) {

$.ajax({
   method: "POST",
   url: "ajax/delete_user.php",
   data: { user_id: user_id }
}).done(function(response) {
   // $('#TeacherModalres').html(response);
});

swal("Deleted","Deleted successfully","success"); 
}

$(document).ready( function () {
    $('#Table_ID').DataTable();
} );

function edituser(user_id)
{
    $('#exampleModalCenter').modal('show');
    $('#userid').val(user_id);

    $.ajax({
        url:"ajax/get_user.php",
        method:"POST",
        data:{userid:user_id}
    }).done(function(response){
        var data = JSON.parse(response);
        console.log(data['name']);
        $('#name').val(data['name']); $('#email').val(data['email']);$('#phone').val(data['phone']);
        $('#exampleModalCenter').modal('show');
        
    });
}



</script>