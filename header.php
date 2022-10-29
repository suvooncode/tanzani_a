<?php $findcity  = find("all","city","*"," where 1 order by city_name ASC",array()); ?>
<header class="header-area"> 
			<div class="container d-flex justify-content-between align-items-center">
				<div class="logo-area">
					<a href="index"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/logo.png"  border="0" alt=""></a>
				</div>
				<div class="menu-right-area d-flex align-items-center">
					<div class="menu-wrapper">
					<img src="<?=DOMAIN_NAME_PATH?>/assets/images/location.png" border="0" alt="">
						<div class="dropdown">
						  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							<?=(isset($_REQUEST["city_name"]))? $_REQUEST["city_name"] : "Choose Your Location" ?>
						  </button>
						  
						  <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?=DOMAIN_NAME_PATH?>/search">All</a>
							<?php foreach($findcity as $keycity => $valcity){ ?>
							<a class="dropdown-item" href="<?=DOMAIN_NAME_PATH?>/search/<?=$valcity["city_name"]?>"><?=$valcity["city_name"]?></a>
                            <?php } ?>
						
						  </div>
						</div>
					</div>

					<?php
					if(isset($_SESSION["user_id"])){
						?>
						<div class="dropdown">
						  <button type="button" class="btn common-button dropdown-toggle" data-toggle="dropdown">
							<?=$_SESSION["fname"] ?>&nbsp;
						  </button>
						  <div class="dropdown-menu">
							<a class="dropdown-item" href="wishlist.php">Favorites</a>
							<a class="dropdown-item" href="listing.php">Listings</a>
							<a class="dropdown-item" href="logout.php">Logout</a>
						  </div>
						</div>
						<?php
					}else{
						?>
					<button type="button" class="btn common-button" data-toggle="modal" data-target="#exampleModalCenter">Login</button>
                    <button type="button" class="btn common-button" data-toggle="modal" data-target="#exampleModalsingup">Sign Up</button>
						<?php
					}
					?>

					
					<button type="button" onclick="postadd()" class="btn common-button">Post a Add</button>


				</div>
			</div>
		</header>