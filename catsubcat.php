<section class="advatisement-slider-section">
				<div class="container">
				  <div id="" class="advatisement-title">
					<h1><strong>World Largest Classified Advertisement Portal</strong></h1>
				  </div>
				
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs justify-content-center" role="tablist">
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#home"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/825575 1.png"  border="0" alt=""><br>Buy</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#menu1"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/2405268 1.png" border="0" alt=""><br>Sell</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#menu2"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/2829839 1.png" border="0" alt=""><br>Rent</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#menu3"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/3500874 1.png" border="0" alt=""><br>Job</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#menu4"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/download-removebg-preview 1.png" border="0" alt=""><br>Service</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#menu5"><img src="<?=DOMAIN_NAME_PATH?>/assets/images/1795114 1.png"  border="0" alt=""><br>Events</a>
					</li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
					<div id="home" class="container tab-pane "><br>
					  <div class="menu-content-wrapper">
						<ul>
							<?php $findsubcat = find("all","category","*","where parent_id = 1",array());
							foreach($findsubcat as $key => $val){
							?>
							<li><a href="<?=DOMAIN_NAME_PATH?>/search/All/<?=$val["cat_name"]?>"><?=$val["cat_name"]?></a></li>
							

							<?php } ?>
						</ul>
					  </div>
					</div>
					<div id="menu1" class="container tab-pane fade"><br>
					  <div class="menu-content-wrapper">
						<ul>
						<?php $findsubcat1 = find("all","category","*","where parent_id = 2",array());
							foreach($findsubcat1 as $key => $val){
							?>
							<li><a href="<?=DOMAIN_NAME_PATH?>/search/All/<?=$val["cat_name"]?>"><?=$val["cat_name"]?></a></li>
							

							<?php } ?>
						</ul>
					  </div>
					</div>
					<div id="menu2" class="container tab-pane fade"><br>
					  <div class="menu-content-wrapper">
						<ul>
						<?php $findsubcat2 = find("all","category","*","where parent_id = 3",array());
							foreach($findsubcat2 as $key => $val){
							?>
							<li><a href="<?=DOMAIN_NAME_PATH?>/search/All/<?=$val["cat_name"]?>"><?=$val["cat_name"]?></a></li>
							

							<?php } ?>
						</ul>
					  </div>
					</div>
					<div id="menu3" class="container tab-pane fade"><br>
					 <div class="menu-content-wrapper">
						<ul>
						<?php $findsubcat3 = find("all","category","*","where parent_id = 4",array());
							foreach($findsubcat3 as $key => $val){
							?>
							<li><a href="<?=DOMAIN_NAME_PATH?>/search/All/<?=$val["cat_name"]?>"><?=$val["cat_name"]?></a></li>
							

							<?php } ?>
						</ul>
					  </div>
					</div>
					<div id="menu4" class="container tab-pane fade"><br>
					 <div class="menu-content-wrapper">
						<ul>
						<?php $findsubcat4 = find("all","category","*","where parent_id = 5",array());
							foreach($findsubcat4 as $key => $val){
							?>
							<li><a href="<?=DOMAIN_NAME_PATH?>/search/All/<?=$val["cat_name"]?>"><?=$val["cat_name"]?></a></li>
							

							<?php } ?>
						</ul>
					  </div>
					</div>
					<div id="menu5" class="container tab-pane fade"><br>
					 <div class="menu-content-wrapper">
						<ul>
						<?php $findsubcat5 = find("all","category","*","where parent_id = 6",array());
							foreach($findsubcat5 as $key => $val){
							?>
							<li><a href="<?=DOMAIN_NAME_PATH?>/search/All/<?=$val["cat_name"]?>"><?=$val["cat_name"]?></a></li>
							

							<?php } ?>
						</ul>
					  </div>
					</div>
				  </div>
				</div>
			</section>