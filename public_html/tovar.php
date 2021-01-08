<?php
		require_once 'includes/config.php'; 
	require_once 'includes/db.php'; 
	include_once 'includes/loadingMainPage.php'; 
	?>
<!DOCTYPE HTML>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.carousel.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.theme.default.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:700, Nosifer" rel="stylesheet"> 
	

   <title>САД НИНФА</title>
</head>
<body>
		
	<?php 
		require_once 'includes/header.php';
	?>
	<section class="types-main container">
			<div class="types-sidebar">
				<form action="types.php" style="display: grid;">
				<?php 
					$full_searching="";
					if(isset($_REQUEST['full_searching'])){$full_searching = $_REQUEST['full_searching'];}?>
					<input type="text" name="full_searching" id="full_searching" 
				value='<?php echo trim($full_searching);?>'></input>
					<button id="searching_product">Поиск</button>
				</form>
				<?php
					getCategory($connection);
				?>
				<?php
					//getCategoryMobile($connection);
				?>
			</div>
			<div class="tovar-content">

				<?php 
					$idProduct=0;
					$resultString ="";
					if(isset($_REQUEST['idProduct'])){
						$idProduct = (int) $_REQUEST['idProduct'];
						$result = mysqli_query($connection, "select * from product where id = $idProduct") or die(mysqli_error($connection));
						if($result){
							while ($row = mysqli_fetch_assoc($result)) {
								$resultPhoto = mysqli_query($connection, "select * from photoproduct where idProduct = $idProduct") or die(mysqli_error($connection));
								$photo = mysqli_fetch_assoc($resultPhoto);

								if(strlen($photo['photo'])==0){
									$photo="nophoto.jpg";
								}
								else {
									$photo=$photo['photo'];
								}
								$coast="";
                    			if($row['coast']!=0){
                    			    $coast=number_format($row['coast'], 2, 'р', ',')."к";
                    			}
                    			else{
                    			    $coast="Уточняйте";
                    			}
								$resultString = "<div class='tovar-img'>
										<img src='".$config['constants']['path_img_flowers'].$photo."' alt=''>
										</div>
										<div class='tovar-opisanie'>
											<div class='opisanie-title'>
												<h2>".$row['title']."</h2>
											</div>
											<div class='opisanie-sostav'>
												<p>".$row['description']."</p>
											<div class='opisanie-coast'>
												<h2>".$coast."</h2>
											</div>	
										</div>";
							}
						}

					}
					echo "$resultString";
				?>

				
			</div>
	</section>
	
		
	
	<?php 
		require_once 'includes/footer.php';
	?>	
	<script src="js/jquery.min.js"></script>
	<script src="libs/owlcarousel/owl.carousel.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/script.js"></script>
	<script src="js/wow.min.js"></script>
    </script>

	<script>
	  new WOW().init();
	</script>

	
    

	



</body>
</html>