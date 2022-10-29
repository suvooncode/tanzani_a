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

$user_id= $_SESSION["user_id"];

$opentab = "all";
if(isset($_REQUEST["opentab"]))
{
    $opentab = $_REQUEST["opentab"];
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

	$post= find("all", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","* , p.status as p_status"," where $searchText  and p.user_id='".$user_id."' ORDER BY p.post_id DESC LIMIT  $start , 10",array());

    $postactive= find("all", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","* , p.status as p_status"," where $searchText and p.status='Y'  and p.user_id='".$user_id."' ORDER BY p.post_id DESC LIMIT  $start , 10",array());

    $postpause= find("all", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","* , p.status as p_status"," where $searchText and p.status='N'  and p.user_id='".$user_id."' ORDER BY p.post_id DESC LIMIT  $start , 10",array());

    $postclose= find("all", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","* , p.status as p_status"," where $searchText and p.status='C'  and p.user_id='".$user_id."' ORDER BY p.post_id DESC LIMIT  $start , 10",array());


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
		<title>My Listing</title>
		<!-- Font Css -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
		<!-- Css Link -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/swiper.css">
		<link href="assets/css/main.css" rel="stylesheet">
		<link href="assets/css/media-queries.css" rel="stylesheet">
		<!-- Js Link -->
		
	</head>
	<body class="home">
		<!-- Header area -->
		<?php include("header.php"); ?>
		<!-- End::Header area -->
		<main>
			<section class="advatisement-slider-section search-page">
				<div class="container">
				<div id="" class="row">
					
					<div id="" class="col-lg-12">
						<!-- Nav tabs -->
                        <?php include("catsubcat.php"); ?>
						<!-- Tab panes -->
						
						
						
						<div id="" class="product-wrapper listing-post-wrapper">
							<div id="" class="row">
								<div id="" class="col-lg-4">
									<h2>My Listings</h2>
								</div>
								<div id="" class="col-lg-8">
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
										  <a class="nav-link <?=(($opentab=="all")? 'active' : '')?>" data-toggle="tab" href="#all">All</a>
										</li>
										<li class="nav-item">
										  <a class="nav-link <?=(($opentab=="active")? 'active' : '')?>" data-toggle="tab" href="#active">Active </a>
										</li>
										<li class="nav-item">
										  <a class="nav-link <?=(($opentab=="pause")? 'active' : '')?>" data-toggle="tab" href="#pause">Pause</a>
										</li>
										<li class="nav-item">
										  <a class="nav-link <?=(($opentab=="close")? 'active' : '')?>" data-toggle="tab" href="#closed">Closed</a>
										</li>
									</ul>
								</div>
							</div>
							<br>

							  <!-- Tab panes -->
							  <div class="tab-content">
								<div id="all" class="container tab-pane active">
                                <?php foreach($post as $key=>$val){ ?>
								<div class="row">
								<div class="col-lg-4">
									<div id="" class="car-wrapper">
										<img src="uploads/<?=$val["photo_url"]?>" class="mw-100" border="0" alt="">
									</div>
								</div>
								<div class="col-lg-6">
									<div id="" class="car-content-wrapper">
										<h2><?=$val["post_title"]?></h2>
										
										<p><?=$val["discription"]?></p>
										<div id="" class="price">
											$<?=$val["prize"]?>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div id="" class="icon-wrapper">
										<a href=""><img src="assets/images/pen.png"  border="0" alt=""></a>
										<a href=""><img src="assets/images/del.png"  border="0" alt=""></a>
										<br><br>
										<div class="dropdown">
										  <select  class="btn common-button dropdown-toggle" data-toggle="dropdown" onchange="changestatus(this.value , <?=$val['post_id']?>)">
                                                <option value="Y" <?=($val["p_status"]=="Y")? "selected":""?>>Active</option>
                                                <option value="N" <?=($val["p_status"]=="N")? "selected":""?> >Pause</option>
                                                <option value="C" <?=($val["p_status"]=="C")? "selected":""?> >Close</option>
                                            </select>
										  
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div id="" class="col-lg-4"></div>
								<div id="" class="col-lg-8">
									<div id="" class="car-content-wrapper">
										<ul>
											<li><?=$val["city_name"]?>, India</li>
											<li><img src="assets/images/clock.png" width="22" height="23" border="0" alt="">&nbsp;2 Days Ago</li>
										</ul>
									</div>
								</div>
							</div>
                            <hr></hr>
                            <?php } ?>
							
							
							
								</div>
							<div id="active" class="container tab-pane fade">

                            <?php foreach($postactive as $key=>$val){ ?>
								<div class="row">
								<div class="col-lg-4">
									<div id="" class="car-wrapper">
										<img src="uploads/<?=$val["photo_url"]?>" class="mw-100" border="0" alt="">
									</div>
								</div>
								<div class="col-lg-6">
									<div id="" class="car-content-wrapper">
										<h2><?=$val["post_title"]?></h2>
										
										<p><?=$val["discription"]?></p>
										<div id="" class="price">
											$<?=$val["prize"]?>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div id="" class="icon-wrapper">
										<a href=""><img src="assets/images/pen.png"  border="0" alt=""></a>
										<a href=""><img src="assets/images/del.png"  border="0" alt=""></a>
										<br><br>
										<div class="dropdown">
										  <select  class="btn common-button dropdown-toggle" data-toggle="dropdown" onchange="changestatus(this.value , <?=$val['post_id']?>)">
                                                <option value="Y" <?=($val["p_status"]=="Y")? "selected":""?>>Active</option>
                                                <option value="N" <?=($val["p_status"]=="N")? "selected":""?> >Pause</option>
                                                <option value="C" <?=($val["p_status"]=="C")? "selected":""?> >Close</option>
                                            </select>
										  
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div id="" class="col-lg-4"></div>
								<div id="" class="col-lg-8">
									<div id="" class="car-content-wrapper">
										<ul>
											<li><?=$val["city_name"]?>, India</li>
											<li><img src="assets/images/clock.png" width="22" height="23" border="0" alt="">&nbsp;2 Days Ago</li>
										</ul>
									</div>
								</div>
							</div>
                            <hr></hr>
                            <?php } ?>
									
							
							
							
							</div>
							<div id="pause" class="container tab-pane fade">

                            <?php foreach($postpause as $key=>$val){ ?>
								<div class="row">
								<div class="col-lg-4">
									<div id="" class="car-wrapper">
										<img src="uploads/<?=$val["photo_url"]?>" class="mw-100" border="0" alt="">
									</div>
								</div>
								<div class="col-lg-6">
									<div id="" class="car-content-wrapper">
										<h2><?=$val["post_title"]?></h2>
										
										<p><?=$val["discription"]?></p>
										<div id="" class="price">
											$<?=$val["prize"]?>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div id="" class="icon-wrapper">
										<a href=""><img src="assets/images/pen.png"  border="0" alt=""></a>
										<a href=""><img src="assets/images/del.png"  border="0" alt=""></a>
										<br><br>
										<div class="dropdown">
										  <select  class="btn common-button dropdown-toggle" data-toggle="dropdown" onchange="changestatus(this.value , <?=$val['post_id']?>)">
                                                <option value="Y" <?=($val["p_status"]=="Y")? "selected":""?>>Active</option>
                                                <option value="N" <?=($val["p_status"]=="N")? "selected":""?> >Pause</option>
                                                <option value="C" <?=($val["p_status"]=="C")? "selected":""?> >Close</option>
                                            </select>
										  
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div id="" class="col-lg-4"></div>
								<div id="" class="col-lg-8">
									<div id="" class="car-content-wrapper">
										<ul>
											<li><?=$val["city_name"]?>, India</li>
											<li><img src="assets/images/clock.png" width="22" height="23" border="0" alt="">&nbsp;2 Days Ago</li>
										</ul>
									</div>
								</div>
							</div>
                            <hr></hr>
                            <?php } ?>
								
							
							
							
							</div>
							<div id="closed" class="container tab-pane fade">

                            <?php foreach($postclose as $key=>$val){ ?>
								<div class="row">
								<div class="col-lg-4">
									<div id="" class="car-wrapper">
										<img src="uploads/<?=$val["photo_url"]?>" class="mw-100" border="0" alt="">
									</div>
								</div>
								<div class="col-lg-6">
									<div id="" class="car-content-wrapper">
										<h2><?=$val["post_title"]?></h2>
										
										<p><?=$val["discription"]?></p>
										<div id="" class="price">
											$<?=$val["prize"]?>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div id="" class="icon-wrapper">
										<a href=""><img src="assets/images/pen.png"  border="0" alt=""></a>
										<a href=""><img src="assets/images/del.png"  border="0" alt=""></a>
										<br><br>
										<div class="dropdown">
										  <select  class="btn common-button dropdown-toggle" data-toggle="dropdown" onchange="changestatus(this.value , <?=$val['post_id']?>)">
											    <option value="Y" <?=($val["p_status"]=="Y")? "selected":""?>>Active</option>
                                                <option value="N" <?=($val["p_status"]=="N")? "selected":""?> >Pause</option>
                                                <option value="C" <?=($val["p_status"]=="C")? "selected":""?> >Close</option>
                                            </select>
										  
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div id="" class="col-lg-4"></div>
								<div id="" class="col-lg-8">
									<div id="" class="car-content-wrapper">
										<ul>
											<li><?=$val["city_name"]?>, India</li>
											<li><img src="assets/images/clock.png" width="22" height="23" border="0" alt="">&nbsp;2 Days Ago</li>
										</ul>
									</div>
								</div>
							</div>
                            <hr></hr>
                            <?php } ?>
								
							
							
							
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
		<!-- End::Footer area -->
		<!-- All js links -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" ></script>
		<script src="assets/js/swiper.min.js"></script>
		
		
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" ></script> -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/custom.js"></script>
        <?php include("common.php"); ?>
        <script>
            function changestatus(str , post_id )
            {
                $.ajax({
                url: "ajaxchangestatus.php",
                dataType: "json",
                type: "Post",
                async: true,
                data: { chnstatus: str ,post_id:post_id },
                success: function (data) {
                    swal("Change Status", "Successfully changed", "success");
                },
                error: function (xhr, exception) {
                    
                }
            });
            }
            </script>
	</body>
</html>