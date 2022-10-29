<?php include("init.php");

$params = explode( "/", $_GET['post'] );
//print_r($params);
$post_id= $_REQUEST["post"];
$searchText = " p.post_id='".$post_id."' ";
$post= find("first", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","*"," where $searchText ORDER BY p.post_id DESC ",array());

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
		<title><?=$post["post_title"]?></title>
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
			<section class="realeaste-slider-section">
				<div class="container">
					<div class="details-slider-wrapper">
						<div class="swiper-container">
							<div class="swiper-wrapper">
							  <div class="swiper-slide">
								<div class="each-slider-wrapper">
									<img src="<?=DOMAIN_NAME_PATH?>/uploads/<?=$post["photo_url"]?>" border="0" alt="" STYLE="HEIGHT:70vh;" class="w-100">
								</div>
							  </div>
							  <div class="swiper-slide">
								<div class="each-slider-wrapper">
									<img src="<?=DOMAIN_NAME_PATH?>/assets/images/details-banner-1.png" border="0" STYLE="HEIGHT:70vh;" alt="" class="w-100">
								</div>
							  </div>
							</div>
						</div>
						<!-- Add Arrows -->
						<div class="swiper-button-next common-arrow"><img src="assets/images/Vector (1).png" border="0" alt=""></div>
						<div class="swiper-button-prev common-arrow"><img src="assets/images/Vector.png" border="0" alt=""></div>
					</div>
				</div>
			</section>
			<section class="details-content">
				<div class="container">
					<div class="details-content-heading">
						<div class="row align-items-center">
							<div class="col-lg-9">
								<div class="details-heading-left d-flex align-items-center justify-content-between">
									<h1><?=$post["post_title"]?></h1>
									<img src="<?=DOMAIN_NAME_PATH?>/assets/images/star.png" border="0" alt="">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="details-right-button text-center">
									<a href="" class="btn common-button">$ <?=$post["prize"]?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="details-content-bottom">
						<div class="row">
							<div class="col-lg-9">
								<div class="details-content-area">
									<h2>Overview</h2>
									<p>
										<?=$post["discription"]?>
										<!-- <li>ALL ORIGINAL CAR IN BRAND NEW CONDITION AVAILABLE AT SKS CARS JALANDHAR price fixed</li>
										<li>ADDITIONAL VEHICLE INFORMATION:</li>
										<li>ABS: Yes</li>
										<li>Accidental: No</li>
										<li>Adjustable External Mirror: Power</li>
										<li>Adjustable Steering: Yes</li>
										<li>Air Conditioning: Automatic Climate Control</li>
										<li>Number of Airbags: 8 airbags</li>
										<li>Alloy Wheels: Yes</li>
										<li>Anti Theft Device: Yes</li>
										<li>Aux Compatibility: Yes</li>
										<li>Battery Condition: New</li> -->

									</p>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="details-content-right ml-auto mr-auto">
									<div class="details-content-right-top">
										<ul>
											<li><img src="<?=DOMAIN_NAME_PATH?>/assets/images/clock.png" border="0" alt="">2 Days Ago</li>
											<li><img src="<?=DOMAIN_NAME_PATH?>/assets/images/pin.png" border="0" alt=""><?=$post["city_name"]?>, India</li>
										</ul>
									</div>
									<h3>Contact With Seller</h3>
									<div class="details-content-right-bottom">
										<ul>
											<li><img src="assets/images/call.png" border="0" alt="">XXXXX XXX XXXX</li>
											<li><img src="assets/images/mail.png" border="0" alt="">RoXXXXXXXXXX</li>
										</ul>
									</div>
									<div class="view-more-button text-center" data-toggle="modal" data-target="#datamodal">
										<a href="#">View More</a>
									</div>
								</div>
							</div>
						</div>
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
		<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2>LOGIN</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<input type="name" class="form-control input-style" placeholder="Username or mailid"/>
							</div>
							<div class="form-group">
								 <button type="button" class="btn common-button">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="datamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2>Details data</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<input type="name" class="form-control input-style" placeholder="Name"/>
							</div>
							<div class="form-group">
								<input type="email" class="form-control input-style" placeholder="Email"/>
							</div>
							<div class="form-group">
								<input type="number" class="form-control input-style" placeholder="Phone"/>
							</div>
							<div class="form-group">
								 <button type="button" class="btn common-button">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php include("loginregmodal.php"); ?>	
		<!-- End::Footer area -->
		<!-- All js links -->
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/swiper.min.js"></script>
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/custom.js"></script>

		<script>
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
	</body>
</html>