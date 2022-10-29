<?php include("../init.php");

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

    $page= 1;
	if(isset($_GET["page"]))
	{
		$page = $_GET["page"];
	}
	$start = ($page-1) * 10;

	$post= find("all", "post as p inner join category as c on c.cat_id= p.cat_id inner join city as ci on p.city_id=ci.city_id ","*"," where $searchText and p.status='Y' ORDER BY p.post_id DESC LIMIT  $start , 10",array());


}

?>

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