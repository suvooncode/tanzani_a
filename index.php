<?php 
include('init.php');



if(isset($_POST["login"]))
 {
    $email = $_POST["email"];
    $password= $_POST["password"];
    $response= "This credential is not found";
    $response_status = "error";

    $find= find("all","user","*"," where user_name='$email' and password='$password' ",array());
	//$findadmin= find("all","user","*"," where user_name='$email' and password='$password' and is_admin='Y'",array());

    if($find)
    {
        $finduser=  find("first","user","*"," where user_name='$email' and password='$password' ",array());

        $_SESSION["user_id"]=$finduser["user_id"];
        $_SESSION["email"]=$finduser["user_name"];
		$_SESSION["fullname"]=$finduser["fullname"];
		
		$fname = substr($_SESSION["fullname"], 0, 1);
		$_SESSION["fname"]=$fname;
		
		$_SESSION["status_diff"]="success";
		$_SESSION["text_diff"]="You have logged in successfully";
		$_SESSION["title_diff"]="Welcome";
	  
       if($finduser["is_admin"]=="N")
	   {
		redirectfn("postadd.php");
	   }
	   if($finduser["is_admin"]=="Y")
	   {
		redirectfn("adminpanel/category.php");
	   }
        
        $response= "Welcome to tanzania";
        $response_status = "success";
    }
	
	else{
		$_SESSION["status_diff"]="error";
		$_SESSION["text_diff"]="Provided credential is wrong";
		$_SESSION["title_diff"]="Login Failed";
    }
}
$regstatus= "0";

if(isset($_POST["submitreg"]))
 {
	$email = $_POST["email"];
	$password= $_POST["password"];
	$phone_no=$_POST["number"];
	$fullname=$_POST["fullname"];

	$fileds= "user_name,phone_number,fullname,password";
	$values= ":user_name,:phone_number,:fullname,:password";
	$exe= array(":user_name"=>$email,":phone_number"=>$phone_no,":fullname"=>$fullname,":password"=>$password);

	$checkuser = find("first","user","*","where user_name ='$email' or phone_number = $phone_no",array());

	if($checkuser){
		$regstatus="2";
	}else{
		$save= save("user",$fileds,$values,$exe);
		$regstatus="1";

	}


	

	if($save)
	{
		
	}

	



    

 }

?>


<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="Generator" content="EditPlus®">
		<meta name="Author" content="">
		<meta name="Keywords" content="">
		<meta name="Description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home </title>
		<!-- Font Css -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
		<!-- Css Link -->
		<link href="<?=DOMAIN_NAME_PATH?>/assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=DOMAIN_NAME_PATH?>/assets/css/swiper.css">
		<link href="<?=DOMAIN_NAME_PATH?>/assets/css/main.css" rel="stylesheet">
		<link href="<?=DOMAIN_NAME_PATH?>/assets/css/media-queries.css" rel="stylesheet">
		<!-- Js Link -->
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/jquery-3.4.1.min.js"></script>
	</head>
	<body class="home">
		<!-- Header area -->
		<?php include("header.php"); ?>
		<!-- End::Header area -->
		<main>
			<?php include("catsubcat.php"); ?>
			<section class="realeaste-slider-section">
				<div class="container">
					<div class="realeaste-slider-wrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
							  <div class="swiper-slide">
								<div class="each-slider-wrapper common-background-style" style="background:url('assets/images/House-Image.jpg')">
									<div class="banner-tag">Real Estate</div>
								</div>
							  </div>
							  <div class="swiper-slide">
								<div class="each-slider-wrapper common-background-style" style="background:url('assets/images/House-Image.jpg')">
									<div class="banner-tag">Sports</div>
								</div>
							  </div>
							</div>
						</div>
						<!-- Add Arrows -->
						<div class="swiper-button-next"><img src="assets/images/Vector (4).png" width="33" height="40" border="0" alt=""></div>
						<div class="swiper-button-prev"><img src="assets/images/Vector (2).png" width="33" height="38" border="0" alt=""></div>
					</div>
				</div>
			</section>
		</main>
		<!-- Footer area -->
		<footer class="footer-area">
			<div class="container footer-wrapper">
				<div class="row">
					<div class="col-lg-4">
						<div class="copyright-text">
							 Copyright All right reserved @ Tanzania 
						</div>
					</div>
					<div class="col-lg-8">
						<div  class="footer-menu">
							<ul>
								<li><a href="">Help Us</a></li>
								<li><a href="">Safety</a></li>
								<li><a href="">Privacy Policy</a></li>
								<li><a href="">Feedback</a></li>
								<li><a href="">Terms & Condition </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>


		</footer>

		<!-- Modal -->
		<?php include("loginregmodal.php"); ?>
		<!-- All js links -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/swiper.min.js"></script>
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/custom.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script>


		$(function(){
			<?php if($regstatus=="1"){ ?>
			swal("Registration", "You have successfully registered", "success");
			<?php } ?>
			<?php if($regstatus=="2"){ ?>
			swal("Registration", "This email is already registered", "warning");
			<?php } ?>
		});

		function login_modal_hide()
		{
			$('.login-modal').modal('hide');
			
		}
		function closemodal()
		{
			
			$(".modal-backdrop").css("display", "none");
			//$(".modal-backdrop").removeClass("show");
		}
		</script>

		<script>
			$( document ).ready(function() {

				$('#change_password').click(function(){
				
				var forgot_email = $('#forgot_email').val();

				$.ajax({
					url:"ajax/forgot_password.php",
					method:"POST",
					data:{forgot_email:forgot_email}
				}).done(function(response){
					
					$('#exampleModalCenter3').modal('hide');
					swal("","Password updated successfully. Kindly check your mail","success");
				});
			})
			
		});

		function postadd(){
			<?php 
			if(isset($_SESSION["user_id"])){
				?>
				window.location.href = "postadd.php";
				<?php
			}else{
				?>
				$('#exampleModalCenter').modal('show');
				<?php
			}
				?>
		}
		</script>
		<?php include("common.php"); ?>
	</body>
</html>