<?php 
include('init.php');
if(isset($_SESSION['user_id']))
{

}else{
	redirectfn('index.php');
}

$findcat = find('all','category','*','where parent_id = 0',array());
$findcity = find('all','city','*','where 1',array());

if(isset($_REQUEST['cat_id'])){
	$cat_id = $_REQUEST['cat_id'];
	$sub_cat = find('all','category','*','where parent_id = '.$cat_id.'',array());
}

if(isset($_POST['submit']))
{
	// print_r( $_FILES);
	// exit();
    //   $category = $_POST["cat_id"];
      $subcat = $_POST["sub_cat_id"];
	  $specification = $_POST["specification"];
	  $title = $_POST["title"];
      $description = $_POST["description"];
	  $price = $_POST["price"];
	  $city = $_POST["city"];

	  $date = date('Y-m-d');





	  $target_dir = "uploads/";
	    $filename = $_FILES["fileToUpload"]["name"][0];
        $target_file = $target_dir . basename($filename);
	    $file_type = $_FILES['fileToUpload']['type'][0];
	    
	   
    	    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'][0], $target_file)){
    	         $attachment = $filename;
            }
            else {
                echo "Problem uploading file";
            }
	    

      $fileds= "post_title,discription,prize,tag,specification,cat_id,post_date,loc_id,user_id,city_id,photo_url";
      $values= ":post_title,:discription,:prize,:tag,:specification,:cat_id,:post_date,:loc_id,:user_id,:city_id,:photo_url";
      $exe= array(":post_title"=>$title,":discription"=>$description,":prize"=>$price,":tag"=>"null",":specification"=>$specification,":cat_id"=>$subcat,":post_date"=>$date,":loc_id"=>0,":user_id"=>$_SESSION['user_id'],":city_id"=>$city,":photo_url"=>$attachment);
      $save= save("post",$fileds,$values,$exe);
	  if($save)
	  {
		$_SESSION["status_diff"]="success";
		$_SESSION["text_diff"]="Post has been added";
		$_SESSION["title_diff"]="success";
		redirectfn("search.php");
	  }
	  else
	  {
		$_SESSION["status_diff"]="error";
		$_SESSION["text_diff"]="Something went wrong, try again.";
		$_SESSION["title_diff"]="Failed Action!";
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
				<!-- <a href="javascript:void(0)" onclick="goBack()" class="back-arrow"> -->
				<a href="index.php" class="back-arrow">
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
				<div class="post-form-title">
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
				</div>
				<form method="post" action="" enctype="multipart/form-data">
					<div class="from-box">
						<select name="cat_id" onchange='loadsubcat(this.value)' class="each-field">
							<option value="" >Select Your Category</option>
							<?php foreach ($findcat as $key => $val) { ?>
								<option value="<?php echo $val["cat_id"]; ?>"
								<?php if(isset($_GET['cat_id'])){ if(($_REQUEST['cat_id'])==$val["cat_id"]){ echo "selected";} } 
						 		?>
								><?php echo $val["cat_name"]; ?></option>
							<?php } ?>
						</select>
						<select name="sub_cat_id" class="each-field sub_cat_id" onchange="loadspecification(this.value)">
						<option value="" >Select Your Sub Category</option>
							<!-- <option value=""></option> -->
						</select>
						<!-- <select name="specification" class="each-field  specification">
							<option value="" selected>Select Specifications</option>
							
						</select> -->

						<div class="btn-action float-clear mt-2">
							<input type='hidden' id="hid_sub_cat_id">
							<input type="button" name="add_item" value="Add Specification More"
								onClick="addMore();" /> <input type="button"
								name="del_item" value="Delete"
								onClick="deleteRow();" /> <span id="delete-button-required"></span>
								<span id="error" class="<?php  if(!empty ($response["type"])) { echo $response["type"]; } ?>"><?php  if(!empty ($response["message"])) { echo $response["message"]; } ?></span>
						</div>
						<div id='product'>
							
						</div>

						<label>More Information</label>
						<input type="text" name="title" class="each-field" placeholder="Ad Title" >
						<textarea name="description" rows="" cols="" class="each-field" placeholder="Description" ></textarea>
						<p>Include Product Description, Features</p>
					</div>
					<div class="from-box">						
						<label>Set a Price</label>	
						<input type="text" name="price" class="each-field" placeholder="Price" >
					</div>
					<div class="from-box">						
						
						<label>Select City</label>	
						<select name="city" class="each-field">
							<option value="" selected>City</option>
							<?php foreach ($findcity as $key => $val) { ?>
								<option value="<?php echo $val["city_id"]; ?>"><?php echo $val["city_name"]; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="upload__box">
						<div id="" class="">
							<label>Choose Photos</label>
						</div>
					  <div class="upload__btn-box">
						<label class="upload__btn">
							<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M39 16.5H25.5V3C25.5 1.34344 24.1566 0 22.5 0H19.5C17.8434 0 16.5 1.34344 16.5 3V16.5H3C1.34344 16.5 0 17.8434 0 19.5V22.5C0 24.1566 1.34344 25.5 3 25.5H16.5V39C16.5 40.6566 17.8434 42 19.5 42H22.5C24.1566 42 25.5 40.6566 25.5 39V25.5H39C40.6566 25.5 42 24.1566 42 22.5V19.5C42 17.8434 40.6566 16.5 39 16.5Z" fill="#959494"/>
							</svg>
							
						  <input type="file" name="fileToUpload[]" multiple data-max_length="20" class="upload__inputfile">
						</label>
					  </div>
					  <div class="upload__img-wrap"></div>
					</div>
					<div id="" class="text-right">
						<input type="submit" name="submit" value="submit" class="submit">
					</div>
				</form>					
			</section>			
		</main>
		<!-- Footer area -->
		
		<!-- End::Footer area -->
		<!-- All js links -->
		<script src="assets/js/swiper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/custom.js"></script>
		<script type="text/javascript">
		
			jQuery(document).ready(function () {
			  ImgUpload();
			});

			function ImgUpload() {
			  var imgWrap = "";
			  var imgArray = [];

			  $('.upload__inputfile').each(function () {
				$(this).on('change', function (e) {
				  imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
				  var maxLength = $(this).attr('data-max_length');

				  var files = e.target.files;
				  var filesArr = Array.prototype.slice.call(files);
				  var iterator = 0;
				  filesArr.forEach(function (f, index) {

					if (!f.type.match('image.*')) {
					  return;
					}

					if (imgArray.length > maxLength) {
					  return false
					} else {
					  var len = 0;
					  for (var i = 0; i < imgArray.length; i++) {
						if (imgArray[i] !== undefined) {
						  len++;
						}
					  }
					  if (len > maxLength) {
						return false;
					  } else {
						imgArray.push(f);

						var reader = new FileReader();
						reader.onload = function (e) {
						  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
						  imgWrap.append(html);
						  iterator++;
						}
						reader.readAsDataURL(f);
					  }
					}
				  });
				});
			  });

			  $('body').on('click', ".upload__img-close", function (e) {
				var file = $(this).parent().data("file");
				for (var i = 0; i < imgArray.length; i++) {
				  if (imgArray[i].name === file) {
					imgArray.splice(i, 1);
					break;
				  }
				}
				$(this).parent().parent().remove();
			  });
			}
			/**************************/
			function create_custom_dropdowns() {
				$('select.spl').each(function (i, select) {
					if (!$(this).next().hasClass('dropdown-select')) {
						$(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>');
						var dropdown = $(this).next();
						var options = $(select).find('option');
						var selected = $(this).find('option:selected');
						dropdown.find('.current').html(selected.data('display-text') || selected.text());
						options.each(function (j, o) {
							var display = $(o).data('display-text') || '';
							dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
						});
					}
				});

				$('.dropdown-select ul').before('<div class="dd-search"><input id="txtSearchValue" placeholder="Search Your Keyword" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>');
			}

			// Event listeners

			// Open/close
			$(document).on('click', '.dropdown-select', function (event) {
				if($(event.target).hasClass('dd-searchbox')){
					return;
				}
				$('.dropdown-select').not($(this)).removeClass('open');
				$(this).toggleClass('open');
				if ($(this).hasClass('open')) {
					$(this).find('.option').attr('tabindex', 0);
					$(this).find('.selected').focus();
				} else {
					$(this).find('.option').removeAttr('tabindex');
					$(this).focus();
				}
			});

			// Close when clicking outside
			$(document).on('click', function (event) {
				if ($(event.target).closest('.dropdown-select').length === 0) {
					$('.dropdown-select').removeClass('open');
					$('.dropdown-select .option').removeAttr('tabindex');
				}
				event.stopPropagation();
			});

			function filter(){
				var valThis = $('#txtSearchValue').val();
				$('.dropdown-select ul > li').each(function(){
				 var text = $(this).text();
					(text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show() : $(this).hide();         
			   });
			};
			// Search

			// Option click
			$(document).on('click', '.dropdown-select .option', function (event) {
				$(this).closest('.list').find('.selected').removeClass('selected');
				$(this).addClass('selected');
				var text = $(this).data('display-text') || $(this).text();
				$(this).closest('.dropdown-select').find('.current').text(text);
				$(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
			});

			// Keyboard events
			$(document).on('keydown', '.dropdown-select', function (event) {
				var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
				// Space or Enter
				//if (event.keyCode == 32 || event.keyCode == 13) {
				if (event.keyCode == 13) {
					if ($(this).hasClass('open')) {
						focused_option.trigger('click');
					} else {
						$(this).trigger('click');
					}
					return false;
					// Down
				} else if (event.keyCode == 40) {
					if (!$(this).hasClass('open')) {
						$(this).trigger('click');
					} else {
						focused_option.next().focus();
					}
					return false;
					// Up
				} else if (event.keyCode == 38) {
					if (!$(this).hasClass('open')) {
						$(this).trigger('click');
					} else {
						var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
						focused_option.prev().focus();
					}
					return false;
					// Esc
				} else if (event.keyCode == 27) {
					if ($(this).hasClass('open')) {
						$(this).trigger('click');
					}
					return false;
				}
			});

			$(document).ready(function () {
				create_custom_dropdowns();
			});


			function loadsubcat(cat_id){
				//window.location.href='?cat_id='+cat_id
				
				$.ajax({
					url:"ajax/get_subcate.php",
					method:"POST",
					data:{cat_id:cat_id, fetch_type:'fetch_subcat'}
				}).done(function(response){
					$('.sub_cat_id').html(response);
					
				});

			}
			
			function loadspecification(subcat_id)
			{
				$('#hid_sub_cat_id').val(subcat_id);
				$.ajax({
					url:"ajax/get_subcate.php",
					method:"POST",
					data:{subcat_id:subcat_id, fetch_type:'fetch_specification'}
				}).done(function(response){
					$('.specification').html(response);
					
				});
			}

			function addMore() {
				var subcat_id = $('#hid_sub_cat_id').val();
				$.ajax({
					url:"ajax/fetch_specification.php",
					method:"POST",
					data:{subcat_id:subcat_id, fetch_type:'fetch_specification'}
				}).done(function(response){
					$('#product').append(response);
					
				});
			}

			function deleteRow() {
				$('div.product-item').each(function(index, item) {
					jQuery(':checkbox', this).each(function() {
						if ($(this).is(':checked')) {
							$(item).remove();
							$("#delete-button-required").html("Choose at least 1 row.").css("color", "red").hide();
						}
						else {
							$("#delete-button-required").html("Choose at least 1 row.").css("color", "red").show();
							$("#error").hide();
						}
					});
				});
			}

			
			function goBack() {
				window.history.back()
				}


		//-->
		</script>
		<?php include("common.php"); ?>
	</body>
</html>