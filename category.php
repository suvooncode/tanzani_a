<?php
include('init.php');

$findCategory = find('all','category', '*', 'where 1',array());


if(isset($_POST['submit']))
{
      $category = $_POST["category"];
      $subcat = $_POST["subcat"];

	  $city = $_POST["city"];

      

      $fileds= "cat_name,parent_id";
      $values= ":cat_name,:parent_id";
      $exe= array(":cat_name"=>$subcat,":parent_id"=>$category);
      $save= save("category",$fileds,$values,$exe);

	  $fileds1= "loc_id,city_name";
      $values1= ":loc_id,:city_name";
      $exe1= array(":loc_id"=>0,":city_name"=>$city);
      $save1= save("city",$fileds1,$values1,$exe1);
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
		<title>POST A ADD</title>
		<!-- Font Css -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
		<!-- Css Link -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/swiper.css">
		<link href="assets/css/main.css" rel="stylesheet">
		<link href="assets/css/post.css" rel="stylesheet">
		<link href="assets/css/media-queries.css" rel="stylesheet">
		<!-- Js Link -->
		<script src="assets/js/jquery-3.4.1.min.js"></script>
	</head>
	<body class="home">
		<!-- Header area -->
		<header class="post-header">
			<div class="container">
				<a href="" class="back-arrow">
					<svg width="62" height="24" viewBox="0 0 62 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0.43934 10.9393C-0.146447 11.5251 -0.146449 12.4749 0.439338 13.0607L9.98528 22.6066C10.5711 23.1924 11.5208 23.1924 12.1066 22.6066C12.6924 22.0208 12.6924 21.0711 12.1066 20.4853L3.62132 12L12.1066 3.51472C12.6924 2.92893 12.6924 1.97918 12.1066 1.3934C11.5208 0.807611 10.5711 0.807612 9.98528 1.3934L0.43934 10.9393ZM62 10.5L1.5 10.5L1.5 13.5L62 13.5L62 10.5Z" fill="#0A2A73"/>
					</svg>
				</a>
				<div class="text-center">
					<a href=""><img src="assets/images/logo.png"  border="0" alt=""></a>
				</div>				
			</div>
		</header>
		<!-- End::Header area -->
		<main>
			<section class="post-form-section">
				<!-- <div class="post-form-title">
					<svg width="151" height="1" viewBox="0 0 151 1" fill="none" xmlns="http://www.w3.org/2000/svg">
						<line y1="0.5" x2="151" y2="0.5" stroke="#0A2A73"/>
					</svg>
					<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="12.5" cy="12.5" r="12.5" fill="#0A2A73"/>
					</svg>
					<span class="p-f-title">Post Your Add</span>
					<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="12.5" cy="12.5" r="12.5" fill="#0A2A73"/>
					</svg>
					<svg width="151" height="1" viewBox="0 0 151 1" fill="none" xmlns="http://www.w3.org/2000/svg">
						<line y1="0.5" x2="151" y2="0.5" stroke="#0A2A73"/>
					</svg>
				</div> -->
				<form method="post" action="">
					<div class="from-box">
						<select name="category" class="each-field">
                        <option value="" selected>Select Your Category</option>

                        <?php foreach ($findCategory as $key => $val) { ?>
                            <option value="<?php echo $val["cat_id"]; ?>"><?php echo $val["cat_name"]; ?></option>
                        <?php }?>
						</select>
						<div class="from-box">						
						<label>Sub Category</label>	
						<input type="text" name="subcat" class="each-field" placeholder="sub category" >
						</div>
						<div class="from-box">						
						<label>City</label>	
						<input type="text" name="city" class="each-field" placeholder="Enter City">
						</div>
					</div>
					
					
					<div id="" class="text-right">
						<input type="submit" value="submit" onclick="addtest()" name='submit' class="submit">
					</div>
				</form>					
			</section>			
		</main>
		<!-- Footer area -->
		
		<!-- End::Footer area -->
		<!-- All js links -->
		
	</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" ></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>



<script>
 function addtest(){
    swal({
			  title: "Subcategory Added",
			  text: data["message"],
			  icon: data["action_status"],
			  button: "Done!",
			});

 }    

</script>