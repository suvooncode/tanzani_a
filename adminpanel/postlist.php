<?php   
include('init.php');

$findpost = find('all','post', '*', 'where 1 order by post_id desc',array());


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <title>Tanzania || Postlist || Admin </title>
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
                            <th>Post</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Post Date</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        <?php foreach($findpost as $key => $val) { 
                            $post_id = $val["post_id"];
                            $i++;
                            ?>
                        <tr>
                            
                            <td><?=$i?></td>
                            <td>
                                <img src="../uploads/<?=$val['photo_url']?>" style='width:100px;'> 
                                <?=$val['post_title']?></td>
                            <td><?=$val['discription']?></td>
                            <td><?=$val['prize']?></td>
                            <td><?=$val['post_date']?></td>
                            <td>
                                
                                <button type="button" onclick="deletpost(<?=$post_id?>)" class="btn btn-danger">Delete</button>
                               
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

function deletpost(post_id) {
 var confirmtxt = confirm("Do you want to delete?");
 if(confirmtext)
 {
    $.ajax({
        method: "POST",
        url: "ajax/delete_post.php",
        data: { post_id: post_id }
        }).done(function(response) {
        // $('#TeacherModalres').html(response);
        window.location.reload(true);
    });

    swal("Deleted","Deleted successfully","success"); 
 }

}

$(document).ready( function () {
    $('#Table_ID').DataTable();
} );



</script>