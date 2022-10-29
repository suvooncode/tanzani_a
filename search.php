<?php include("init.php");


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'Year',
        'm' => 'Month',
        'w' => 'Week',
        'd' => 'Day',
        'h' => 'Hour',
        'i' => 'Minute',
        's' => 'Second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' Ago' : 'Just Now';
}



$searchText = " 1 ";

	if(isset($_REQUEST["searchtext"]))
	{
		$search = $_REQUEST["searchtext"];

		$searchText= "  p.post_title like '%$search%' or p.discription like '%$search%' or c.cat_name '%$search%' or ci.city_name like '%$search%'  ";

		$searchText="concat_ws(' ',p.post_title,p.discription,c.cat_name,ci.city_name ) like '%".$search."%' ";


	}

	

	if(isset($_REQUEST["city_name"]))
	{
		if($_REQUEST["city_name"]!="")
		{
			$searchcity = $_REQUEST["city_name"];

			$searchText .= " and ci.city_name like '%$searchcity%'";

		}
	}
	if(isset($_REQUEST["cat_name"]))
		{
			if($_REQUEST["cat_name"]!="")
			{
				$cat_name = $_REQUEST["cat_name"];

				$searchText .= " and c.cat_name like '%$cat_name%'";

			}
		}
	$page= 1;
	if(isset($_GET["page"]))
	{
		$page = $_GET["page"];
	}
	$start = ($page-1) * 10;

	$post= find("all", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","*"," where $searchText and p.status='Y' ORDER BY p.post_id DESC LIMIT  $start , 10",array());


 





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
		<title>Search : <?=$_REQUEST["searchtext"]?></title>
		<!-- Font Css -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
		<!-- Css Link -->
		<link href="<?=DOMAIN_NAME_PATH?>/assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=DOMAIN_NAME_PATH?>/assets/css/swiper.css">
		<link href="<?=DOMAIN_NAME_PATH?>/assets/css/main.css" rel="stylesheet">
		<link href="<?=DOMAIN_NAME_PATH?>/assets/css/media-queries.css" rel="stylesheet">
		<!-- Js Link -->
		
	</head>
	<body class="home">
		<!-- Header area -->
		<?php include("header.php"); ?>
		<!-- End::Header area -->
		<main>
			<section class="advatisement-slider-section search-page">
				<div class="container-fluid pl-0">
				<div id="" class="row">
					<div id="" class="col-lg-3">
						<div class="search-wrapper">
							<h4>Showing Results For :</h4>
							<h2>Buy Cars</h2>
						</div>
						<div class="filter-title">Filters</div>
						<div class="filter-content">
							<h2>Price</h2>
							<form>
								<div class="form-check mb-2">
									<input type="checkbox" class="form-check-input" id="exampleCheck1">
									<label class="form-check-label" for="exampleCheck1">Posted Today</label>
								</div>
								<div class="form-check mb-2">
									<input type="checkbox" class="form-check-input" id="exampleCheck1">
									<label class="form-check-label" for="exampleCheck1">Search Titles only</label>
								</div>
							</form>
						</div>
					</div>
					<div id="" class="col-lg-9">
						<!-- Nav tabs -->
						
						<!-- Tab panes -->
						<?php include("catsubcat.php"); ?> 
						<div class="searchbar">
							
							<div class="input-group">
								<input type="text" id="searchtext" name="searchtext" value="<?=(isset($_REQUEST["searchtext"]))? $_REQUEST["searchtext"] : ""?>" class="form-control" placeholder="Search Cars, Real Estate, Jobs etc.">
								<div class="input-group-append">
									<button class="btn btn-secondary" type="submit" name="searchnow" onclick="searchnow()">
									<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
							
						</div>
						<div id="product_list" class="product-wrapper">

						<?php
						if($post)
						{
						foreach($post as $key=>$val){
							$ago = time_elapsed_string($val["post_date"], $full = false);
							?>
							<div class="row">
								<div class="col-lg-4">
									<div id="" class="car-wrapper">
										<?php if($val["photo_url"] !="") {?>
										
										<img src="<?=DOMAIN_NAME_PATH?>/uploads/<?=$val["photo_url"]?>" class="mw-100" border="0" alt="">
										<?php }else
										{
											?>
											<img src="<?=DOMAIN_NAME_PATH?>/assets/images/logo.png" class="mw-100" border="0" alt="">
											<?php
										} ?>
									</div>
								</div>
								<div class="col-lg-8">
									<div id="" class="car-content-wrapper">
										<a href="<?=DOMAIN_NAME_PATH?>/details/<?=$val['post_id']?>"><h2><?=$val["post_title"]?></h2></a>
										<img class="star-img" src="<?=DOMAIN_NAME_PATH?>/assets/images/star.png"  border="0" alt="">
										<p><?=$val["discription"]?></p>
										<div id="" class="price">
											$<?=$val["prize"]?>
										</div>
										<ul>
											<li><?=$val["city_name"]?>, India</li>
											<li><img src="<?=DOMAIN_NAME_PATH?>/assets/images/clock.png" width="22" height="23" border="0" alt="">&nbsp;<?=$ago?> </li>
										</ul>
									</div>
								</div>
							</div>
							<hr></hr>
							<?php } }else{
								?>
								<div class="row">
								<div class="col-lg-4">
									
								</div>
								<div class="col-lg-8">
									<img src="<?=DOMAIN_NAME_PATH?>/assets/images/notfound.gif" style=""/></br>
									Nothing found for now!
								</div>
							</div>
								<?php

							} ?>
							
							
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
		<?php include("loginregmodal.php"); ?> 
		<!-- End::Footer area -->
		<!-- All js links -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/swiper.min.js"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?=DOMAIN_NAME_PATH?>/assets/js/custom.js"></script>
		<?php include("common.php"); ?>
		
		<script>
			function searchnow()
			{var searchtext= $("#searchtext").val();
				$.post( "<?=DOMAIN_NAME_PATH?>/ajax/ajaxpost.php",{ searchtext : searchtext}, function( res ) {
					console.log(res);
						$("#product_list").html(res);
						});
				
				
			}
			</script>

	</body>
</html>